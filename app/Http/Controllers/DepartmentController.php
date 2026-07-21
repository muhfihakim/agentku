<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $departments = $query->paginate(10)->withQueryString();
        
        if ($request->ajax()) {
            usleep(500000);
            return response()->json([
                'html' => view('client.departments._table', compact('departments'))->render(),
                'pagination' => (string) $departments->links('pagination::bootstrap-4'),
                'total' => $departments->total()
            ]);
        }

        return view('client.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Department::create($request->all());
        activity()->log("Menambahkan departemen baru: {$request->name}");
        return back()->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());
        activity()->log("Memperbarui data departemen: {$request->name}");
        return back()->with('success', 'Departemen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        activity()->log("Menghapus departemen: {$department->name}");
        return back()->with('success', 'Departemen berhasil dihapus!');
    }
}
