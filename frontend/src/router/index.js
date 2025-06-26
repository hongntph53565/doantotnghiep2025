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
          path: "account",
          name: "account",
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
        //http://localhost:5173/admin/review
        {
          path: "review",
          name: "review",
          component: () => import("../views/Admin/Review/Review.vue"),
        },
        //http://localhost:5173/admin/promotion
        {
          path: "promotion",
          name: "promotion",
          component: () => import("../views/Admin/Promotion/Promotion.vue"),
        },
        //http://localhost:5173/admin/add-promotion
        {
          path: "add-promotion",
          name: "Addpromotion",
          component: () => import("../views/Admin/Promotion/AddPromotion.vue"),
        },
        //http://localhost:5173/admin/update-promotion
        {
          path: "update-promotion",
          name: "Updatepromotion",
          component: () =>
            import("../views/Admin/Promotion/UpdatePromotion.vue"),
        },
      ],
    },
  ],
});

export default router;
