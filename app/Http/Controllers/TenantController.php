<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        // Dummy revenue calculation for UI
        $totalRevenue = count($tenants) * 500000;
        return view('owner.dashboard', compact('tenants', 'totalRevenue'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|unique:tenants,id|regex:/^[a-zA-Z0-9\-]+$/',
            'company_name' => 'required|string',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|min:6',
        ]);

        $tenantId = strtolower($request->id);

        $tenant = Tenant::create([
            'id' => $tenantId,
            'company_name' => $request->company_name,
        ]);

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
        $tenant->delete();
        
        return back()->with('success', 'Client berhasil dihapus!');
    }
}
