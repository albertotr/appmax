import Vue from "vue";
import VueRouter from "vue-router";
import Store from "../store";
import Home from "../views/home";
import Login from "../views/Auth/login";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: Home,
        meta: {
            requireAuth: true
        }
    },
    {
        path: "/login",
        component: Login
    },
    {
        path: "*",
        redirect: "/"
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    const requireAuth = to.matched.some(record => record.meta.requireAuth);

    if (requireAuth) {
        const token = localStorage.getItem("token");
        if (token) {
            Store.commit("setAuthenticated", token);
        }

        if (to.name !== "Login" && !Store.getters.isAuth) {
            next("login");
        } else next();
    } else {
        next();
    }
});

export default router;
