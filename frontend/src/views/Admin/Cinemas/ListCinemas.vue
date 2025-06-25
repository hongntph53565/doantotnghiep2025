<template>
  <div class="card border-0 shadow-sm mt-3">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold">Danh sách rạp chiếu</h6>
        <button class="btn btn-success" @click="goToCreate">
          <i class="bi bi-plus-circle me-1"></i> Thêm Rạp chiếu
        </button>
      </div>

      <input
        type="text"
        class="form-control mb-3"
        placeholder="Tìm kiếm rạp, chi nhánh, địa chỉ..."
        v-model="searchTerm"
      />

      <div class="table-responsive">
        <table class="table table-hover align-middle" v-if="filteredCinemas.length > 0">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên rạp</th>
              <th>Chi nhánh</th>
              <th>Địa chỉ</th>
              <th>Phường/Xã</th>
              <th>Quận/Huyện</th>
              <th>SĐT</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(cinema, index) in filteredCinemas" :key="cinema.cinema_id">
              <td>{{ index + 1 }}</td>
              <td>{{ cinema.name }}</td>
              <td>{{ cinema.city }}</td>
              <td>{{ cinema.address_detail }}</td>
              <td>{{ cinema.ward }}</td>
              <td>{{ cinema.district }}</td>
              <td>{{ cinema.phone }}</td>
              <td>
                <button
                  class="btn btn-outline-primary btn-sm me-1"
                  @click="editCinema(cinema.cinema_id)"
                >
                  <i class="bi bi-pencil-fill"></i>
                </button>
                <button
                  class="btn btn-outline-danger btn-sm"
                  @click="deleteCinema(cinema.cinema_id)"
                >
                  <i class="bi bi-trash-fill"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-else class="text-center text-muted">Không có dữ liệu rạp chiếu.</div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const searchTerm = ref('')
const cinemas = ref([])

const getCinemas = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/cinemas', {
      withCredentials: true,
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    cinemas.value = response.data
  } catch (error) {
    console.error('Lỗi khi tải danh sách rạp:', error)
    alert('Không thể tải danh sách rạp.')
  }
}

onMounted(() => {
  getCinemas()
})

const filteredCinemas = computed(() => {
  if (!searchTerm.value) return cinemas.value
  const keyword = searchTerm.value.toLowerCase()
  return cinemas.value.filter(c =>
    c.name.toLowerCase().includes(keyword) ||
    c.city.toLowerCase().includes(keyword) ||
    c.address_detail.toLowerCase().includes(keyword) ||
    c.ward.toLowerCase().includes(keyword) ||
    c.district.toLowerCase().includes(keyword) ||
    c.phone.toLowerCase().includes(keyword)
  )
})

function goToCreate() {
  router.push('/admin/cinemas/create')
}

function editCinema(cinema_id) {
  router.push(`/admin/cinemas/edit/${cinema_id}`)
}

async function deleteCinema(cinema_id) {
  if (confirm('Bạn có chắc muốn xóa rạp này không?')) {
    try {
      await axios.delete(`http://localhost:8000/api/cinemas/${cinema_id}`, {
        withCredentials: true,
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      })
      alert('🗑️ Xóa rạp thành công!')
      await getCinemas()
    } catch (error) {
      console.error('❌ Lỗi khi xoá rạp:', error)
      alert('❌ Có lỗi xảy ra khi xóa rạp.')
    }
  }
}
</script>

<style scoped>
.table-responsive {
  width: 100%;
  overflow-x: auto;
}
</style>
