@extends('layouts.app')

@section('title', 'Lịch Chiếu Rạp')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush
@section('content')

    <body style="background-color: #f7f7f7;">
        <div class="container py-5">
            <hr>
            <h4 class="text-center fw-bold mb-4">TÀI KHOẢN</h4>
            <div class="row g-4">
                <div class="col-lg-8 col-md-12">
                    <div class="account-box">
                        <div class="d-flex align-items-center mb-3 flex-wrap">
                            <div class="profile-img mx-auto mx-md-0">
                                <i class="bi bi-person"></i>
                            </div>
                            <div class="ms-md-3 text-center text-md-start mt-3 mt-md-0">
                                <h5>{{ Auth::user()->full_name }}</h5>
                                <div
                                    class="d-flex flex-wrap text-muted mb-1 small gap-2 justify-content-center justify-content-md-start">
                                    <span>Điểm RP: {{ $points }}</span>


                                </div>

                                <p class="mb-1 small">
                                    Tổng chi tiêu trong tháng
                                    ({{ $monthFilter ? \Carbon\Carbon::createFromFormat('Y-m', $monthFilter)->format('m/Y') : now()->format('m/Y') }}):
                                    {{ number_format($monthlySpendingForSelectedMonth, 0, ',', '.') }} VNĐ
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('profile.updateInside') }}" method="POST">

                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Họ </label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name', explode(' ', $user->full_name)[0] ?? '') }}">
                                    @error('last_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tên đệm và tên </label>
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name', implode(' ', array_slice(explode(' ', $user->full_name), 1)) ?? '') }}">
                                    @error('first_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Email </label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Mật khẩu *</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" readonly value="************">
                                        <button type="button" id="btn-change-password" class="btn btn-green">ĐỔI MẬT
                                            KHẨU</button>
                                    </div>

                                    <div id="change-password-fields" style="display: none;">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Mật khẩu mới *</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Mật khẩu mới">
                                               
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Nhập lại mật khẩu *</label>
                                                <input type="password"
                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                               
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- <button type="button" class="btn btn-green mt-3" id="btn-change-password-submit">
    Lưu mật khẩu
</button> --}}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Số điện thoại </label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Ngày sinh </label>
                                    @php
                                        $birthdate = $user->birthday ? \Carbon\Carbon::parse($user->birthday) : null;
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="number" name="birth_day" class="form-control" placeholder="Ngày"
                                                value="{{ old('birth_day', $birthdate?->day) }}" min="1"
                                                max="31">
                                            @error('birth_day')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="birth_month" class="form-control"
                                                placeholder="Tháng" value="{{ old('birth_month', $birthdate?->month) }}"
                                                min="1" max="12">
                                            @error('birth_month')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="birth_year" class="form-control" placeholder="Năm"
                                                value="{{ old('birth_year', $birthdate?->year) }}" min="1990"
                                                max="{{ date('Y') }}">
                                            @error('birth_year')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Tỉnh/Thành phố </label>
                                    <select name="address" id="province" class="form-select">
                                        <option disabled>Chọn Tỉnh/Thành phố</option>
                                    </select>

                                    @error('address')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-green px-4" id="btn-submit">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                            aria-hidden="true"></span>
                                        CẬP NHẬT
                                    </button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="account-box border border-success rounded-3 p-3">
                        <div class="d-flex align-items-start flex-wrap justify-content-center justify-content-md-start">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $cardNumber }}&size=100x100"
                                alt="QR" class="me-md-3 mb-3 p-2 bg-white rounded shadow-sm"
                                style="width: 100px; height: 100px;">

                            <div class="text-start small">
                                <p class="mb-1"><strong>Tên đăng nhập:</strong><br>{{ $user->email }}</p>
                                <p class="mb-1"><strong>Số thẻ:</strong> {{ $cardNumber }}</p>
                                <p class="mb-1"><strong>Hạng thẻ:</strong> {{ ucfirst($cardType) }}</p>
                                <p class="mb-0"><strong>Ngày đăng ký:</strong> {{ $user->created_at->format('d/m/Y') }}
                                </p>

                                @if ($nextRank && $pointsNeeded > 0)
                                    <p class="mt-1 text-muted fst-italic">
                                        Cần thêm {{ $pointsNeeded }} điểm nữa để lên hạng
                                        <strong>{{ ucfirst($nextRank) }}</strong>.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        @auth
                            @switch(Auth::user()->role_id)
                                @case(1)
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-green w-100 py-2 rounded-3 fw-bold">
                                        Tới Quản trị
                                    </a>
                                @break

                                @case(2)
                                    <a href="{{ route('manager.static') }}" class="btn btn-green w-100 py-2 rounded-3 fw-bold">
                                        Tới Quản trị
                                    </a>
                                @break

                                @case(3)
                                    <a href="{{ route('staff.list') }}" class="btn btn-green w-100 py-2 rounded-3 fw-bold">
                                        Nhân Viên
                                    </a>
                                @break
                            @endswitch
                        @else
                            <script>
                                window.location.href = "{{ route('home') }}";
                            </script>
                        @endauth
                    </div>

                </div>
            </div>

            
            <div class="mt-5">
                <h5 id="transaction-history" class="fw-bold">Lịch sử giao dịch</h5>
                <div class="d-flex flex-wrap justify-content-end gap-2 mb-2">
                    <form method="GET" class="d-flex gap-2">
                        <select name="type" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="" {{ $typeFilter === null ? 'selected' : '' }}>Tất cả</option>
                            <option value="booking" {{ $typeFilter === 'booking' ? 'selected' : '' }}>Đặt vé</option>
                            <option value="combo" {{ $typeFilter === 'combo' ? 'selected' : '' }}>Mua combo</option>
                        </select>

                        <input type="month" name="month" value="{{ $monthFilter }}" class="form-control w-auto"
                            onchange="this.form.submit()">
                    </form>
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
                                <th>Vé của tôi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $index => $booking)
                                <tr>
                                    <td>{{ ($bookings->currentPage() - 1) * $bookings->perPage() + $index + 1 }}</td>
                                    <td>{{ $booking->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="booking-barcode">
                                            {!! DNS1D::getBarcodeHTML($booking->booking_code, 'C128', 1, 40) !!}
                                            <small>{{ $booking->booking_code }}</small>
                                        </div>
                                    </td>
                                    @php
                                        $cinema = null;

                                        if ($booking->showtime?->room?->cinema) {
                                            $cinema = $booking->showtime->room->cinema;
                                        } elseif ($booking->bookingFoods->first()?->food?->cinema) {
                                            $cinema = $booking->bookingFoods->first()->food->cinema;
                                        }
                                    @endphp

                                    <td class="td-cinema-info">
                                        <strong>Rạp:</strong>
                                        <span class="cinema-name">{{ $cinema->name ?? 'N/A' }}</span><br>
                                        <strong>Địa chỉ:</strong>
                                        <span class="cinema-address">{{ $cinema->address_detail ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ number_format($booking->total_price) }} VNĐ</td>
                                    <td>{{ floor($booking->total_price / 1000) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#ticketModal{{ $booking->booking_id }}">
                                            Xem
                                        </button>


                                    
                                        <div class="modal fade" id="ticketModal{{ $booking->booking_id }}"
                                            tabindex="-1" aria-labelledby="ticketModalLabel{{ $booking->booking_id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content p-4 ticket-style">
                                                    <div class="row g-3">
                                                        
                                                        <div class="col-md-3 text-center ">
                                                            @if ($booking->showtime && $booking->showtime->movie)
                                                                
                                                                <img src="{{ asset('storage/' . $booking->showtime->movie->poster) }}"
                                                                    alt="poster" class="img-fluid rounded shadow">
                                                            @elseif ($booking->bookingFoods->first()?->food?->image)
                                                                
                                                                <img src="{{ asset('storage/' . $booking->bookingFoods->first()->food->image) }}"
                                                                    alt="combo" class="img-fluid rounded shadow">
                                                            @else
                                                               
                                                                <img src="{{ asset('images/default-poster.jpg') }}"
                                                                    alt="default" class="img-fluid rounded shadow">
                                                            @endif
                                                        </div>


                                                      
                                                        <div class="col-md-9 px-0">
                                                            <div class="ticket-info">
                                                                @if ($booking->showtime && $booking->showtime->movie)
                                                                    <h5 class="fw-bold text-uppercase mb-3">
                                                                        {{ $booking->showtime->movie->title }}
                                                                    </h5>

                                                                    <div class="mb-1 d-flex">
                                                                        <span class="w-25 fw-bold"><i
                                                                                class="bi bi-calendar-event me-1"></i> Thời
                                                                            gian:</span>
                                                                        <span>
                                                                            <em>
                                                                                {{ ucfirst(
                                                                                    \Carbon\Carbon::parse($booking->showtime->start_time)->locale('vi')->isoFormat('dddd, DD [Tháng] MM, YYYY'),
                                                                                ) }}
                                                                            </em>
                                                                            <strong class="mx-2">|</strong>
                                                                            <em>
                                                                                {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}
                                                                                ~
                                                                                {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }}
                                                                            </em>
                                                                        </span>
                                                                    </div>

                                                                    <div class="mb-1 d-flex">
                                                                        <span class="w-25 fw-bold"><i
                                                                                class="bi bi-geo-alt-fill me-1"></i>
                                                                            Rạp:</span>
                                                                        <span>{{ $booking->showtime->room->cinema->name ?? 'N/A' }}</span>
                                                                    </div>

                                                                    <div class="mb-1 d-flex">
                                                                        <span class="w-25 fw-bold"><i
                                                                                class="bi bi-building me-1"></i> Địa
                                                                            chỉ:</span>
                                                                        <div class="text-wrap">
                                                                            {{ $booking->showtime->room->cinema->address_detail ?? '...' }}
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-1 d-flex">
                                                                        <span class="w-25 fw-bold"><i
                                                                                class="bi bi-film me-1"></i> Phòng:</span>
                                                                        <span>
                                                                            {{ $booking->showtime->room->room_name ?? 'N/A' }}
                                                                            |
                                                                            <strong>Ghế:</strong>
                                                                            @foreach ($booking->bookingSeats as $bs)
                                                                                {{ $bs->showtimeSeat->seat->seat_code ?? 'N/A' }}
                                                                                @if (!$loop->last)
                                                                                    ,
                                                                                @endif
                                                                            @endforeach
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <h5 class="fw-bold text-uppercase mb-3 text-danger">
                                                                        Đơn hàng đồ ăn (Không có phim chiếu)
                                                                    </h5>
                                                                @endif

                                                                <div class="mb-1 d-flex">
                                                                    <span class="w-25 fw-bold"><i
                                                                            class="bi bi-ticket-perforated me-1"></i> Mã
                                                                        vé:</span>
                                                                    <span>{{ $booking->booking_code }}</span>
                                                                </div>

                                                                <div class="mb-1 d-flex">
                                                                    <span class="w-25 fw-bold"><i
                                                                            class="bi bi-cup-straw me-1"></i> Đồ ăn:</span>
                                                                    <span>
                                                                        @php
                                                                            $foodList = $booking->bookingFoods
                                                                                ->map(function ($bf) {
                                                                                    return $bf->quantity .
                                                                                        ' x ' .
                                                                                        ($bf->food->name ?? 'Không rõ');
                                                                                })
                                                                                ->implode(', ');
                                                                        @endphp
                                                                        {{ $foodList ?: 'Không có' }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr class="my-4">

                                                    <div class="row align-items-center">
                                                        <div class="col-md-3 text-center">
                                                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $booking->booking_code }}&size=100x100"
                                                                alt="QR" class="img-thumbnail">
                                                            <p class="mt-2 mb-0">{{ $booking->booking_code }}</p>
                                                        </div>


                                                        <div class="col-md-9">
                                                            @php
                                                                $discount = $booking->bookingPromotions->sum(
                                                                    'discount_amount',
                                                                );

                                                                $comboTotal = $booking->bookingFoods->sum(function (
                                                                    $bf,
                                                                ) {
                                                                    return $bf->price * $bf->quantity;
                                                                });

                                                                $ticketPrice = 0;
                                                                if ($booking->showtime) {
                                                                    $ticketPrice =
                                                                        $booking->total_price + $discount - $comboTotal;
                                                                }
                                                            @endphp

                                                            <div class="d-flex justify-content-between">
                                                                <span><i class="bi bi-ticket-perforated me-1"></i> Giá
                                                                    vé:</span>
                                                                <span>{{ $ticketPrice > 0 ? number_format($ticketPrice, 0, ',', '.') . ' đ' : '0 đ' }}</span>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <span><i class="bi bi-cup-straw me-1"></i> Bắp nước:</span>
                                                                <span>{{ number_format($comboTotal, 0, ',', '.') }}
                                                                    đ</span>
                                                            </div>

                                                            <div class="d-flex justify-content-between">
                                                                <span><i class="bi bi-tags-fill me-1"></i> Giảm giá:</span>
                                                                <span>
                                                                    {{ number_format($booking->bookingPromotions->sum('discount_amount'), 0, ',', '.') }}
                                                                    đ
                                                                </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span><i class="bi bi-credit-card-2-front-fill me-1"></i>
                                                                    Phương thức:</span>
                                                                <span>{{ strtoupper($booking->payment_method) }}</span>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-between fw-bold">
                                                                <span>Tổng cộng:</span>
                                                                <span>{{ number_format($booking->total_price, 0, ',', '.') }}
                                                                    đ</span>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr class="my-3">
                                                    <p class="small text-muted mb-1">
                                                        Vui lòng đưa mã số này đến quầy vé LumiStar để nhận vé của bạn
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Chưa có giao dịch</td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Tổng cộng</td>
                                <td>{{ number_format($totalSpending) }} VNĐ</td>
                                <td>{{ $totalRP }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $bookings->appends(request()->query())->fragment('transaction-history')->links() }}

                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            const provinces = [
                "Hà Nội", "TP. Hồ Chí Minh", "Hải Phòng", "Đà Nẵng", "Cần Thơ", "Huế",
                "An Giang", "Bắc Ninh", "Cà Mau", "Cao Bằng", "Đắk Lắk", "Điện Biên",
                "Đồng Nai", "Đồng Tháp", "Gia Lai", "Hà Tĩnh", "Hưng Yên", "Khánh Hòa",
                "Lai Châu", "Lạng Sơn", "Lào Cai", "Lâm Đồng", "Nghệ An", "Ninh Bình",
                "Phú Thọ", "Quảng Ngãi", "Quảng Ninh", "Quảng Trị", "Sơn La", "Tây Ninh",
                "Thái Nguyên", "Thanh Hóa", "Tuyên Quang", "Vĩnh Long"
            ];

            const select = document.getElementById('province');
            const current = "{{ old('address', Auth::user()->address) }}";

            if (select) {
                provinces.forEach(province => {
                    let option = document.createElement('option');
                    option.value = province;
                    option.text = province;
                    if (province === current) {
                        option.selected = true;
                    }
                    select.appendChild(option);
                });
            }

         
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            
            function handleSubmit(btn) {
                const spinner = btn.querySelector('.spinner-border');
                if (spinner) spinner.classList.remove('d-none');
                btn.setAttribute('disabled', 'true');

                const form = btn.closest('form');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                        },
                        body: formData
                    })
                    .then(async res => {
                        if (spinner) spinner.classList.add('d-none');
                        btn.removeAttribute('disabled');

                        const data = await res.json().catch(() => ({}));

                  
                        if (res.ok && data.success) {
                            toastr.success(data.message || "Cập nhật thành công");
                        
                            form.querySelectorAll('.text-danger').forEach(el => el.remove());
                            return;
                        }

                      
                        if (res.status === 422 && data.errors) {
                            form.querySelectorAll('.text-danger').forEach(el => el.remove());
                            Object.keys(data.errors).forEach(key => {
                                const input = form.querySelector(`[name="${key}"]`);
                                if (input) {
                                    let errorDiv = document.createElement("div");
                                    errorDiv.className = "text-danger mt-1";
                                    errorDiv.innerText = data.errors[key][0];
                                    input.insertAdjacentElement("afterend", errorDiv);
                                }
                            });
                            toastr.error("Vui lòng kiểm tra lại thông tin");
                            return;
                        }

                       
                        toastr.error(data.message || "Có lỗi xảy ra, vui lòng thử lại");
                    })
                    .catch(() => {
                        if (spinner) spinner.classList.add('d-none');
                        btn.removeAttribute('disabled');
                        toastr.error("Không thể kết nối server");
                    });
            }

            
            document.getElementById('btn-submit')?.addEventListener('click', function(e) {
                e.preventDefault();
                handleSubmit(this);
            });

            
            document.getElementById('btn-change-password-submit')?.addEventListener('click', function(e) {
                e.preventDefault();
                handleSubmit(this);
            });

            
            const btnChangePassword = document.getElementById("btn-change-password");
            const changePasswordFields = document.getElementById("change-password-fields");

            if (btnChangePassword && changePasswordFields) {
                btnChangePassword.addEventListener("click", function() {
                    changePasswordFields.style.display =
                        changePasswordFields.style.display === "none" ? "block" : "none";
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            @if (session('message'))
                toastr.success("{{ session('message') }}");
            @endif
        });
    </script>




@endsection
