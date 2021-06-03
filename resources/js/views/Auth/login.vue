<template>
    <div class="row justify-content-center">
        <div class="col-5">
            <h3>Autenticação</h3>
            <label for="authEmailInput" class="form-label">Email address</label>
            <input
                type="email"
                class="form-control"
                id="authEmailInput"
                placeholder="name@example.com"
                v-model="email"
            />

            <label for="authPassInput" class="form-label">Senha</label>
            <input
                type="password"
                class="form-control"
                id="authPassInput"
                v-model="password"
            />
            <br />
            <button
                class="btn btn-primary btn-lg btn-block"
                type="button"
                @click="onAuth"
            >
                Autenticar
            </button>
        </div>
    </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
    name: "Login",
    data() {
        return {
            email: "default@test.com",
            password: "password"
        };
    },
    methods: {
        onAuth() {
            const v = this;
            var authOptions = {
                method: "POST",
                url: "/auth",
                data: {
                    email: v.email,
                    password: v.password
                },
                headers: {}
            };

            axios(authOptions)
                .then(result => {
                    const token = result.data.data.token;
                    this.$store.commit("setAuthenticated", token);
                    this.$router.push("/");
                })
                .catch(error => {
                    alert(error);
                });
        }
    },
    computed: {
        ...mapGetters({
            isAuth: "isAuth"
        })
    }
};
</script>

<style lang="scss" scoped></style>
