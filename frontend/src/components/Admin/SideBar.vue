<script setup>
import { RouterLink } from 'vue-router';

defineProps({
    collapsed: Boolean
})
</script>

<template>
    <div class="sidebar" :class="{ collapsed }" id="sidebar">
        <div class="logo">LumiStar</div>
        <RouterLink to="/admin"><i class="bi bi-house-door"></i><span class="menu-text">Tổng quan</span></RouterLink>
        <RouterLink to="/admin/statistical"><i class="bi bi-bar-chart"></i><span class="menu-text">Thống kê</span>
        </RouterLink>

        <a data-bs-toggle="collapse" data-bs-target="#heThong" role="button">
            <i class="bi bi-building"></i><span class="menu-text">Hệ thống rạp</span>
        </a>
        <div class="collapse submenu" id="heThong">
            <!-- <a href="#"><span class="menu-text">Chi nhánh</span></a> -->
            <RouterLink to="/admin/cinema"><span class="menu-text">Rạp</span></RouterLink>
        </div>

        <a data-bs-toggle="collapse" data-bs-target="#phimXuatChieu" role="button">
            <i class="bi bi-film"></i><span class="menu-text">Phim và Xuất Chiếu</span>
        </a>
        <div class="collapse submenu" id="phimXuatChieu">
            <RouterLink to="/admin/movie"><span class="menu-text">Quản lý phim</span></RouterLink>
            <RouterLink to="/admin/show"><span class="menu-text">Quản lý xuất chiếu</span></RouterLink>
            <RouterLink to="/admin/bill"><span class="menu-text">Quản lý hóa đơn</span></RouterLink>
        </div>

        <a data-bs-toggle="collapse" data-bs-target="#dichvuvauudai" role="button">
            <i class="bi bi-gift"></i><span class="menu-text">Dịch vụ và Ưu đãi</span>
        </a>
        <div class="collapse submenu" id="dichvuvauudai">
            <RouterLink to="/admin/combo"><span class="menu-text">Combo bắp nước</span></RouterLink>
            <RouterLink to="/admin/promotion"><span class="menu-text">Khuyến mãi</span></RouterLink>
            <RouterLink to="/admin/review"><span class="menu-text">Đánh giá</span></RouterLink>
        </div>
        <!-- <a href="#"><i class="bi bi-journal-text"></i><span class="menu-text">Nội dung</span></a> -->
        <a data-bs-toggle="collapse" data-bs-target="#taikhoan" role="button">
            <i class="bi bi-person"></i><span class="menu-text">Tài khoản</span>

        </a>
        <div class="collapse submenu" id="taikhoan">
            <RouterLink to="/admin/account"><span class="menu-text">Người dùng</span></RouterLink>
            <RouterLink to="/admin/role"><span class="menu-text">Vai trò</span></RouterLink>
        </div>
    </div>
</template>

<style scoped lang="css">
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    background-color: #2e3b55;
    color: white;
    transition: all 0.3s;
    overflow-y: auto;
    z-index: 1000;
}

.sidebar.collapsed {
    width: 60px;
}

.sidebar .logo {
    font-size: 24px;
    font-weight: bold;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #444;
    white-space: nowrap;
    transition: all 0.3s;
}

.sidebar.collapsed .logo {
    font-size: 0px;
    padding: 20px 0;
}

.sidebar a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    transition: all 0.3s;
    white-space: nowrap;
}

.sidebar a:hover {
    background-color: #405075;
}

.sidebar .submenu a {
    padding-left: 40px;
    font-size: 14px;
}

.menu-text {
    margin-left: 10px;
    transition: all 0.3s;
}

.sidebar.collapsed .menu-text {
    display: none;
}
</style>
