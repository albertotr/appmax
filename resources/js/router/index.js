import Vue from "vue";
import VueRouter from "vue-router";
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
        next("login");
    } else {
        next();
    }
});

export default router;
