<script setup>
let url = "http://localhost:8000/api/promotions";

import { onMounted, ref } from 'vue';
import axios from '@/plugins/axios.js';
import { RouterLink } from 'vue-router';


const listPromotion = ref([]);

onMounted(async () => {
    try {
        const res = await axios.get(url);
        console.log("Dữ liệu trả về từ API:", res.data);
        listPromotion.value = res.data.promotions;
    } catch (err) {
        console.error('Không lấy được danh sách khuyến mãi:', err);
    }
});

function formatCurrency(value) {
    if (!value && value !== 0) return '';
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
    }).format(value);
}
function formatDate(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('vi-VN'); // Ví dụ: 25/06/2025
}

</script>
<template>
    <div class="mt-4">
        <div class="card shadow-sm rounded">
            <div class="card-body">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <RouterLink to="/admin/add-promotion" class="btn btn-success">Thêm voucher</RouterLink>
                </div>

                <!-- Search box -->
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Tìm theo mã đơn, khách hàng, trạng thái..." />
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Mã voucher</th>
                                <th>Số tiền tối thiểu</th>
                                <th>Thời gian sử dụng</th>
                                <th>Giảm giá</th>
                                <th>Số lượng</th>
                                <th>Đã dùng</th>
                                <th>Giới hạn lượt</th>
                                <th>Hoạt động</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="promotion in listPromotion" :key="promotion.pro_id">

                                <td>{{ promotion.pro_code }}</td>
                                <td>{{ formatCurrency(promotion.min_order_amount) }}</td>
                                <td>
                                    <strong>Bắt đầu:</strong> {{ formatDate(promotion.start_date) }}<br />
                                    <strong>Kết thúc:</strong> {{ formatDate(promotion.end_date) }}
                                </td>

                                <td>{{ promotion.discount_percentage }}%</td>
                                <td>{{ promotion.quantity }}</td>
                                <td>{{ promotion.used }}</td>
                                <td>{{ promotion.limit_per_user }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" :checked="promotion.active" />
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <!-- <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>Hiển thị 1 - 3 / {{ vouchers.length }} kết quả</div>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#">Trước</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div> -->
            </div>
        </div>
    </div>
</template>