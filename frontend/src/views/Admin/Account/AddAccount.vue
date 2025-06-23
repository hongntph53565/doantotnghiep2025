<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
let url = "http://localhost:3000/api.php/users";

const name = ref("");
const password = ref("");
const email = ref("");
const role = ref("");
const note = ref("");

const handleSubmit = async () => {
    checkValidate();
    if (nameError.value == "" && passwordError.value == "" && emailError.value == "" && roleError.value == "") {
        let formData = new FormData();
        formData.append("name", name.value);
        formData.append("password", password.value);
        formData.append("email", email.value);
        formData.append("role", role.value);
        formData.append("note", note.value);

        let response = await axios.post(url, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
        if (response) {
            alert(response.data.message);
            router.push("/admin/account");
        }
    }


}

const nameError = ref("");
const passwordError = ref("");
const emailError = ref("");
const roleError = ref("");
const checkValidate = () => {
    if (name.value == "") {
        nameError.value = "Không được để trống Tên tài khoản";
    } else {
        nameError.value = "";
    }
    if (password.value == "") {
        passwordError.value = "Không được để trống Mật khẩu";
    } else {
        passwordError.value = "";
    }
    if (email.value == "") {
        emailError.value = "Không được để trống Email";
    } else {
        emailError.value = "";
    }
    if (role.value == "") {
        roleError.value = "Không được để trống Vai trò";
    } else {
        roleError.value = "";
    }

}

</script>
<template>
    <div class="p-4" style="min-height: 800px;">
        <h1>Thêm mới tài khoản</h1>
        <form @submit.prevent="handleSubmit">
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" placeholder="Tên tài khoản" v-model="name" class="form-control">
                <span v-if="nameError != ''" class="text-danger">{{ nameError }}</span>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Mật khẩu" v-model="password" class="form-control">
                <span v-if="passwordError != ''" class="text-danger">{{ passwordError }}</span>
            </div>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="text" id="email" placeholder="Email" v-model="email" class="form-control">
                <span v-if="emailError != ''" class="text-danger">{{ emailError }}</span>
            </div>
            <div class="mb-3">
                <label for="role">Role</label>
                <input type="text" id="role" placeholder="Role" v-model="role" class="form-control">
                <span v-if="roleError != ''" class="text-danger">{{ roleError }}</span>
            </div>
            <div class="mb-3">
                <label for="note">Note</label>
                <input type="text" id="note" placeholder="Note" v-model="note" class="form-control">
            </div>
            <button class="btn btn-success">Thêm mới</button>
        </form>
    </div>
</template>