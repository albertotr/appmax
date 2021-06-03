<template>
    <div>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" @click="onProducts">Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="onTransaction">Movimentação</a>
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
export default {
    name: "Home",
    components: {
        products,
        transaction
    },
    data() {
        return {
            selectComponent: "transaction"
        };
    },
    methods: {
        onLogout() {
            this.$store.dispatch("logout").then(() => {
                this.$router.push("/login");
            });
        },
        onProducts() {
            this.selectComponent = "products";
        },
        onTransaction() {
            this.selectComponent = "transaction";
        }
    }
};
</script>

<style lang="scss" scoped></style>
