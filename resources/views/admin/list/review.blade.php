@extends('layouts.admin')

@section('content')
                        <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0">Danh sách Đánh giá</h4>
                                <button class="btn btn-success">+ Thêm đánh giá</button>
                            </div>

                            <div class="mb-3">
                                <input type="text" class="form-control"
                                    placeholder="Tìm theo khách hàng, nội dung, phim...">
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Khách hàng</th>
                                            <th>Phim</th>
                                            <th>Nội dung</th>
                                            <th>Đánh giá</th>
                                            <th>Ngày tạo</th>
                                            <th>Hoạt động</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Nguyễn Văn A</td>
                                            <td>Avengers: Endgame</td>
                                            <td>Phim rất hay, kỹ xảo đỉnh!</td>
                                            <td>5 ★</td>
                                            <td>2025-06-10</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info text-white me-1"
                                                    data-bs-toggle="modal" data-bs-target="#reviewDetailModal"
                                                    data-customer="Nguyễn Văn A" data-movie="Avengers: Endgame"
                                                    data-date="2025-06-10" data-stars="5"
                                                    data-content="Phim rất hay, kỹ xảo đỉnh, cảm xúc dâng trào ở đoạn cuối. Đáng xem!">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-primary"><i
                                                        class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Trần Thị B</td>
                                            <td>Joker</td>
                                            <td>Diễn xuất đỉnh nhưng hơi tâm lý quá</td>
                                            <td>4 ★</td>
                                            <td>2025-06-08</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info text-white me-1"
                                                    data-bs-toggle="modal" data-bs-target="#reviewDetailModal"
                                                    data-customer="Nguyễn Văn A" data-movie="Avengers: Endgame"
                                                    data-date="2025-06-10" data-stars="5"
                                                    data-content="Phim rất hay, kỹ xảo đỉnh, cảm xúc dâng trào ở đoạn cuối. Đáng xem!">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <button class="btn btn-sm btn-primary"><i
                                                        class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-danger"><i
                                                        class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                        <!-- Thêm dòng khác ở đây nếu cần -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>Showing 2 of 2 Results</div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/review.js') }}"></script>
@endpush