@extends('layouts.admin')

@section('content')
<style>
  .page-wrap{background:#f3f4f6;padding:24px}
  .box{background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 1px 2px rgba(0,0,0,.04)}
  .table thead th{background:#f8fafc;font-weight:600}
  .barcode-box img{max-width:100%;height:auto}
</style>

<div class="page-wrap">
  <!-- Header -->
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h2 class="fs-5 fw-bold mb-0">THÔNG TIN HÓA ĐƠN</h2>
    <div class="d-flex gap-2">
      <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary btn-sm">Danh sách</a>
      <button type="button" onclick="window.print()" class="btn btn-success btn-sm">In vé</button>
    </div>
  </div>

  <div class="row g-4">
    <!-- CỘT TRÁI: 3/4 -->
    <div class="col-12 col-lg-9">
      <!-- Thông tin phim -->
      <div class="box p-3 mb-3">
        <div class="table-responsive">
          <table class="table table-sm align-middle">
            <thead>
              <tr>
                <th>Phim</th>
                <th>Suất chiếu</th>
                <th>Ghế ngồi</th>
                <th class="text-end">Tổng tiền ghế</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-start gap-2">
                    <img src="https://i.imgur.com/3s8YjYv.jpeg" class="rounded" style="width:80px;height:112px;object-fit:cover" alt="Poster">
                    <div class="small">
                      <div class="fw-semibold">Venom: Kẹo Cuối</div>
                      <div>Độ tuổi: T16</div>
                      <div>Thời lượng: 94 phút</div>
                      <div>Định dạng: IMAX Phụ đề</div>
                      <div>Thể loại: Kinh dị</div>
                      <div>Địa điểm: Hà Nội - Hà Đông - P201</div>
                      <div>Lịch chiếu: 02:24 - 04:13 (06/12/2024)</div>
                    </div>
                  </div>
                </td>
                <td>02:24 - 04:13</td>
                <td>CB, C10, C9</td>
                <td class="text-end">390.000 VNĐ</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Combo -->
      <div class="box p-3 mb-3">
        <div class="table-responsive">
          <table class="table table-sm align-middle">
            <thead>
              <tr>
                <th>Combo</th>
                <th>Chi tiết</th>
                <th>Số lượng x giá</th>
                <th class="text-end">Giá combo</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="https://i.imgur.com/5W0YtG5.png" style="width:48px;height:48px" alt="">
                    <span>Combo Premium</span>
                  </div>
                </td>
                <td class="small">
                  - Nước có ga (22oz) x (2)<br>
                  - Bắp (69oz) x (1)<br>
                  - Ly giấy kèm nước x (4)
                </td>
                <td>2 x 210.000 VNĐ</td>
                <td class="text-end">420.000 VNĐ</td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-2">
                    <img src="https://i.imgur.com/5W0YtG5.png" style="width:48px;height:48px" alt="">
                    <span>Combo Mixed</span>
                  </div>
                </td>
                <td class="small">- Nước có ga (22oz) x (1)</td>
                <td>2 x 0 VNĐ</td>
                <td class="text-end">0 VNĐ</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tổng tiền -->
      <div class="box p-3">
        <div class="d-flex flex-column align-items-end">
          <div>Giảm giá: <strong>20.000 VNĐ</strong></div>
          <div>Điểm Poly: <strong>30.000 VNĐ</strong></div>
          <div class="fs-5 fw-bold">Tổng tiền: 760.000 VNĐ</div>
        </div>
      </div>
    </div>

    <!-- CỘT PHẢI: 1/4 -->
    <div class="col-12 col-lg-3">
      <!-- Trạng thái vé -->
      <div class="box p-3 mb-3">
        <div class="fw-semibold text-success">Trạng thái vé</div>
        <div class="small">Đã xuất vé (09:24 - 30/11/2024)</div>
        <div class="barcode-box border rounded d-flex justify-content-center mt-2 p-2">
          <img src="https://barcode.tec-it.com/barcode.ashx?data=20241130092218&code=Code128&dpi=96" alt="barcode">
        </div>
      </div>

     <!-- Thông tin người đặt -->
<div class="box p-3 mb-3">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <span class="fw-semibold">Thông tin người đặt</span>
    <a href="#" class="small text-primary">Xem chi tiết</a>
  </div>

  <div class="mb-2 d-flex align-items-center gap-2">
    <i class="bi bi-person fs-4 text-secondary"></i>
    <div>
      <div class="fw-semibold">Bùi Đỗ Đạt</div>
      <div class="small text-muted">member</div>
    </div>
  </div>

  <div class="mb-1 d-flex align-items-center gap-2">
    <i class="bi bi-envelope text-secondary"></i>
    <span class="small">datbdph3621@fpt.edu.vn</span>
  </div>

  <div class="d-flex align-items-center gap-2">
    <i class="bi bi-telephone text-secondary"></i>
    <span class="small">0965238725</span>
  </div>
</div>


      <!-- Thông tin thanh toán -->
      <div class="box p-3">
        <div class="fw-semibold mb-1">Thông tin thanh toán</div>
        <div class="small">Thanh toán lúc: 09:22 - 30/11/2024</div>
        <div class="small">Phương thức: Ví VNPAY</div>
        <div class="small">Tên tài khoản: Bùi Đỗ Đạt</div>
        <div class="fw-bold mt-2">Tổng tiền: 760.000 VNĐ</div>
      </div>
    </div>
  </div>
</div>
@endsection
