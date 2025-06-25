<template>
    <div class="admin-layout">
        <Sidebar :class="{ collapsed: isCollapsed }" />
        <div :class="['main-content', { 'collapsed-content': isCollapsed }]">
            <Header :titleHeader="titleHeader" @toggleSidebar="toggleSidebar" />
            <hr class="my-2 border border-secondary-subtle" />
            <RouterView />
            <!-- <Footer /> -->
        </div>
    </div>
</template>

<script setup>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import "bootstrap-icons/font/bootstrap-icons.css";

import { useRoute } from "vue-router";
import Sidebar from "@/components/Admin/SideBar.vue";
import Header from "@/components/Admin/Header.vue";
import Footer from "@/components/Admin/Footer.vue";
import { watch, ref } from "vue";

const route = useRoute();
const titleHeader = ref("");

watch(
    () => route.name,
    (newName) => {
        switch (newName) {
            case "dashboard":
                titleHeader.value = "Admin | Dashboard";
                document.title = "Admin Dashboard";
                break;
            case "account":
                titleHeader.value = "Admin | Account";
                document.title = "Admin Account";
                break;
        }
    },
    { immediate: true }
);

const isCollapsed = ref(false);
function toggleSidebar() {
    isCollapsed.value = !isCollapsed.value;
}
</script>

<style>
/* Không dùng scoped để áp dụng layout toàn cục */
.admin-layout {
    display: flex;
}

/* Khi sidebar full */
.main-content {
    margin-left: 250px;
    width: calc(100% - 250px);
    transition: all 0.3s;
    padding: 20px;
}

/* Khi sidebar collapsed */
.collapsed-content {
    margin-left: 60px;
    width: calc(100% - 60px);
}
</style>
