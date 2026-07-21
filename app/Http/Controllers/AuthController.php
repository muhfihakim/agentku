<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Tenant;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'company' => 'required|string|max:255',
        ]);

        try {
            $trialPlan = Plan::where('name', 'Trial')->first();
            $endsAt = $trialPlan ? now()->addDays($trialPlan->duration_days) : null;

            $tenantId = \Illuminate\Support\Str::slug($request->company) . '-' . uniqid();
            
            $tenant = Tenant::create([
                'id' => $tenantId,
                'plan_id' => $trialPlan ? $trialPlan->id : null,
                'plan_ends_at' => $endsAt ? $endsAt->toDateTimeString() : null,
                'company' => $request->company,
            ]);
            
            activity()->log("Klien baru mendaftar: {$request->company}");

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tenant_id' => $tenant->id,
            ]);

            $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
            $user->assignRole($roleAdmin);

            Auth::login($user);

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Pendaftaran gagal: ' . $e->getMessage()])->withInput();
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->hasRole('Owner')) {
                return redirect()->intended('/owner');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Kredensial salah.'],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
