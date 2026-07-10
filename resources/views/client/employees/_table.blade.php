@php 
    $start = ($employees->currentPage() - 1) * $employees->perPage() + 1; 
@endphp
@foreach($employees as $index => $employee)
<tr>
    <td>{{ $start + $index }}</td>
    <td>
        <div class="table-user">
            <div class="table-user-avatar" style="background: #6366f1;">{{ strtoupper(substr($employee->name, 0, 2)) }}</div>
            <div style="display: flex; flex-direction: column;">
                <span style="font-weight: 500; color: #111827;">{{ $employee->name }}</span>
                <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">{{ $employee->email }}</small>
            </div>
        </div>
    </td>
    <td>{{ $employee->department ? $employee->department->name : '-' }}</td>
    <td>{{ $employee->device_info ?? '-' }}</td>
    <td>
        @if($employee->os_info)
            <i class="ph ph-windows-logo"></i> {{ $employee->os_info }}
        @else
            -
        @endif
    </td>
    <td>
        @if($employee->status === 'online' || $employee->status === 'active')
            <span class="badge badge-active">Active</span>
        @elseif($employee->status === 'idle')
            <span class="badge badge-idle">Idle</span>
        @else
            <span class="badge badge-offline">Offline</span>
        @endif
    </td>
    <td>{{ $employee->last_active_at ? $employee->last_active_at->diffForHumans() : '-' }}</td>
    <td>
        <div class="table-actions">
            <button onclick="openEditEmployeeModal({{ $employee->id }}, '{{ htmlspecialchars($employee->name, ENT_QUOTES) }}', '{{ htmlspecialchars($employee->email, ENT_QUOTES) }}', '{{ $employee->department_id }}')" class="btn btn-ghost btn-sm" style="color: #10b981;" title="Edit"><i class="ph ph-pencil-simple"></i> Edit</button>
            <button onclick="confirmDelete({{ $employee->id }})" class="btn btn-ghost btn-sm" style="color: #ef4444;" title="Hapus"><i class="ph ph-trash"></i> Hapus</button>
            <form id="delete-form-{{ $employee->id }}" action="{{ route('client.employees.destroy', $employee->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </td>
</tr>
@endforeach
@if($employees->isEmpty())
<tr>
    <td colspan="8" class="empty-state-td" style="color: #6b7280; text-align: center; padding: 2rem;">
        Data tidak ditemukan
    </td>
</tr>
@endif
