@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  .filter-section {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
    background: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  .filter-section select, 
  .filter-section input {
    padding: 6px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  .filter-section button {
    padding: 6px 15px;
    border: none;
    border-radius: 5px;
    background: #70d137;
    color: #fff;
    cursor: pointer;
  }
  table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  }
  table th, table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    vertical-align: top;
  }
  table th {
    background: #f1f1f1;
    text-align: left;
  }
  table img {
    width: 70px;
    border-radius: 5px;
  }
  .badge-success {
    color: #fff;
    background: #28a745;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
  }
  .badge-warning {
    color: #fff;
    background: #ffc107;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
  }
  .action-btn {
    background: #70d137;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
  }
</style>
@endpush

@section('content')
  <h3>DANH SÁCH HÓA ĐƠN</h3>

  <!-- Bộ lọc -->
  <div class="filter-section">
    <select>
      <option>Chi nhánh</option>
      <option>Hà Nội</option>
      <option>TP HCM</option>
    </select>
    <select>
      <option>Rạp</option>
      <option>Hà Đông</option>
    </select>
    <input type="date">
    <select>
      <option>Tất cả các phim</option>
    </select>
    <select>
      <option>Trạng thái</option>
      <option>Đã xuất vé</option>
      <option>Chưa xuất vé</option>
    </select>
    <button>Lọc</button>
    <input type="text" placeholder="Search...">
  </div>

  <!-- Bảng -->
  <table>
    <thead>
      <tr>
        <th>Mã vé</th>
        <th>Thông tin người dùng</th>
        <th>Hình ảnh</th>
        <th>Thông tin vé</th>
        <th>Chức năng</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2024113009218</td>
        <td>
          <b>Người dùng:</b> Bùi Đỗ Đạt <br>
          <b>Email:</b> datbdph38211@fpt.edu.vn <br>
          <b>Phương thức thanh toán:</b> Ví VnPay
        </td>
        <td><img src="https://i.ibb.co/RTt5N4k/movie1.jpg" alt="Poster"></td>
        <td>
          <b>Phim:</b> Venom: Kèo Cuối <br>
          <b>Nơi chiếu:</b> Hà Nội - Hà Đông - P201 <br>
          <b>Ghế:</b> C8, C10, C9 <br>
          <b>Tổng tiền:</b> 760,000 VND <br>
          <b>Trạng thái:</b> <span class="badge-success">Đã xuất vé</span>
        </td>
        <td>
          <button class="action-btn" onclick="viewDetail('2024113009218')">
            <i class="fas fa-eye"></i>
          </button>
        </td>
      </tr>
      <tr>
        <td>2024113009753</td>
        <td>
          <b>Người dùng:</b> Bùi Đỗ Đạt <br>
          <b>Email:</b> datbdph38211@fpt.edu.vn <br>
          <b>Phương thức thanh toán:</b> Tiền mặt
        </td>
        <td><img src="https://i.ibb.co/Q9h4nMf/movie2.jpg" alt="Poster"></td>
        <td>
          <b>Phim:</b> The Substance <br>
          <b>Nơi chiếu:</b> Hà Nội - Hà Đông - P404 <br>
          <b>Ghế:</b> E11, E12 <br>
          <b>Tổng tiền:</b> 940,000 VND <br>
          <b>Trạng thái:</b> <span class="badge-warning">Chưa xuất vé</span>
        </td>
        <td>
          <button class="action-btn" onclick="viewDetail('2024113009753')">
            <i class="fas fa-eye"></i>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
@endsection

@push('scripts')
<script>
  function viewDetail(maVe) {
    // chuyển sang trang chi tiết
    window.location.href = "{{ url('admin/bill/detail') }}/" + maVe;
  }
</script>
@endpush
