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
            let vue = this;
            const tk = localStorage.getItem("token");
            var authOptions = {
                method: "GET",
                url: "/logout",
                headers: {
                    Authorization: `Bearer ${tk}`
                }
            };

            axios(authOptions)
                .then(result => {
                    vue.commit("logout");
                    localStorage.clear();
                })
                .catch(error => {
                    alert(error.response.data.error);
                });
        }
    },
    getters: {
        isAuth: state => state.isAuthenticated
    },
    modules: {}
});
