<template>
  <div class="product-list">
    <h1>Danh sách sản phẩm</h1>
    <div v-if="loading">Đang tải dữ liệu...</div>
    <ul v-else>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Discount Code</th>
                <th>Discount Percent</th>
                <th>Discount Cost</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="promotion in promotions" :key="promotion.promo_id">
                <td>{{ promotion.promo_id }}</td>
                <td>{{ promotion.discount_code }}</td>
                <td>{{ promotion.discount_percentage }}%</td>
                <td>{{ promotion.discount_cost }}₫</td>
                <td>{{ promotion.status ? 'Hoạt động' : 'Không hoạt động' }}</td>
                <td>{{ new Date(promotion.start_date).toLocaleDateString() }}</td>
                <td>{{ new Date(promotion.end_date).toLocaleDateString() }}</td>
                <td>
                    <button @click="editProduct(product.id)">Sửa</button>
                    <button @click="deleteProduct(product.id)">Xóa</button>
                </td>
            </tr>
        </tbody>
        </table>
      <li v-for="product in products" :key="product.id">
        {{ product.name }} - {{ product.price }}₫
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const promotions = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/promotions')

    if (!res.data.success || !Array.isArray(res.data.promotions)) {
      throw new Error('Dữ liệu không hợp lệ hoặc không thành công')
    }

    promotions.value = res.data.promotions
  } catch (err) {
    console.error('Lỗi tải dữ liệu:', err)
  } finally {
    loading.value = false
  }
})
</script>


<style scoped>
.product-list {
  padding: 20px;
}
</style>
