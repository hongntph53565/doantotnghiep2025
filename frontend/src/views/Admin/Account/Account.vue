<script setup>
let url = "http://localhost:8000/api/users";

import { onMounted, ref } from 'vue';
import axios from '@/plugins/axios.js';
import { RouterLink } from 'vue-router';
import Cookies from 'js-cookie';


const listAccount = ref([]);

// fetch('http://localhost:8000/sanctum/csrf-cookie', {
//     credentials: 'include'
// })
//     .then(res => console.log('✅ OK', res))
//     .catch(err => console.error('❌ Lỗi', err));

onMounted(async () => {
    try {
        // Bước 1: Lấy CSRF
        // await axios.get('http://localhost:8000/sanctum/csrf-cookie', {
        //     withCredentials: true,
        // });

        // // Bước 2: Gửi login
        // await axios.post('http://localhost:8000/login', {
        //     email: 'andre.bashirian@example.org',
        //     password: 'password',
        // }, {
        //     withCredentials: true
        // });

        // Bước 3: Gọi API cần auth
        const res = await axios.get('http://localhost:8000/api/users', {
            withCredentials: true
        });

        listAccount.value = res.data;

        console.log('Users:', listAccount.value);
    } catch (err) {
        console.error('Không lấy được danh sách người dùng:', err);
    }
});
console.log('Token:', Cookies.get("XSRF-TOKEN"));



</script>

<template>
    <div class="mt-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <button class="btn btn-outline-primary btn-sm me-2 active">Quản trị viên</button>
                    <button class="btn btn-outline-primary btn-sm">Khách hàng</button>
                </div>
                <RouterLink to="/admin/add-account" class="btn btn-success">Tạo tài khoản</RouterLink>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Tìm kiếm tài khoản..." />
            </div>

            <table class="table align-middle border-0">
                <thead class="table-light border-0">
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(account, index) in listAccount" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ account.full_name }}</td>
                        <td>{{ account.email }}</td>
                        <td>{{ account.phone }}</td>
                        <td>{{ account.role }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style lang="css">
.table td,
.table th {
    border-bottom: 1px solid #ccc !important;

}
</style>
