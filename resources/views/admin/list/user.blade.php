@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Quản lý Người dùng</h4>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                        Tất cả
                    </button>
                </li>
                @foreach($roles as $role)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="role{{ $role->roel_id }}-tab" 
                            data-bs-toggle="tab" 
                            data-bs-target="#role{{ $role->role_id }}" 
                            type="button" 
                            role="tab">
                        {{ $role->name }}
                        <span class="badge bg-primary ms-1">{{ $users->where('role_id', $role->role_id)->count() }}</span>
                    </button>
                </li>
                @endforeach
            </ul>

            <!-- Tab content -->
            <div class="tab-content pt-3" id="userTabContent">
                <!-- Tab All Users -->
                <div class="tab-pane fade show active" id="all" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role)
                                                <span class="badge bg-info">{{ $user->role->name }}</span>
                                            @else
                                                <span class="badge bg-secondary">Chưa phân quyền</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $user->status ? 'Hoạt động' : 'Khóa' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->user_id) }}" 
                                               class="btn btn-outline-primary btn-sm me-1"
                                               data-bs-toggle="tooltip" 
                                               title="Chỉnh sửa">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->user_id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        data-bs-toggle="tooltip" 
                                                        title="Xóa">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center">Không có người dùng nào</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>

                <!-- Tabs for each role -->
                @foreach($roles as $role)
                <div class="tab-pane fade" id="role{{ $role->role_id }}" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $roleUsers = $users->where('role_id', $role->role_id);
                                @endphp
                                
                                @forelse ($roleUsers as $user)
                                    <tr>
                                        <td>{{ $user->user_id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $user->is_active ? 'Hoạt động' : 'Khóa' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->user_id) }}" 
                                               class="btn btn-outline-primary btn-sm me-1">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', $user->user_id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm"
                                                        onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center">Không có người dùng nào thuộc nhóm này</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
        border: none;
        padding: 0.75rem 1.25rem;
        position: relative;
    }
    
    .nav-tabs .nav-link.active {
        color: #0d6efd;
        background-color: transparent;
        border-bottom: 3px solid #0d6efd;
    }
    
    .nav-tabs .nav-link:hover:not(.active) {
        border-bottom: 3px solid #dee2e6;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
</style>
@endsection

@push('scripts')
<script>
    // Khởi tạo tooltip
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush