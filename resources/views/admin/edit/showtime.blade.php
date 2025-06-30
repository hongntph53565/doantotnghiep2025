@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0 rounded-3 mt-3">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-film me-2"></i>Thông tin suất chiếu
        </h5>
    </div>
    
    <div class="card-body p-4">
        <form action="#" method="POST">
            <div class="row g-3">
                <!-- Movie Information -->
                <div class="col-md-6">
                    <label for="movie" class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="movie" name="movie" placeholder="Nhập tên phim" required>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#movieModal">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label for="genre" class="form-label fw-semibold">Thể loại</label>
                    <select class="form-select" id="genre" name="genre" multiple>
                        <option value="action">Hành động</option>
                        <option value="comedy">Hài</option>
                        <option value="horror">Kinh dị</option>
                        <option value="drama">Tâm lý</option>
                        <option value="sci-fi">Khoa học viễn tưởng</option>
                    </select>
                    <div class="form-text">Chọn một hoặc nhiều thể loại</div>
                </div>
                
                <!-- Location Information -->
                <div class="col-md-6">
                    <label for="cinema" class="form-label fw-semibold">Rạp chiếu <span class="text-danger">*</span></label>
                    <select class="form-select" id="cinema" name="cinema" required>
                        <option value="" selected disabled>-- Chọn rạp --</option>
                        <option value="1">LumiStar Gò Vấp</option>
                        <option value="2">LumiStar Quận 1</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="room" class="form-label fw-semibold">Phòng chiếu <span class="text-danger">*</span></label>
                    <select class="form-select" id="room" name="room" required>
                        <option value="" selected disabled>-- Chọn phòng --</option>
                        <option value="101">Phòng 101 (120 chỗ)</option>
                        <option value="102">Phòng 102 (80 chỗ)</option>
                        <option value="vip">Phòng VIP (50 chỗ)</option>
                    </select>
                </div>
                
                <!-- Schedule Information -->
                <div class="col-md-4">
                    <label for="startdate" class="form-label fw-semibold">Ngày chiếu <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                        <input type="date" class="form-control" id="startdate" name="startdate" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label for="showtime" class="form-label fw-semibold">Giờ bắt đầu <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                        <input type="time" class="form-control" id="showtime" name="showtime" required>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label for="endtime" class="form-label fw-semibold">Giờ kết thúc</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-clock"></i></span>
                        <input type="time" class="form-control" id="endtime" name="endtime" readonly>
                    </div>
                    <div class="form-text">Tự động tính theo thời lượng phim</div>
                </div>
                
                <!-- Additional Options -->
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="repeatSchedule" name="repeatSchedule">
                        <label class="form-check-label fw-semibold" for="repeatSchedule">
                            Lặp lại suất chiếu hàng tuần
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="list_xuatchieu.html" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-2"></i>Danh sách
                </a>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-danger px-4">
                        <i class="bi bi-x-circle me-2"></i>Hủy
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-2"></i>Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Movie Search Modal -->
<div class="modal fade" id="movieModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chọn phim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Movie search results would go here -->
                <p class="text-center py-4">Danh sách phim sẽ được hiển thị tại đây</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary">Chọn phim</button>
            </div>
        </div>
    </div>
</div>
@endsection
