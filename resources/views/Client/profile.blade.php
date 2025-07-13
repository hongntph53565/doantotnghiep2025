@extends('layouts.app')

@section('title', 'Lịch Chiếu Rạp')
  @push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
@section('content')
<body style="background-color: #f7f7f7;">
  <div class="container py-5">
    <h4 class="text-center fw-bold mb-4">TÀI KHOẢN</h4>
    <div class="row g-4">
      <!-- Cột trái -->
      <div class="col-lg-8 col-md-12">
        <div class="account-box">
          <div class="d-flex align-items-center mb-3 flex-wrap">
            <div class="profile-img mx-auto mx-md-0">
              <i class="bi bi-person"></i>
            </div>
            <div class="ms-md-3 text-center text-md-start mt-3 mt-md-0">
              <h5>Gia Hung</h5>
              <div class="d-flex flex-wrap text-muted mb-1 small gap-2 justify-content-center justify-content-md-start">
                <span>Điểm RP: 0</span>
                <span class="text-muted">|</span>
                <span>Tổng visit: 0</span>
              </div>
              <div class="d-flex flex-wrap text-muted mb-1 small gap-2 justify-content-center justify-content-md-start">
                <span>Expired visit: 0</span>
                <span class="text-muted">|</span>
                <span>Active visit: 0</span>
              </div>
              <p class="mb-1 small">Tổng chi tiêu trong tháng (6/2025): 0 VNĐ</p>
              <small class="text-muted">
                Vui lòng đăng ảnh chân dung, thấy rõ mặt cỡ kích thước ngang 200px và dọc 200px (dung lượng dưới 1MB)
              </small>
            </div>
          </div>

          <form>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Họ *</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-md-6">
                <label class="form-label">Tên đệm và tên *</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Email *</label>
                <input type="email" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Mật khẩu *</label>
                <div class="input-group">
                  <input type="password" class="form-control">
                  <button type="button" class="btn btn-green">ĐỔI MẬT KHẨU</button>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Số điện thoại *</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Giới tính *</label>
                <select class="form-select">
                  <option selected disabled>Chọn giới tính</option>
                  <option>Nam</option>
                  <option>Nữ</option>
                  <option>Khác</option>
                </select>
              </div>
              <div class="col-12">
                <label class="form-label">Ngày sinh *</label>
                <div class="row g-2">
                  <div class="col-4"><input type="text" class="form-control" placeholder="Ngày"></div>
                  <div class="col-4"><input type="text" class="form-control" placeholder="Tháng"></div>
                  <div class="col-4"><input type="text" class="form-control" placeholder="Năm"></div>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label">Tỉnh/Thành phố *</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-12">
                <label class="form-label">Địa chỉ *</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-green px-4">CẬP NHẬT</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Cột phải -->
      <div class="col-lg-4 col-md-12">
        <div class="account-box border border-success rounded-3 p-3">
          <div class="d-flex align-items-start flex-wrap justify-content-center justify-content-md-start">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data=123456&size=100x100"
                 alt="QR"
                 class="me-md-3 mb-3 p-2 bg-white rounded shadow-sm"
                 style="width: 100px; height: 100px;">
            <div class="text-start small">
              <p class="mb-1"><strong>Tên đăng nhập:</strong><br>Hungpdh53540@gmail.com</p>
              <p class="mb-1"><strong>Số thẻ:</strong> ONLA1187860</p>
              <p class="mb-1"><strong>Hạng thẻ:</strong> Star</p>
              <p class="mb-0"><strong>Ngày đăng ký:</strong> 06/03/2025</p>
            </div>
          </div>
        </div>

        <div class="text-center mt-3">
          <button class="btn btn-green w-100 py-2 rounded-3 fw-bold">ĐĂNG XUẤT</button>
        </div>
      </div>
    </div>

    <!-- Lịch sử giao dịch -->
    <div class="mt-5">
      <h5 class="fw-bold">Lịch sử giao dịch</h5>
      <div class="d-flex flex-wrap justify-content-end gap-2 mb-2">
        <select class="form-select w-auto">
          <option>Đặt vé</option>
          <option>Mua combo</option>
        </select>
        <input type="month" class="form-control w-auto">
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-light">
            <tr>
              <th>STT</th>
              <th>Thời gian giao dịch</th>
              <th>Mã lấy vé</th>
              <th>Thông tin rạp</th>
              <th>Tổng tiền</th>
              <th>Điểm RP</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="6" class="text-center text-muted">Chưa có giao dịch</td>
            </tr>
          </tbody>
          <tfoot class="table-light">
            <tr>
              <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
              <td>0 VNĐ</td>
              <td>0</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</body>

@endsection
