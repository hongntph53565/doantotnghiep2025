// EditCinema.vue
<template>
  <div class="container mt-4">
    <div class="card p-4 shadow-sm">
      <h5 class="fw-bold mb-4">Cập nhật Rạp Chiếu</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">Tên rạp</label>
          <input type="text" class="form-control" v-model="cinema.name" placeholder="Nhập tên rạp" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name[0] }}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Chi nhánh</label>
          <select class="form-select" v-model="cinema.city">
            <option value="">Chọn chi nhánh</option>
            <option value="Hà Nội">Hà Nội</option>
          </select>
          <div v-if="errors.city" class="text-danger small mt-1">{{ errors.city[0] }}</div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Địa chỉ</label>
        <input type="text" class="form-control" v-model="cinema.address_detail" placeholder="Nhập địa chỉ" />
        <div v-if="errors.address_detail" class="text-danger small mt-1">{{ errors.address_detail[0] }}</div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">Phường/Xã</label>
          <input type="text" class="form-control" v-model="cinema.ward" placeholder="Nhập phường/xã" />
          <div v-if="errors.ward" class="text-danger small mt-1">{{ errors.ward[0] }}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Quận/Huyện</label>
          <input type="text" class="form-control" v-model="cinema.district" placeholder="Nhập quận/huyện" />
          <div v-if="errors.district" class="text-danger small mt-1">{{ errors.district[0] }}</div>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">Số điện thoại</label>
          <input type="tel" class="form-control" v-model="cinema.phone" placeholder="Nhập số điện thoại" inputmode="numeric" pattern="0[0-9]{9}" maxlength="10" />
          <div v-if="errors.phone" class="text-danger small mt-1">{{ errors.phone[0] }}</div>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-bold">Email</label>
          <input type="email" class="form-control" v-model="cinema.email" placeholder="Nhập email" />
          <div v-if="errors.email" class="text-danger small mt-1">{{ errors.email[0] }}</div>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label fw-bold">Mô tả</label>
        <textarea class="form-control" rows="3" v-model="cinema.description" placeholder="Nhập mô tả"></textarea>
        <div v-if="errors.description" class="text-danger small mt-1">{{ errors.description[0] }}</div>
      </div>

      <div class="d-flex justify-content-end">
        <button class="btn btn-lumistar px-4" :disabled="loading" @click="updateCinema">
          <span v-if="loading">
            <span class="spinner-border spinner-border-sm me-1"></span> Đang xử lý...
          </span>
          <span v-else>Cập nhật</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()

const cinemaId = route.params.cinema_id
const cinema = ref({
  name: '',
  city: '',
  address_detail: '',
  ward: '',
  district: '',
  phone: '',
  email: '',
  description: ''
})

const errors = ref({})
const loading = ref(false)

const validateForm = () => {
  const newErrors = {}

  if (!cinema.value.name) newErrors.name = ['Vui lòng nhập tên rạp.']
  if (!cinema.value.city) newErrors.city = ['Vui lòng chọn chi nhánh.']
  if (!cinema.value.address_detail) newErrors.address_detail = ['Vui lòng nhập địa chỉ.']
  if (!cinema.value.ward) newErrors.ward = ['Vui lòng nhập phường/xã.']
  if (!cinema.value.district) newErrors.district = ['Vui lòng nhập quận/huyện.']
  if (!/^0\d{9}$/.test(cinema.value.phone)) newErrors.phone = ['Số điện thoại phải bắt đầu từ 0 và có 10 chữ số.']
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(cinema.value.email)) newErrors.email = ['Email không hợp lệ.']

  errors.value = newErrors
  return Object.keys(newErrors).length === 0
}

const fetchCinema = async () => {
  try {
    const res = await axios.get(`http://localhost:8000/api/cinemas/${cinemaId}`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })

    // Gán đầy đủ để tránh lỗi
    cinema.value = {
      name: res.data.name || '',
      city: res.data.city || '',
      address_detail: res.data.address_detail || '',
      ward: res.data.ward || '',
      district: res.data.district || '',
      phone: res.data.phone || '',
      email: res.data.email || '',
      description: res.data.description || ''
    }
  } catch (err) {
    alert('Không thể tải thông tin rạp.')
    console.error(err)
  }
}

const updateCinema = async () => {
  loading.value = true
  if (!validateForm()) {
    loading.value = false
    return
  }

  try {
    await axios.patch(`http://localhost:8000/api/cinemas/${cinemaId}`, cinema.value, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    alert('✅ Cập nhật thành công!')
    router.push('/admin/cinemas')
  } catch (err) {
    if (err.response && err.response.status === 422) {
      errors.value = err.response.data.errors
      console.error('Lỗi validate:', errors.value)
    } else {
      alert('❌ Lỗi khi cập nhật.')
      console.error(err)
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCinema()
})
</script>

<style scoped>
.btn-lumistar {
  background-color: #72a52f;
  color: white;
  font-weight: 500;
  border: none;
}
.btn-lumistar:hover {
  background-color: #5b8626;
  color: white;
}
.text-danger {
  font-size: 0.875rem;
}
</style>
