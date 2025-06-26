<script setup></script>
<template>
    <div class="mt-4">
        <form class="card shadow-sm p-4">
            <div class="row g-3">
                <!-- Họ tên -->
                <div class="col-md-4">
                    <label class="form-label fw-bold"><span class="text-danger">*</span> Họ và tên:</label>
                    <input type="text" class="form-control" placeholder="Họ và tên" />
                </div>

                <!-- Email -->
                <div class="col-md-4">
                    <label class="form-label fw-bold"><span class="text-danger">*</span> Email:</label>
                    <input type="email" class="form-control" placeholder="user@example.com" />
                </div>

                <!-- SĐT -->
                <div class="col-md-4">
                    <label class="form-label fw-bold"><span class="text-danger">*</span> Số điện thoại:</label>
                    <input type="text" class="form-control" placeholder="0912345648" />
                </div>

                <!-- Mật khẩu -->
                <div class="col-md-4">
                    <label class="form-label fw-bold"><span class="text-danger">*</span> Mật khẩu:</label>
                    <input type="password" class="form-control" placeholder="Mật khẩu" />
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="col-md-4">
                    <label class="form-label fw-bold"><span class="text-danger">*</span> Xác nhận mật khẩu:</label>
                    <input type="password" class="form-control" placeholder="Mật khẩu" />
                </div>

                <!-- Ngày sinh -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ngày sinh:</label>
                    <input type="date" class="form-control" />
                </div>

                <!-- Giới tính -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Giới tính:</label>
                    <select class="form-select">
                        <option selected disabled>Chọn giới tính</option>
                        <option>Nam</option>
                        <option>Nữ</option>
                        <option>Khác</option>
                    </select>
                </div>

                <!-- Vai trò -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Vai trò:</label>
                    <input type="text" class="form-control" placeholder="Vui lòng nhập vai trò" />
                </div>

                <!-- Tại -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tại:</label>
                    <select class="form-select">
                        <option selected>Hà Đông</option>
                        <option>Thanh Xuân</option>
                        <option>Ba Đình</option>
                    </select>
                </div>

                <!-- Địa chỉ -->
                <div class="col-md-12">
                    <label class="form-label fw-bold">Địa chỉ:</label>
                    <textarea class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 d-flex justify-content-between">
                <button type="button" class="btn btn-primary">Trở về</button>
                <button type="submit" class="btn btn-dark">Thêm mới</button>
            </div>
        </form>
    </div>

</template>