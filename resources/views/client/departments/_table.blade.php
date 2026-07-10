@php 
    $start = ($departments->currentPage() - 1) * $departments->perPage() + 1; 
@endphp
@foreach($departments as $index => $dept)
<tr>
    <td>{{ $start + $index }}</td>
    <td>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 36px; height: 36px; border-radius: 0.5rem; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                <i class="ph ph-buildings" style="font-size: 1.25rem;"></i>
            </div>
            <span style="font-weight: 500; color: #111827;">{{ $dept->name }}</span>
        </div>
    </td>
    <td style="color: #6b7280;">{{ $dept->description ?? '-' }}</td>
    <td>
        <div class="table-actions">
            <button onclick="openEditDepartmentModal({{ $dept->id }}, '{{ htmlspecialchars($dept->name, ENT_QUOTES) }}', '{{ htmlspecialchars($dept->description, ENT_QUOTES) }}')" class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i class="ph ph-pencil-simple"></i> Edit</button>
            <button onclick="confirmDelete({{ $dept->id }})" class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i class="ph ph-trash"></i> Hapus</button>
            <form id="delete-form-{{ $dept->id }}" action="{{ route('client.departments.destroy', $dept->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </td>
</tr>
@endforeach
@if($departments->isEmpty())
<tr>
    <td colspan="4" style="text-align: center; padding: 2rem; color: #6b7280;">
        <i class="ph ph-folder-open" style="font-size: 2rem; margin-bottom: 0.5rem; display: block; color: #9ca3af;"></i>
        Data tidak ditemukan
    </td>
</tr>
@endif
