<template>
  <div class="container mt-4">
    <div class="card p-4 shadow-sm">
      <h5 class="fw-bold mb-4">Thêm Rạp Chiếu</h5>

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label fw-bold">Tên rạp</label>
          <input type="text" class="form-control" v-model="cinema.name" placeholder="Nhập tên rạp" />
          <div v-if="errors.name" class="text-danger small mt-1">{{ errors.name[0] }}</div>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-bold">Chi nhánh</label>
          <select class="form-select" v-model="cinema.city">
            <option disabled value="">Chọn chi nhánh</option>
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
        <input type="tel" class="form-control" v-model="cinema.phone" placeholder="Nhập số điện thoại"
          inputmode="numeric" pattern="0[0-9]{9}" maxlength="10" />
        <div v-if="errors.phone" class="text-danger small mt-1">{{ errors.phone[0] }}</div>
      </div>

      <div class="col-md-6 ">
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

      <div class="d-flex justify-content-end mt-3">
        <button class="btn btn-lumistar d-flex align-items-center gap-2 px-4 py-2 rounded-3 fw-semibold shadow-sm"
          :disabled="loading" @click="createCinema">
          <span v-if="loading">
            <span class="spinner-border spinner-border-sm me-1"></span> Đang xử lý...
          </span>
          <template v-else>
            <i class="bi bi-plus-circle"></i>
            Thêm mới
          </template>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const cinema = ref({
  name: '',
  city: '',
  address_detail: '',
  ward: '',
  district: '',
  phone: '',
  email: '',
  description: '',
  active: true // mặc định bật
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
  if (!cinema.value.phone) {
    newErrors.phone = ['Vui lòng nhập số điện thoại.']
  } else if (!/^0\d{9}$/.test(cinema.value.phone)) {
    newErrors.phone = ['Nhập đúng định dạng số điện thoại.']
  }

  if (!cinema.value.email) {
    newErrors.email = ['Vui lòng nhập email.']
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(cinema.value.email)) {
    newErrors.email = ['Email không hợp lệ.']
  }

  errors.value = newErrors
  return Object.keys(newErrors).length === 0
}

const createCinema = async () => {
  loading.value = true
  if (!validateForm()) {
    loading.value = false
    return
  }

  try {
    await axios.post('http://localhost:8000/api/cinemas', cinema.value, {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })

    alert('🎉 Thêm rạp thành công!')
    router.push('/admin/cinemas')
  } catch (error) {
    console.error('❌ Lỗi không xác định:', error)
    alert('❌ Có lỗi xảy ra khi thêm rạp.')
  } finally {
    loading.value = false
  }
}
</script>

<style scoped>
.btn-lumistar {
  background-color: #72a52f;
  border: none;
  color: white;
  font-weight: 500;
  transition: background-color 0.3s ease, box-shadow 0.2s ease;
}

.btn-lumistar:hover {
  background-color: #5b8626;
  color: white;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.text-danger {
  font-size: 0.875rem;
}
</style>
