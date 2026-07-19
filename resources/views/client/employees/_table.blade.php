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
        @if($employee->device_token)
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <code style="background:#f3f4f6; padding:0.25rem 0.5rem; border-radius:0.25rem; font-size:0.75rem; color:#4b5563;">{{ substr($employee->device_token, 0, 8) }}...</code>
                <button onclick="navigator.clipboard.writeText('{{ $employee->device_token }}'); alert('Token dicopy!');" class="btn btn-ghost btn-sm" style="padding:0.25rem; color:#3b82f6;" title="Copy Token"><i class="ph ph-copy"></i></button>
            </div>
        @else
            -
        @endif
    </td>
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
            @if($employee->device_token)
                <button onclick="event.preventDefault(); if(confirm('Revoke token?')) document.getElementById('revoke-form-{{ $employee->id }}').submit();" class="btn btn-ghost btn-sm" style="color: #f59e0b;" title="Revoke"><i class="ph ph-prohibit"></i> Revoke</button>
                <form id="revoke-form-{{ $employee->id }}" action="{{ route('client.employees.revoke', $employee->id) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endif
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
