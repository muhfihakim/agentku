<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function index()
    {
        $tenant = tenant();
        $plans = \App\Models\Plan::where('status', 'aktif')->get();
        $currentPlan = $tenant && $tenant->plan_id ? \App\Models\Plan::find($tenant->plan_id) : null;
        
        return view('client.settings.index', [
            'user' => auth()->user(), 
            'tenant' => $tenant,
            'plans' => $plans,
            'currentPlan' => $currentPlan
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('App\Models\User', 'email')->ignore(auth()->id())],
            'company' => 'required|string|max:255',
        ]);

        auth()->user()->update($request->only('name', 'email'));
        
        $tenant = tenant();
        if ($tenant) {
            $tenant->company = $request->company;
            $tenant->save();
        }

        activity()->log('Memperbarui profil dan data perusahaan');

        return back()->with('success', 'Profil dan perusahaan berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);
        activity()->log('Memperbarui kata sandi akun');
        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
