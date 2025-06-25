<script setup>
const props = defineProps({
  titleHeader: {
    type: String,
    required: true,
    default: "Admin",
  }
})

// 👇 Cái này rất quan trọng
const emit = defineEmits(['toggleSidebar'])
</script>

<template>
  <!-- Thanh top -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-outline-secondary btn-sm" @click="emit('toggleSidebar')">
      <i class="bi bi-list"></i>
    </button>

    <div class="d-flex align-items-center">
      <img src="https://i.pravatar.cc/40" class="rounded-circle me-2" width="36" height="36" alt="Avatar">
      <div class="d-flex flex-column">
        <strong>Admin</strong>
        <small class="text-muted">NGUYỄN SƠN QUÂN</small>
      </div>
    </div>
  </div>

  <!-- Đường kẻ -->
  <hr class="my-2 border border-secondary-subtle" />

  <!-- Tiêu đề & breadcrumb -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-uppercase mb-0">{{ titleHeader }}ssss</h5>
    <span class="text-muted">Quản lý &nbsp; > &nbsp; <strong>{{ titleHeader }}</strong></span>
  </div>
</template>
