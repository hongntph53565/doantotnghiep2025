@extends('layouts.admin')

@section('content')
        <div class="card shadow-sm rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Quản lý Phân quyền</h4>
                <button class="btn btn-success">+ Thêm vai trò</button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên vai trò</th>
                            <th>Quyền</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Quản trị viên</td>
                            <td>
                                <span class="badge bg-primary">Quản lý người dùng</span>
                                <span class="badge bg-primary">Quản lý đánh giá</span>
                                <span class="badge bg-primary">Phân quyền</span>
                            </td>
                            <td>2025-06-01</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info text-white me-1" title="Chi tiết">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary me-1" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xoá">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Nhân viên</td>
                            <td>
                                <span class="badge bg-secondary">Xem đánh giá</span>
                            </td>
                            <td>2025-06-02</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info text-white me-1" title="Chi tiết">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-primary me-1" title="Chỉnh sửa">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Xoá">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Thêm vai trò khác tại đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/.js') }}"></script>
@endpush