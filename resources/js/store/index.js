import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isAuthenticated: false
    },
    mutations: {
        setAuthenticated(state, token) {
            localStorage.setItem("token", token);
            Vue.set(state, "isAuthenticated", true);
        },
        logout(state) {
            Vue.set(state, "isAuthenticated", false);
        }
    },
    actions: {
        logout() {
            this.commit("logout");
            localStorage.clear();
        }
    },
    getters: {
        isAuth: state => state.isAuthenticated
    },
    modules: {}
});
