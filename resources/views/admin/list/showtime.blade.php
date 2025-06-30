@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm mt-3">
    <div class="card-body p-0">
        <!-- Filter Section -->
        <div class="container-fluid bg-light p-4 rounded-top">
            <div class="row align-items-end g-3">
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Chi nhánh</label>
                    <select class="form-select form-select-sm">
                        <option selected>Tất cả chi nhánh</option>
                        <option>Branch 1</option>
                        <option>Branch 2</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Rạp</label>
                    <select class="form-select form-select-sm">
                        <option selected>Tất cả rạp</option>
                        <option>Cinema 1</option>
                        <option>Cinema 2</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Từ ngày</label>
                    <input type="date" class="form-control form-control-sm" value="2025-03-23">
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Đến ngày</label>
                    <input type="date" class="form-control form-control-sm" value="2025-03-30">
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6">
                    <label class="form-label fw-semibold small">Trạng thái</label>
                    <select class="form-select form-select-sm">
                        <option selected>Tất cả</option>
                        <option>Đang chiếu</option>
                        <option>Sắp chiếu</option>
                        <option>Đã hủy</option>
                    </select>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 d-flex gap-2">
                    <button class="btn btn-sm btn-primary flex-grow-1">
                        <i class="bi bi-funnel me-1"></i> Lọc
                    </button>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="d-flex justify-content-between align-items-center p-3 bg-white border-top border-bottom">
            <div class="text-muted small">
                Hiển thị <strong>1-10</strong> trong <strong>25</strong> kết quả
            </div>
            <div>
                <button class="btn btn-sm btn-success" onclick="window.location.href='create_xuatchieu.html'">
                    <i class="bi bi-plus-circle me-1"></i> Thêm xuất chiếu
                </button>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="25%">Phim</th>
                        <th width="15%">Ngày chiếu</th>
                        <th width="15%">Suất chiếu</th>
                        <th width="15%">Phòng</th>
                        <th width="15%">Trạng thái</th>
                        <th width="15%" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50x75" class="rounded me-3" alt="Poster">
                                <div>
                                    <div class="fw-semibold">Avengers: Endgame</div>
                                    <small class="text-muted">181 phút - 2D Phụ đề</small>
                                </div>
                            </div>
                        </td>
                        <td>25/06/2025</td>
                        <td>14:30 - 17:31</td>
                        <td>Phòng 5</td>
                        <td>
                            <span class="badge bg-success bg-opacity-10 text-success">Đang chiếu</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-icon btn-sm btn-outline-primary" 
                                        onclick="window.location.href='edit_xuatchieu.html?id=1'">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50x75" class="rounded me-3" alt="Poster">
                                <div>
                                    <div class="fw-semibold">Inside Out 2</div>
                                    <small class="text-muted">95 phút - 3D Lồng tiếng</small>
                                </div>
                            </div>
                        </td>
                        <td>26/06/2025</td>
                        <td>09:00 - 10:35</td>
                        <td>Phòng 3</td>
                        <td>
                            <span class="badge bg-warning bg-opacity-10 text-warning">Sắp chiếu</span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-icon btn-sm btn-outline-primary"
                                        onclick="window.location.href='edit_xuatchieu.html?id=2'">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <button class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center p-3 bg-white border-top">
            <div class="text-muted small">
                Hiển thị <strong>1-10</strong> trong <strong>25</strong> kết quả
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Trước</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Tiếp</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                Bạn có chắc chắn muốn xóa xuất chiếu này? Thao tác này không thể hoàn tác.
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-danger">Xác nhận xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection