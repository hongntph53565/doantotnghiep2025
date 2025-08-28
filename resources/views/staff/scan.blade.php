{{-- resources/views/staff/scan.blade.php --}}
@extends('layouts.staff')

 


@push('styles')
    <style>
            /* Tên phim */
            #movie-title {
                font-size: 1.5rem;   /* to hơn */
                font-weight: 700;    /* đậm */
                line-height: 1.3;
                color: #72a52f;
            }

            /* Tên rạp + phòng */
            #cinema-room {
    font-size: 1.25rem;   /* to hơn (20px) */
    font-weight: 600;     /* đậm hơn một chút */
    color: #72a52f;       /* xanh bạn chọn */
    letter-spacing: 0.4px;
    margin-top: 4px;      /* thêm khoảng cách với tên phim */
}

            /* Label (Mã vé, Khách, Ghế, Suất…) */
            #ticket-card b {
                font-weight: 600;
                color: #333;
            }

            /* Toàn bộ card gọn gàng hơn */
            #ticket-card {
                border-radius: 12px;
            }

            #ticket-card .card-body {
                padding: 1.2rem 1.5rem;
            }
            .ticket-info {
    font-size: 1.1rem; /* hoặc 1.25rem cho to hơn nữa */
    line-height: 1.6;
}
.ticket-info b {
    font-size: 1.15rem;
}
        </style>
@endpush

@section('content')

<div class="mt-3" id="scan-status" style="min-height: 24px;">
    {{-- Thông báo lỗi --}}
    @if(session('error'))
        <div class="alert alert-danger mb-0">
            {{ session('error') }}
        </div>
    @endif
</div>
    <div class="container py-4">
        <h3 class="mb-4">Quét QR tìm vé</h3>
        <a href="{{ route('staff.search_ticket_online') }}" class="btn btn-outline-secondary px-4 mb-3">
            <i class="bi bi-arrow-left me-2"></i>Quay lại
        </a>
        <br>
        

        <div class="row g-4 align-items-start">
            {{-- LEFT: Ticket info --}}
            <div class="col-lg-6">
                <div class="card shadow-sm overflow-hidden" id="ticket-card">
                    {{-- Movie banner --}}
                    <div class="ratio ratio-16x9 bg-light" id="banner-wrap">
                        <img id="movie-banner" src="" alt="Movie banner"
                            class="w-100 h-100 object-fit-cover d-none">
                        <div id="banner-empty" class="d-flex align-items-center justify-content-center text-muted">
                            <div class="text-center p-4">
                                <div class="mb-2">Chưa có vé</div>
                                <small>Quét QR để hiển thị thông tin vé tại đây</small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            {{-- Poster (nếu muốn) --}}
                            <img id="movie-poster" src="" alt="" class="rounded d-none"
                                style="width:150px;height:200px;object-fit:cover;">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1" id="movie-title">—</h5>
                                <div class="text-muted small" id="cinema-room">—</div>
                                <div class="mt-2 ticket-info">
    <div><b>Mã vé:</b> <span id="booking-code">—</span></div>
    <div><b>Khách:</b> <span id="customer-name">—</span></div>
    <div><b>Ghế:</b> <span id="seat-list">—</span></div>
    <div><b>Suất:</b> <span id="showtime">—</span></div>
