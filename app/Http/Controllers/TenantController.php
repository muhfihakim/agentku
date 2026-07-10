<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Plan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();
        
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->whereRaw("LOWER(json_unquote(json_extract(data, '$.company_name'))) LIKE ?", ["%{$search}%"])
                  ->orWhere('id', 'like', "%{$search}%");
        }
        
        if ($request->filled('billing_status') && $request->billing_status != 'all') {
            $status = $request->billing_status;
            if ($status == 'lunas') {
                $query->where(function($q) {
                    $q->whereRaw("json_unquote(json_extract(data, '$.billing_status')) = 'lunas'")
                      ->orWhereRaw("json_extract(data, '$.billing_status') IS NULL");
                });
            } else {
                $query->whereRaw("json_unquote(json_extract(data, '$.billing_status')) = ?", [$status]);
            }
        }
        
        if ($request->filled('account_status') && $request->account_status != 'all') {
            $accStatus = $request->account_status;
            if ($accStatus == 'aktif') {
                $query->where(function($q) {
                    $q->whereRaw("json_unquote(json_extract(data, '$.account_status')) = 'aktif'")
                      ->orWhereRaw("json_extract(data, '$.account_status') IS NULL");
                });
            } else {
                $query->whereRaw("json_unquote(json_extract(data, '$.account_status')) = ?", [$accStatus]);
            }
        }
        
        $tenants = $query->with('user')->latest()->paginate(5);
        $totalRevenue = Tenant::count() * 500000;

        if ($request->ajax()) {
            usleep(500000); // Delay 0.5 detik supaya aman dan loading terlihat
            $html = '';
            
            if ($tenants->isEmpty()) {
                $html = '<tr><td colspan="8" style="text-align: center; padding: 2rem; color: #6b7280;"><i class="ph ph-folder-open" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; color: #9ca3af;"></i>Data tidak ditemukan</td></tr>';
            } else {
                $plansList = Plan::all()->keyBy('id');
                $start = ($tenants->currentPage() - 1) * $tenants->perPage() + 1;
                foreach ($tenants as $index => $tenant) {
                    $nomor = $start + $index;
                    $status = $tenant->billing_status ?? 'lunas';
                    $badge = $status == 'lunas' ? '<span class="badge badge-active">Lunas</span>' : '<span class="badge" style="background:#fef3c7; color:#d97706;">Ditangguhkan</span>';

                    $accStatus = $tenant->account_status ?? 'aktif';
                    $accBadge = $accStatus == 'aktif' ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge" style="background:#fee2e2; color:#ef4444;">Nonaktif</span>';

                    $planName = isset($tenant->plan_id) && isset($plansList[$tenant->plan_id]) ? $plansList[$tenant->plan_id]->name : 'Belum Ada';

                    $email = $tenant->user->email ?? 'N/A';
                    $endDate = isset($tenant->billing_end_date) ? \Carbon\Carbon::parse($tenant->billing_end_date)->format('d M Y') : '-';
                    $html .= '
                    <tr>
                        <td>' . $nomor . '</td>
                        <td>' . $tenant->id . '</td>
                        <td>' . ($tenant->company_name ?? 'N/A') . '</td>
                        <td>' . $email . '</td>
                        <td><span class="badge" style="background:#f3f4f6; color:#4b5563;">' . htmlspecialchars($planName) . '</span></td>
                        <td>' . $accBadge . '</td>
                        <td>' . $badge . '</td>
                        <td><span style="color: #4b5563; font-weight: 500;">' . $endDate . '</span></td>
                        <td>
                            <button onclick="openDetailModal(\'' . $tenant->id . '\', \'' . htmlspecialchars($tenant->company_name ?? 'N/A', ENT_QUOTES) . '\', \'' . \Carbon\Carbon::parse($tenant->created_at)->format('d M Y') . '\')" class="btn btn-ghost btn-sm" style="color: #3b82f6;" title="Detail"><i class="ph ph-eye"></i> Detail</button>
                            <button onclick="openEditModal(\'' . $tenant->id . '\', \'' . htmlspecialchars($tenant->company_name ?? '', ENT_QUOTES) . '\', \'' . $accStatus . '\', \'' . ($tenant->plan_id ?? '') . '\')" class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i class="ph ph-pencil-simple"></i> Edit</button>
                            <button onclick="confirmDelete(\'' . $tenant->id . '\')" class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i class="ph ph-trash"></i> Hapus</button>
                            <form id="delete-form-' . $tenant->id . '" action="' . route('owner.tenants.destroy', $tenant->id) . '" method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                            </form>
                        </td>
                    </tr>';
                }
            }
            return response()->json([
                'html' => $html,
                'pagination' => (string) $tenants->links('components.pagination'),
                'total' => $tenants->total()
            ]);
        }

        $totalClient = Tenant::count();
        $totalLunas = Tenant::whereRaw("json_unquote(json_extract(data, '$.billing_status')) = 'lunas'")
                            ->orWhereRaw("json_extract(data, '$.billing_status') IS NULL")
                            ->count();
        $totalDitangguhkan = Tenant::whereRaw("json_unquote(json_extract(data, '$.billing_status')) = 'ditangguhkan'")->count();

        $availablePlans = Plan::where('status', 'aktif')->get();

        return view('owner.dashboard', compact('tenants', 'totalClient', 'totalLunas', 'totalDitangguhkan', 'availablePlans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:tenants,id|regex:/^[a-zA-Z0-9\-]+$/',
            'company_name' => 'required|string',
            'plan_id' => 'nullable|exists:plans,id',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:6',
        ]);

        $tenantId = strtolower($request->id);

        $tenantData = [
            'id' => $tenantId,
            'company_name' => $request->company_name,
            'account_status' => $request->account_status ?? 'aktif',
            'plan_id' => $request->plan_id,
        ];

        if ($request->plan_id) {
            $plan = Plan::find($request->plan_id);
            if ($plan) {
                $tenantData['billing_start_date'] = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $tenantData['billing_end_date'] = \Carbon\Carbon::now()->addDays($plan->duration_days)->format('Y-m-d H:i:s');
                $tenantData['billing_status'] = 'lunas';
            }
        }

        $tenant = Tenant::create($tenantData);

        $admin = User::create([
            'name' => 'Admin ' . $request->company_name,
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'tenant_id' => $tenant->id,
        ]);
        
        $admin->assignRole('Admin');

        return back()->with('success', 'Client berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $tenant = Tenant::findOrFail($id);
        User::where('tenant_id', $tenant->id)->delete();
        
        try {
            $tenant->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            if (str_contains($e->getMessage(), "Can't drop database")) {
                \Illuminate\Support\Facades\DB::table('tenants')->where('id', $id)->delete();
            } else {
                throw $e;
            }
        }
        
        return back()->with('success', 'Client berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required|string',
            'account_status' => 'required|in:aktif,nonaktif',
            'plan_id' => 'nullable|exists:plans,id',
        ]);

        $tenant = Tenant::findOrFail($id);
        $updateData = [
            'company_name' => $request->company_name,
            'account_status' => $request->account_status,
            'plan_id' => $request->plan_id,
        ];

        if ($request->plan_id && $tenant->plan_id != $request->plan_id) {
            $plan = Plan::find($request->plan_id);
            if ($plan) {
                $updateData['billing_start_date'] = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                $updateData['billing_end_date'] = \Carbon\Carbon::now()->addDays($plan->duration_days)->format('Y-m-d H:i:s');
                $updateData['billing_status'] = 'lunas';
            }
        }

        $tenant->update($updateData);

        if ($request->filled('admin_password')) {
            $admin = User::where('tenant_id', $tenant->id)->first();
            if ($admin) {
                $admin->update([
                    'password' => Hash::make($request->admin_password)
                ]);
            }
        }

        return back()->with('success', 'Data Client berhasil diupdate!');
    }
}
