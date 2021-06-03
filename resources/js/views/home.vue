<template>
    <div>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" @click="onLogout">logout</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "Home",
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