</div>
                            </div>
                        </div>
                        <div class="mt-3">
        <h6 class="mb-2">Combo / Đồ ăn kèm</h6>
        <div id="food-list" class="small"></div>
    </div>

                        <div class="mt-3 d-flex flex-column gap-2">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" id="btn-print" disabled>
                                    <i class="bi bi-printer me-1"></i> In vé
                                </button>
                                <a class="btn btn-outline-secondary d-none" id="btn-detail" target="_blank">Xem chi tiết</a>
                            </div>

                            <!-- dòng trạng thái in/ người in / thời gian in -->
                            <div id="print-meta" class="small text-muted"></div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT: Scanner --}}
            <div class="col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Camera quét QR</span>
                        <div class="d-flex gap-2">
                            <select id="camera-select" class="form-select form-select-sm" style="min-width:220px;"></select>
                            <button id="btn-start" class="btn btn-sm btn-primary">Bắt đầu</button>
                            <button id="btn-stop" class="btn btn-sm btn-outline-secondary" disabled>Dừng</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="reader" class="w-100" style="max-width:560px;"></div>

                        <div class="mt-3 d-flex gap-2">
                            <input id="manual-code" class="form-control" placeholder="Nhập mã vé thủ công…">
                            <button id="btn-search" class="btn btn-success">Tìm vé</button>
                        </div>
                        <div class="form-text mt-2">Lưu ý: cần HTTPS (hoặc <code>localhost</code>) để truy cập camera.</div>
                    </div>
                </div>

                <div class="mt-3" id="scan-status" style="min-height: 24px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        (() => {
            const els = {
                banner: document.getElementById('movie-banner'),
                bannerWrap: document.getElementById('banner-wrap'),
                bannerEmpty: document.getElementById('banner-empty'),
                poster: document.getElementById('movie-poster'),
                title: document.getElementById('movie-title'),
                cinemaRoom: document.getElementById('cinema-room'),
                code: document.getElementById('booking-code'),
                customer: document.getElementById('customer-name'),
                seats: document.getElementById('seat-list'),
                showtime: document.getElementById('showtime'),
                btnPrint: document.getElementById('btn-print'),
                btnDetail: document.getElementById('btn-detail'),
                status: document.getElementById('scan-status'),
                manual: document.getElementById('manual-code'),
                btnSearch: document.getElementById('btn-search'),
                cameraSel: document.getElementById('camera-select'),
                btnStart: document.getElementById('btn-start'),
                btnStop: document.getElementById('btn-stop'),
                foods: document.getElementById('food-list'),
            };

            // —— Helpers ————————————————————————————————————————————————
            function setStatus(html) {
                els.status.innerHTML = html;
            }

            function esc(s) {
                return (s ?? '').toString().replace(/[&<>"']/g, m => ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                } [m]));
            }

            function showBanner(src) {
                if (src) {
                    els.banner.src = src;
                    els.banner.classList.remove('d-none');
                    els.bannerEmpty.classList.add('d-none');
                } else {
                    els.banner.src = '';
                    els.banner.classList.add('d-none');
                    els.bannerEmpty.classList.remove('d-none');
                }
            }

            function renderTicket(b, related) {
                // --- Ẩn placeholder banner ngay khi có vé ---
                els.bannerEmpty.classList.add('d-none');

                // banner/poster (tuỳ DB của bạn)
                const movie = b?.showtime?.movie || {};
                const bannerUrl = movie.banner_url || movie.backdrop_url || movie.cover_url || movie.banner || null;
                const posterUrl = movie.poster_url || movie.thumbnail_url || movie.poster || null;

                if (bannerUrl) {
                    // có banner -> hiển thị ảnh
                    els.bannerWrap.classList.remove('d-none');
                    els.banner.src = bannerUrl;
                    els.banner.classList.remove('d-none');
                } else {
                    // không có banner -> ẩn hẳn khu banner để không còn dòng "Chưa có vé"
                    els.bannerWrap.classList.add('d-none');
                    els.banner.classList.add('d-none');
                    els.banner.src = '';
                }

                if (posterUrl) {
                    els.poster.src = posterUrl;
                    els.poster.classList.remove('d-none');
                } else {
                    els.poster.classList.add('d-none');
                    els.poster.src = '';
                }

              if (Array.isArray(related?.foods) && related.foods.length) {
    els.foods.innerHTML = related.foods.map(f => {
        const qty = f.quantity ?? 0;
        const price = f.price ?? 0;
        const total = qty * price;
        return `
            <div class="d-flex align-items-center mb-2">
                ${f.image ? `<img src="${esc(f.image)}" alt="" class="me-2" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">` : ''}
                <div>
                    <div><b>${esc(f.name)}</b></div>
                    <div class="text-muted small">
                        SL: ${qty} × ${price.toLocaleString('vi-VN')}đ 
                        = <b>${total.toLocaleString('vi-VN')}đ</b>
                    </div>
                </div>
            </div>
        `;
    }).join('');
} else {
    els.foods.innerHTML = '<span class="text-muted">Không có combo / đồ ăn kèm</span>';
}


                // --- Thông tin vé ---
                els.title.textContent = movie.title || '—';
                const cinemaName = b?.showtime?.room?.cinema?.name || '—';
                const roomName = b?.showtime?.room?.room_name || '—';
                els.cinemaRoom.textContent = `${cinemaName} • ${roomName}`;
                els.code.textContent = b.booking_code || '—';
                els.customer.textContent = b?.user?.full_name || b?.user?.name || '—';

                // --- Ghế: ưu tiên bookingSeats → showtimeSeat → seat; fallback related.seats / b.seats ---
                let seats = [];
                if (Array.isArray(b?.bookingSeats)) {
                    seats = b.bookingSeats
                        .map(bs => bs?.showtimeSeat?.seat?.seat_code)
                        .filter(Boolean);
                }
                if (!seats.length && Array.isArray(related?.seats)) {
                    seats = related.seats.map(s => s.seat_code).filter(Boolean);
                }
                if (!seats.length && Array.isArray(b?.seats)) {
                    seats = b.seats.map(s => s.seat_code || s.code || s.name).filter(Boolean);
                }
                els.seats.textContent = seats.length ? seats.join(', ') : '—';

                const showDate = b?.showtime?.date || '';
const showTime = b?.showtime?.start_time || '';

if (showDate && showTime) {
    const [y, m, d] = showDate.split("-");
    const [hh, mm] = showTime.split(":"); // lấy giờ và phút
    els.showtime.textContent = `${d}/${m}/${y} - ${hh}:${mm}`;
} else {
    els.showtime.textContent = "—";
}

                // --- Nút chi tiết + In vé ---
                els.btnDetail.classList.remove('d-none');
                els.btnDetail.href = (related?.detail_url) || `{{ url('staff/staff/booking') }}/${b.booking_id}`;

                const printUrl = (related?.print_url) || `{{ url('staff/staff/booking') }}/${b.booking_id}/print`;
                const count = Number(b?.printed_count || 0);
                const printedAt = b?.printed_at || null; // ví dụ "2025-08-26 15:32:10"
                const printedBy = b?.printed_by_name || null; // server trả tên nếu có
                const alreadyPrinted = count > 0 || !!printedAt;

                // reset state trước khi set (tránh dính disable cũ)
                els.btnPrint.classList.remove('btn-secondary', 'disabled');
                els.btnPrint.classList.add('btn-primary');
                els.btnPrint.disabled = false;
                els.btnPrint.removeAttribute('aria-disabled');
                els.btnPrint.removeAttribute('tabindex');
                // gỡ handler cũ rồi gán mới
                els.btnPrint.onclick = null;

                if (alreadyPrinted) {
                    // Khoá nút in và đổi style
                    els.btnPrint.textContent = 'Đã in';
                    els.btnPrint.classList.remove('btn-primary');
                    els.btnPrint.classList.add('btn-secondary', 'disabled');
                    els.btnPrint.disabled = true;
                    els.btnPrint.setAttribute('aria-disabled', 'true');
                    els.btnPrint.setAttribute('tabindex', '-1');

                    // Hiển thị meta in
                    const by = printedBy ? printedBy : (b?.printed_by ? `#${b.printed_by}` : '—');
                    const at = printedAt ? printedAt : '—';
                    document.getElementById('print-meta').innerHTML =
                        `<span class="badge bg-success me-2">ĐÃ IN</span>` +
                        `Bởi <b>${esc(by)}</b>${printedAt ? ` lúc <b>${esc(at)}</b>` : ''}` +
                        `${count ? ` — ${count} lần` : ''}`;
                } else {
                    // Cho phép in
                    els.btnPrint.textContent = 'In vé';
                    document.getElementById('print-meta').innerHTML =
                        `<span class="badge bg-secondary me-2">Chưa in</span>`;

                    // Dùng anchor “_blank” để ít bị chặn popup hơn
                    els.btnPrint.onclick = (e) => {
                        e.preventDefault();
                        const a = document.createElement('a');
                        a.href = printUrl;
                        a.target = '_blank';
                        a.rel = 'noopener';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    };
                }


            }


            function extractCode(text) {
                // Hỗ trợ: raw code / URL có ?code= / /ticket/{code}
                let t = (text || '').trim();
                try {
                    const u = new URL(t);
                    const q = u.searchParams.get('code') || u.searchParams.get('booking_code');
                    if (q) t = q;
                    else {
                        const parts = u.pathname.split('/').filter(Boolean);
                        if (parts.length) t = parts[parts.length - 1];
                    }
                } catch (e) {}
                t = t.replace(/\s+/g, '').replace(/[\u200B-\u200D\uFEFF]/g, '').replace(/^#/, '');
                return t;
            }

            // —— Fetch tìm vé ————————————————————————————————————————————————
            async function findTicketByCode(rawCode) {
                const code = extractCode(rawCode);
                if (!code) return;
                setStatus(`<div class="text-muted">Đang tìm vé: <b>${esc(code)}</b>…</div>`);
                try {
                    const res = await fetch("{{ route('staff.scan.find') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            code
                        })
                    });
                    const data = await res.json().catch(() => {
                        throw new Error(`Không parse được JSON (status ${res.status})`);
                    });

                    if (data.status === 'ok') {
                        renderTicket(data.booking, data.related || {});
                        setStatus(
                            `<div class="text-success"><i class="bi bi-check2-circle me-1"></i> Đã tải vé.</div>`
                        );
                        beep();
                    } else {
                        setStatus(
                            `<div class="text-danger"><i class="bi bi-x-circle me-1"></i> ${esc(data.message || 'Không tìm thấy vé.')}</div>`
                        );
                    }
                } catch (err) {
                    console.error('[SCAN] find error:', err);
                    setStatus(
                        `<div class="alert alert-danger">Lỗi khi gọi tìm vé: ${esc(err.message||String(err))}</div>`
                    );
                }
            }

            function beep() {
                try {
                    const ctx = new(window.AudioContext || window.webkitAudioContext)();
                    const o = ctx.createOscillator();
                    const g = ctx.createGain();
                    o.connect(g);
                    g.connect(ctx.destination);
                    o.type = 'sine';
                    o.frequency.value = 880;
                    g.gain.value = 0.05;
                    o.start();
                    setTimeout(() => {
                        o.stop();
                        ctx.close();
                    }, 120);
                } catch (e) {}
            }

            // —— Scanner setup ————————————————————————————————————————————————
            let qr = null;
            let currentCameraId = null;

            els.btnSearch.addEventListener('click', () => findTicketByCode(els.manual.value));

            Html5Qrcode.getCameras().then(devices => {
                if (!devices || !devices.length) {
                    els.cameraSel.innerHTML = '<option>Không tìm thấy camera</option>';
                    els.btnStart.disabled = true;
                    return;
                }
                els.cameraSel.innerHTML = devices.map(d =>
                    `<option value="${d.id}">${esc(d.label||d.id)}</option>`).join('');
                const rear = devices.find(d => /back|rear|environment/i.test(d.label || ''));
                currentCameraId = (rear || devices[0]).id;
                els.cameraSel.value = currentCameraId;
            });

            els.cameraSel.addEventListener('change', e => currentCameraId = e.target.value);

            els.btnStart.addEventListener('click', async () => {
                if (!currentCameraId) return;
                els.btnStart.disabled = true;
                els.btnStop.disabled = false;
                if (!qr) qr = new Html5Qrcode("reader", {
                    verbose: false
                });
                await qr.start({
                        deviceId: {
                            exact: currentCameraId
                        }
                    }, {
                        fps: 10,
                        qrbox: 280,
                        aspectRatio: 1.333,
                        rememberLastUsedCamera: true
                    },
                    decoded => {
                        const code = extractCode(decoded);
                        if (!code) return;
                        qr.pause(true);
                        findTicketByCode(code).finally(() => setTimeout(() => qr.resume(), 1200));
                    },
                    err => {
                        /* bỏ qua lỗi decode liên tục */
                    }
                );
            });

            els.btnStop.addEventListener('click', async () => {
                els.btnStop.disabled = true;
                try {
                    if (qr) await qr.stop();
                } catch (e) {}
                els.btnStart.disabled = false;
            });
        })();

        
        // --- Trạng thái in ấn ---
        const statusEl = document.getElementById('print-status');
        const count = Number(b?.printed_count || 0);
        const printedAt = b?.printed_at || null;
        const printedByName = b?.printed_by_name || null;
        const printedById = b?.printed_by || null;

        if (count > 0) {
            const by = printedByName ? printedByName : (printedById ? `#${printedById}` : '—');
            statusEl.innerHTML =
                `<span class="badge bg-success">ĐÃ IN</span> ${count} lần — bởi <b>${esc(by)}</b>${printedAt ? ` lúc <b>${esc(printedAt)}</b>` : ''}`;
            // (tuỳ ý) vẫn cho phép bấm "In vé" lại, hoặc:
            // els.btnPrint.classList.remove('btn-primary'); els.btnPrint.classList.add('btn-outline-primary');
        } else {
            statusEl.innerHTML = `<span class="badge bg-secondary">Chưa in</span>`;
        }
    </script>
@endpush
