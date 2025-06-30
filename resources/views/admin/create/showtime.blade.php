@extends('layouts.admin')

@section('content')
<form action="#" method="post">
  <div class="row g-4">
    <!-- Left Column: Main Form -->
    <div class="col-lg-8">
      <div class="card shadow-sm border-0 rounded-3 h-100">
        <div class="card-header bg-light py-3">
          <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-calendar-plus me-2"></i>Thêm suất chiếu mới
          </h5>
        </div>
        
        <div class="card-body p-4">
          <div class="row g-3">
            <!-- Movie Selection -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
              <select class="form-select" required>
                <option value="" selected disabled>--- Chọn phim ---</option>
                <option value="1">Avengers: Endgame</option>
                <option value="2">Inside Out 2</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label fw-semibold">Phiên bản phim <span class="text-danger">*</span></label>
              <select class="form-select" required>
                <option value="" selected disabled>--- Chọn phiên bản ---</option>
                <option value="2d-sub">2D Phụ đề</option>
                <option value="3d-dub">3D Lồng tiếng</option>
              </select>
            </div>
            
            <!-- Location Selection -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Chi nhánh <span class="text-danger">*</span></label>
              <select class="form-select" required>
                <option value="" selected disabled>--- Chọn chi nhánh ---</option>
                <option value="1">LumiStar Gò Vấp</option>
                <option value="2">LumiStar Quận 1</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label fw-semibold">Rạp chiếu <span class="text-danger">*</span></label>
              <select class="form-select" required>
                <option value="" selected disabled>--- Chọn rạp ---</option>
                <option value="1">Rạp 1</option>
                <option value="2">Rạp 2</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label fw-semibold">Phòng chiếu <span class="text-danger">*</span></label>
              <select class="form-select" required>
                <option value="" selected disabled>--- Chọn phòng ---</option>
                <option value="1">Phòng 1 (120 chỗ)</option>
                <option value="2">Phòng VIP (50 chỗ)</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label fw-semibold">Ngày chiếu <span class="text-danger">*</span></label>
              <input type="date" class="form-control" required>
            </div>
            
            <!-- Auto Schedule -->
            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="autoCreate" role="switch">
                <label class="form-check-label fw-semibold" for="autoCreate">
                  Tự động tạo suất chiếu trong ngày
                </label>
                <div class="form-text">Hệ thống sẽ tự động tạo các suất chiếu cách nhau 30 phút</div>
              </div>
            </div>
            
            <!-- Manual Schedule -->
            <div class="col-md-6">
              <label class="form-label fw-semibold">Giờ bắt đầu <span class="text-danger">*</span></label>
              <input type="time" class="form-control" required>
            </div>
            
            <div class="col-md-6">
              <label class="form-label fw-semibold">Giờ kết thúc</label>
              <input type="time" class="form-control" readonly>
              <div class="form-text">Tự động tính theo thời lượng phim</div>
            </div>
            
            <!-- Time Slots -->
            <div class="col-12">
              <div class="card border-0 bg-light">
                <div class="card-body p-3">
                  <h6 class="fw-semibold mb-3">Các suất đã thêm</h6>
                  <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                      09:00 - 11:01 <button class="btn btn-close btn-close-white btn-sm ms-1"></button>
                    </span>
                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                      13:30 - 15:31 <button class="btn btn-close btn-close-white btn-sm ms-1"></button>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-12">
              <button type="button" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-2"></i>Thêm suất chiếu
              </button>
            </div>
          </div>
        </div>
        
        <!-- Form Footer -->
        <div class="card-footer bg-light py-3">
          <div class="d-flex justify-content-between">
            <a href="list_xuatchieu.html" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-2"></i>Quay lại
            </a>
            <button type="submit" class="btn btn-primary px-4">
              <i class="bi bi-check-circle me-2"></i>Lưu suất chiếu
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Right Column: Existing Schedule -->
    <div class="col-lg-4">
      <div class="card shadow-sm border-0 rounded-3 h-100">
        <div class="card-header bg-light py-3">
          <h5 class="mb-0 fw-bold">
            <i class="bi bi-calendar3 me-2"></i>Lịch chiếu hiện có
          </h5>
        </div>
        
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="table-light">
                <tr>
                  <th>Thời gian</th>
                  <th>Phòng</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>09:00 - 11:01</td>
                  <td>Phòng 5</td>
                  <td><span class="badge bg-success bg-opacity-10 text-success">Đã xác nhận</span></td>
                </tr>
                <tr>
                  <td>13:30 - 15:31</td>
                  <td>Phòng 3</td>
                  <td><span class="badge bg-warning bg-opacity-10 text-warning">Chờ duyệt</span></td>
                </tr>
                <tr>
                  <td>18:00 - 20:01</td>
                  <td>Phòng VIP</td>
                  <td><span class="badge bg-success bg-opacity-10 text-success">Đã xác nhận</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        
        <div class="card-footer bg-light py-3">
          <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm justify-content-center mb-0">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1"><i class="bi bi-chevron-left"></i></a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item">
                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
