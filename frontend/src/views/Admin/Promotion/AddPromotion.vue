<script setup></script>
<template>
    <div class="mt-4">
        <form class="row g-3">
            <!-- Cột trái: Form chính -->
            <div class="col-lg-9">
                <div class="card shadow-sm rounded p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Mã giảm giá:</label>
                            <input type="text" class="form-control" value="35SROXKI" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Số lượng:</label>
                            <input type="number" class="form-control" value="5" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giới hạn sử dụng:</label>
                            <input type="number" class="form-control" value="6" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kiểu voucher:</label>
                            <select class="form-select">
                                <option selected>Phần trăm</option>
                                <option>Tiền mặt</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Giảm giá (VND):</label>
                            <input type="number" class="form-control" value="49" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Thời gian bắt đầu:</label>
                            <input type="datetime-local" class="form-control" value="2025-03-26T12:00" />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Thời gian kết thúc:</label>
                            <input type="datetime-local" class="form-control" value="2025-03-31T12:00" />
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Tiêu đề:</label>
                            <input type="text" class="form-control" value="hi" />
                        </div>

                        <div class="col-12">
                            <label class="form-label">Mô tả ngắn:</label>
                            <textarea class="form-control" rows="3">🎉🎉🎉</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cột phải: Cấu hình nâng cao -->
            <div class="col-lg-3">
                <div class="card shadow-sm rounded p-4 mb-3">
                    <div class="mb-3">
                        <label class="form-label">Đơn hàng tối thiểu:</label>
                        <input type="number" class="form-control" value="2000000" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số tiền giảm giá tối đa:</label>
                        <input type="number" class="form-control" value="49" />
                    </div>
                </div>

                <div class="card shadow-sm rounded p-4">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" checked />
                        <label class="form-check-label">Hoạt động</label>
                    </div>
                    <button class="btn btn-primary w-100">Thêm mới</button>
                </div>
            </div>
        </form>
    </div>
</template>

<style scoped lang="css"></style>