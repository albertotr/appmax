<template>
    <div>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" @click="selectComponent = 'products'"
                    >Produtos</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="selectComponent = 'transaction'"
                    >Movimentação</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="selectComponent = 'report'"
                    >Relatório</a
                >
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="onLogout">logout</a>
            </li>
        </ul>
        <component :is="selectComponent"></component>
    </div>
</template>

<script>
import products from "./products";
import transaction from "./transaction";
import report from "./report";
export default {
    name: "Home",
    components: {
        products,
        transaction,
        report
    },
    data() {
        return {
            selectComponent: "report"
        };
    },
    methods: {
        onLogout() {
            this.$store.dispatch("logout").then(() => {
                this.$router.push("/login");
            });
        }
    }
};
</script>

<style lang="scss" scoped></style>
