<template>
    <div>
        {{ products }}
        {{ transactions }}
    </div>
</template>

<script>
export default {
    name: "report",
    data() {
        return {
            products: null,
            transactions: null
        };
    },
    mounted() {
        const v = this;
        const tk = localStorage.getItem("token");
        var param = {
            method: "GET",
            url: "/api/product",
            headers: {
                Authorization: `Bearer ${tk}`
            }
        };

        axios(param)
            .then(result => {
                this.products = result.data;
            })
            .catch(error => {
                if (error.response.status == 403) {
                    this.$router.replace({ path: "/login" });
                }
                alert(error.response.statusText);
            });

        var param = {
            method: "GET",
            url: "/api/transaction",
            headers: {
                Authorization: `Bearer ${tk}`
            }
        };

        axios(param)
            .then(result => {
                this.transactions = result.data;
            })
            .catch(error => {
                if (error.response.status == 403) {
                    this.$router.replace({ path: "/login" });
                }
                alert(error.response.statusText);
            });
    }
};
</script>

<style lang="scss" scoped></style>
