import { nextTick } from "vue";
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/admin",
      name: "admin",
      component: () => import("../views/Admin/HomePage.vue"),
      meta: { requiredAuth: true, requiredAdmin: true },
      children: [
        //http://localhost:5173/admin
        {
          path: "",
          name: "dashboard",
          component: () => import("../views/Admin/Dashboard.vue"),
        },
        //http://localhost:5173/admin/account
        {
          path: "nguoi-dung",
          name: "nguoi-dung",
          component: () => import("../views/Admin/Account/Account.vue"),
        },
        //http://localhost:5173/admin/add-account
        {
          path: "add-account",
          name: "addAccount",
          component: () => import("../views/Admin/Account/AddAccount.vue"),
        },
        //http://localhost:5173/admin/update-account
        {
          path: "update-account/:idAccount",
          name: "updateAccount",
          component: () => import("../views/Admin/Account/UpdateAccount.vue"),
        },
      ],
    },
  ],
});

export default router;
