<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Tenant;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $query = Plan::query();
        
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where('name', 'like', "%{$search}%");
        }
        
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        $plans = $query->latest()->paginate(5);
        
        $tenantCounts = Tenant::selectRaw("json_unquote(json_extract(data, '$.plan_id')) as plan_id, count(*) as total")
            ->whereRaw("json_extract(data, '$.plan_id') IS NOT NULL")
            ->groupBy('plan_id')
            ->pluck('total', 'plan_id');

        if ($request->ajax()) {
            usleep(500000); // Delay 0.5 detik supaya aman dan loading terlihat
            $html = '';
            
            if ($plans->isEmpty()) {
                $html = '<tr><td colspan="7" class="empty-state-td" style="color: #6b7280;"><i class="ph ph-folder-open" style="font-size: 2.5rem; color: #9ca3af;"></i>Data tidak ditemukan</td></tr>';
            } else {
                $start = ($plans->currentPage() - 1) * $plans->perPage() + 1;
                foreach ($plans as $index => $plan) {
                    $nomor = $start + $index;
                    $badge = $plan->status == 'aktif' ? '<span class="badge badge-active">Aktif</span>' : '<span class="badge" style="background:#fef3c7; color:#d97706;">Draft</span>';

                    $html .= '
                    <tr>
                        <td>' . $nomor . '</td>
                        <td>' . htmlspecialchars($plan->name) . '</td>
                        <td>Rp ' . number_format($plan->price, 0, ',', '.') . '</td>
                        <td>' . $plan->agent_limit . ' Agen</td>
                        <td>' . $plan->duration_days . ' Hari</td>
                        <td><span style="font-weight: 500; color: #3b82f6;">' . ($tenantCounts[$plan->id] ?? 0) . ' Client</span></td>
                        <td>' . $badge . '</td>
                        <td>
                            <button onclick="openEditModal(\'' . $plan->id . '\', \'' . htmlspecialchars($plan->name, ENT_QUOTES) . '\', \'' . $plan->price . '\', \'' . $plan->agent_limit . '\', \'' . $plan->duration_days . '\', \'' . $plan->status . '\')" class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i class="ph ph-pencil-simple"></i> Edit</button>
                            <button onclick="confirmDelete(\'' . $plan->id . '\')" class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i class="ph ph-trash"></i> Hapus</button>
                            <form id="delete-form-' . $plan->id . '" action="' . route('owner.plans.destroy', $plan->id) . '" method="POST" style="display: none;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                            </form>
                        </td>
                    </tr>';
                }
            }
            return response()->json([
                'html' => $html,
                'pagination' => (string) $plans->links('components.pagination'),
                'total' => $plans->total()
            ]);
        }

        $totalPlans = Plan::count();
        $totalActive = Plan::where('status', 'aktif')->count();
        $totalDraft = Plan::where('status', 'draft')->count();

        return view('owner.billing', compact('plans', 'totalPlans', 'totalActive', 'totalDraft', 'tenantCounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'agent_limit' => 'required|integer|min:1',
            'duration_days' => 'required|integer|min:1',
            'status' => 'required|in:aktif,draft',
        ]);

        Plan::create($request->all());

        return back()->with('success', 'Paket berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'agent_limit' => 'required|integer|min:1',
            'duration_days' => 'required|integer|min:1',
            'status' => 'required|in:aktif,draft',
        ]);

        $plan = Plan::findOrFail($id);
        $plan->update($request->all());

        return back()->with('success', 'Paket berhasil diupdate!');
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        
        return back()->with('success', 'Paket berhasil dihapus!');
    }
}
