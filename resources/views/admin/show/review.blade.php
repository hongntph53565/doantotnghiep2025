@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 text-primary">Quản lý đánh giá</h5>
                            <div class="form-group mb-0">
                                <select id="filterStatus" class="form-select">
                                    <option value="all">Tất cả trạng thái</option>
                                    <option value="active">Đang hoạt động</option>
                                    <option value="inactive">Đã ẩn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phim & Người dùng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Đánh giá</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày đăng</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody id="reviewsTableBody">
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Đang tải...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                <ul class="pagination" id="pagination">
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewDetailModal" tabindex="-1" role="dialog" aria-labelledby="reviewDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewDetailModalLabel">Chi tiết đánh giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img id="detailMoviePoster" src="" alt="Poster phim" class="img-fluid rounded mb-3" style="max-height: 200px;">
                                    <h5 id="detailMovieTitle" class="mb-1"></h5>
                                    <p class="text-sm text-muted mb-2" id="detailMovieYear"></p>
                                </div>
                            </div>
                            <div class="card mt-3">
                                <div class="card-body text-center">
                                    <img id="detailUserAvatar" src="" alt="Ảnh đại diện" class="img-fluid rounded-circle mb-2" width="80">
                                    <h6 id="detailUserName" class="mb-0"></h6>
                                    <p class="text-sm text-muted" id="detailUserEmail"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Điểm đánh giá</label>
                                <div id="detailRatingStars" class="star-rating">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày đánh giá</label>
                                <p id="detailReviewDate" class="form-control-static"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <p id="detailReviewStatus" class="badge"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bình luận</label>
                                <div id="detailReviewComment" class="border p-3 rounded bg-light"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="toggleStatusBtn" class="btn btn-warning">Ẩn đánh giá</button>
                    <button type="button" id="deleteReviewBtn" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentPage = 1;
            let currentStatusFilter = 'all';
            let currentReviewId = null;
            
            loadReviews();
            
            document.getElementById('filterStatus').addEventListener('change', function() {
                currentStatusFilter = this.value;
                currentPage = 1;
                loadReviews();
            });
            
            function loadReviews() {
                axios.get(`/admin/reviews?status=${currentStatusFilter}&page=${currentPage}`)
                    .then(response => {
                        const reviews = response.data.data;
                        const pagination = response.data.meta;
                        renderReviewsTable(reviews);
                        renderPagination(pagination);
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải đánh giá:', error);
                        document.getElementById('reviewsTableBody').innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-4 text-danger">
                                    Lỗi khi tải đánh giá. Vui lòng thử lại.
                                </td>
                            </tr>`;
                    });
            }
            
            function renderReviewsTable(reviews) {
                const tbody = document.getElementById('reviewsTableBody');
                
                if (reviews.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Không tìm thấy đánh giá nào.
                            </td>
                        </tr>`;
                    return;
                }
                
                let html = '';
                reviews.forEach(review => {
                    const statusBadge = review.status === 'active' 
                        ? '<span class="badge bg-success">Đang hiển thị</span>' 
                        : '<span class="badge bg-secondary">Đã ẩn</span>';
                    
                    const stars = renderStars(review.rating);
                    
                    html += `
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <img src="${review.movie.poster_url || '/images/default-movie.png'}" class="avatar avatar-sm me-3" alt="${review.movie.title}">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${review.movie.title}</h6>
                                        <p class="text-xs text-secondary mb-0">${review.user.name}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="star-rating">
                                    ${stars}
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                ${statusBadge}
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">${new Date(review.created_at).toLocaleDateString('vi-VN')}</span>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-sm btn-outline-info view-review" data-id="${review.id}">
                                    Xem
                                </button>
                            </td>
                        </tr>`;
                });
                
                tbody.innerHTML = html;
                
                document.querySelectorAll('.view-review').forEach(button => {
                    button.addEventListener('click', function() {
                        const reviewId = this.getAttribute('data-id');
                        showReviewDetails(reviewId);
                    });
                });
            }
            
            function renderPagination(pagination) {
                const paginationEl = document.getElementById('pagination');
                let html = '';
                
                html += `
                    <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Trước" data-page="${pagination.current_page - 1}">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>`;
                
                for (let i = 1; i <= pagination.last_page; i++) {
                    html += `
                        <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>`;
                }
                
                html += `
                    <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Sau" data-page="${pagination.current_page + 1}">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>`;
                
                paginationEl.innerHTML = html;
                
                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.getAttribute('data-page');
                        if (page) {
                            currentPage = parseInt(page);
                            loadReviews();
                        }
                    });
                });
            }
            
            function showReviewDetails(reviewId) {
                axios.get(`/admin/reviews/${reviewId}`)
                    .then(response => {
                        const review = response.data;
                        currentReviewId = review.id;
                        
                        document.getElementById('detailMovieTitle').textContent = review.movie.title;
                        document.getElementById('detailMovieYear').textContent = review.movie.release_year;
                        document.getElementById('detailMoviePoster').src = review.movie.poster_url || '/images/default-movie.png';
                        document.getElementById('detailUserName').textContent = review.user.name;
                        document.getElementById('detailUserEmail').textContent = review.user.email;
                        document.getElementById('detailUserAvatar').src = review.user.avatar_url || '/images/default-avatar.png';
                        document.getElementById('detailReviewDate').textContent = new Date(review.created_at).toLocaleString('vi-VN');
                        document.getElementById('detailReviewComment').textContent = review.comment || 'Không có bình luận';
                        
                        const starsContainer = document.getElementById('detailRatingStars');
                        starsContainer.innerHTML = renderStars(review.rating, true);
                        
                        const statusBadge = document.getElementById('detailReviewStatus');
                        statusBadge.textContent = review.status === 'active' ? 'Đang hiển thị' : 'Đã ẩn';
                        statusBadge.className = `badge bg-${review.status === 'active' ? 'success' : 'secondary'}`;
                        
                        const toggleBtn = document.getElementById('toggleStatusBtn');
                        toggleBtn.textContent = review.status === 'active' ? 'Ẩn đánh giá' : 'Hiện đánh giá';
                        toggleBtn.className = `btn btn-${review.status === 'active' ? 'warning' : 'success'}`;
                                                const modal = new bootstrap.Modal(document.getElementById('reviewDetailModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải chi tiết đánh giá:', error);
                        alert('Lỗi khi tải chi tiết đánh giá. Vui lòng thử lại.');
                    });
            }
            
            // Chuyển đổi trạng thái đánh giá
            document.getElementById('toggleStatusBtn').addEventListener('click', function() {
                if (!currentReviewId) return;
                
                axios.put(`/admin/reviews/${currentReviewId}/toggle-status`)
                    .then(response => {
                        alert('Cập nhật trạng thái đánh giá thành công!');
                        loadReviews();
                        
                        // Cập nhật nội dung modal
                        const statusBadge = document.getElementById('detailReviewStatus');
                        const toggleBtn = document.getElementById('toggleStatusBtn');
                        
                        if (statusBadge.textContent === 'Đang hiển thị') {
                            statusBadge.textContent = 'Đã ẩn';
                            statusBadge.className = 'badge bg-secondary';
                            toggleBtn.textContent = 'Hiện đánh giá';
                            toggleBtn.className = 'btn btn-success';
                        } else {
                            statusBadge.textContent = 'Đang hiển thị';
                            statusBadge.className = 'badge bg-success';
                            toggleBtn.textContent = 'Ẩn đánh giá';
                            toggleBtn.className = 'btn btn-warning';
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi chuyển đổi trạng thái:', error);
                        alert('Lỗi khi cập nhật trạng thái. Vui lòng thử lại.');
                    });
            });
            
            // Xóa đánh giá
            document.getElementById('deleteReviewBtn').addEventListener('click', function() {
                if (!currentReviewId) return;
                
                if (confirm('Bạn có chắc chắn muốn xóa đánh giá này? Hành động này không thể hoàn tác.')) {
                    axios.delete(`/admin/reviews/${currentReviewId}`)
                        .then(response => {
                            alert('Xóa đánh giá thành công!');
                            document.getElementById('reviewDetailModal').querySelector('.btn-close').click();
                            loadReviews();
                        })
                        .catch(error => {
                            console.error('Lỗi khi xóa đánh giá:', error);
                            alert('Lỗi khi xóa đánh giá. Vui lòng thử lại.');
                        });
                }
            });
            
            // Hàm hỗ trợ hiển thị sao
            function renderStars(rating, isStatic = false) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        stars += '<i class="fas fa-star"></i>';
                    } else {
                        stars += '<i class="far fa-star"></i>';
                    }
                }
                return stars;
            }
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .star-rating {
            color: #ffc107;
            font-size: 1rem;
        }
        .avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        .table tbody tr {
            cursor: pointer;
        }
        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
        }
    </style>
    @endpush
@endsection