<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('department');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->has('department_id') && $request->department_id != '') {
            $query->where('department_id', $request->department_id);
        }

        $employees = $query->paginate(10)->withQueryString();
        
        $departments = Department::all();
        
        if ($request->ajax()) {
            usleep(500000);
            return response()->json([
                'html' => view('client.employees._table', compact('employees'))->render(),
                'pagination' => (string) $employees->links('pagination::bootstrap-4'),
                'total' => $employees->total()
            ]);
        }

        return view('client.employees.index', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'department_id' => 'nullable|exists:departments,id',
            'device_info' => 'nullable|string',
            'os_info' => 'nullable|string',
        ]);

        $validated['device_token'] = \Illuminate\Support\Str::uuid()->toString();
        Employee::create($validated);

        activity()->log("Menambahkan karyawan baru: {$validated['name']}");

        return back()->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'department_id' => 'nullable|exists:departments,id',
            'device_info' => 'nullable|string',
            'os_info' => 'nullable|string',
        ]);

        $employee->update($validated);

        activity()->log("Memperbarui data karyawan: {$validated['name']}");

        return back()->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        activity()->log("Menghapus karyawan: {$employee->name}");
        return back()->with('success', 'Karyawan berhasil dihapus.');
    }

    public function revokeToken($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->device_token = null;
        $employee->status = 'offline';
        $employee->save();

        $tenantId = tenant('id');
        $cacheKey = 'agent_data_' . ($tenantId ? $tenantId . '_' : '') . $employee->id;
        
        $data = \Illuminate\Support\Facades\Cache::get($cacheKey, []);
        $data['status'] = 'offline';
        $data['user'] = $employee->id;
        \Illuminate\Support\Facades\Cache::put($cacheKey, $data, now()->addMinutes(5));

        $broadcastData = $data;
        unset($broadcastData['screen']);
        \App\Events\AgentDataReceived::dispatch($broadcastData);

        activity()->log("Mencabut akses device token milik karyawan: {$employee->name}");

        return back()->with('success', 'Token berhasil di-revoke dan status diubah jadi offline.');
    }

    public function generateToken($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->device_token = \Illuminate\Support\Str::uuid()->toString();
        $employee->save();
        activity()->log("Membuat ulang device token untuk karyawan: {$employee->name}");
        return back()->with('success', 'Token berhasil dibuat ulang.');
    }
}
