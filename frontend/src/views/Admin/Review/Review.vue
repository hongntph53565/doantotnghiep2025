<script setup>
let url = "http://localhost:8000/api/reviews";

import { onMounted, ref } from 'vue';
import axios from '@/plugins/axios.js';
import { RouterLink } from 'vue-router';
import Cookies from 'js-cookie';


const listReview = ref([]);
onMounted(() => {
    // Gọi API lấy danh sách đánh giá
    axios.get(url)
        .then(res => {
            console.log("✅ Dữ liệu trả về từ API reviews:", res);
            listReview.value = res.data.data;

            // Khi dữ liệu đã sẵn sàng, mới bind sự kiện modal
            const reviewModal = document.getElementById('reviewDetailModal');
            if (!reviewModal) return;

            reviewModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const customer = button.getAttribute('data-customer') || 'Không rõ';
                const movie = button.getAttribute('data-movie') || 'Không rõ';
                const rawDate = button.getAttribute('data-date');
                let date = 'Không rõ';

                if (rawDate) {
                    const d = new Date(rawDate);
                    const day = String(d.getDate()).padStart(2, '0');
                    const month = String(d.getMonth() + 1).padStart(2, '0');
                    const year = d.getFullYear();
                    date = `${day}/${month}/${year}`; // bạn có thể đổi thành `${year}-${month}-${day}` nếu muốn
                }

                const stars = parseInt(button.getAttribute('data-stars')) || 0;
                const content = button.getAttribute('data-content') || 'Không có nội dung';

                reviewModal.querySelector('#reviewCustomer').textContent = customer;
                reviewModal.querySelector('#reviewMovie').textContent = movie;
                reviewModal.querySelector('#reviewDate').textContent = date;
                reviewModal.querySelector('#reviewStars').innerHTML = '★'.repeat(stars) + '☆'.repeat(5 - stars);
                reviewModal.querySelector('#reviewContent').textContent = content;
            });
        })
        .catch(err => {
            console.error('❌ Không lấy được danh sách đánh giá:', err);
        });
});



</script>

<template>
    <div class="mt-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Danh sách Đánh giá</h4>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Tìm theo khách hàng, nội dung, phim..." />
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Khách hàng</th>
                        <th>Phim</th>
                        <th>Nội dung</th>
                        <th>Đánh giá</th>
                        <th>Hoạt động</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(review, index) in listReview" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ review.user?.username || 'Không có tên' }}</td>
                        <td>{{ review.movie?.title || 'Không có tên phim' }}</td>
                        <td>{{ review.comment }}</td>
                        <td>
                            {{ review.rating }} ★
                        </td>

                        <td>
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input" type="checkbox" :checked="review.active"
                                    @change="toggleActive(review)" />
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm me-1" data-bs-toggle="modal"
                                data-bs-target="#reviewDetailModal" :data-customer="review.user?.username"
                                :data-movie="review.movie?.title" :data-date="review.created_at"
                                :data-stars="review.rating" :data-content="review.comment">
                                <i class="bi bi-eye"></i>
                            </button>


                            <!-- <button class="btn btn-primary btn-sm me-1"><i class="bi bi-pencil"></i></button> -->
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Showing {{ filteredReviews.length }} of {{ listReview.length }} Results</div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link">Next</a>
                    </li>
                </ul>
            </nav>
        </div> -->
        </div>
    </div>
    <!-- Modal body -->
    <div class="modal fade" id="reviewDetailModal" tabindex="-1" aria-labelledby="reviewDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết Đánh giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Khách hàng:</strong> <span id="reviewCustomer"></span></div>
                        <div class="col-md-6"><strong>Phim:</strong> <span id="reviewMovie"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Ngày:</strong> <span id="reviewDate"></span></div>
                        <div class="col-md-6"><strong>Đánh giá:</strong> <span id="reviewStars"
                                class="text-warning"></span></div>
                    </div>
                    <div class="mb-3">
                        <strong>Nội dung:</strong>
                        <p id="reviewContent" class="border p-3 rounded bg-light"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle"></i>
                        Đóng</button>
                </div>
            </div>
        </div>
    </div>




</template>
