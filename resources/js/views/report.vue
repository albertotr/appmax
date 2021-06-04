<template>
    <div>
        <h3>Alerta de estoque</h3>
        <div class="list-group" v-for="product in products" :key="product.id">
            <a
                class="list-group-item list-group-item-action"
                aria-current="true"
                v-if="product.quantity < 100"
            >
                <strong>SKU: </strong>{{ product.sku }}
                <strong class="pl-5">Produto: </strong>{{ product.name }}
                <strong class="pl-5">Estoque: </strong>{{ product.quantity }}
            </a>
        </div>
        <h3 class="mt-3">Lista de movientação</h3>
        <div class="list-group mt-3" v-for="dt in listDate" :key="dt">
            <a
                class="list-group-item list-group-item-action active"
                aria-current="true"
            >
                <div class="row">
                    <div class="col-12">Data: {{ dt | frindDate }}</div>
                </div>
                <div class="row pt-2">
                    <div class="col-6">Produto</div>
                    <div class="col-2">Origem</div>
                    <div class="col-2">Quantidade</div>
                    <div class="col-2">Ação</div>
                </div>
            </a>
            <div
                class="list-group"
                v-for="transaction in transactions"
                :key="transaction.id"
            >
                <a
                    class="list-group-item list-group-item-action"
                    aria-current="true"
                    v-if="dt == transaction.created_at"
                >
                    <div class="row">
                        <div class="col-6">{{ transaction.product.name }}</div>
                        <div class="col-2">
                            {{ transaction.origin | showOrigin }}
                        </div>
                        <div class="col-2">
                            {{ transaction.amount | formatAmount }}
                        </div>
                        <div class="col-2">
                            {{ transaction.amount | getInOut }}
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "report",
    data() {
        return {
            products: null,
            transactions: null,
            listDate: null
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
                this.listDate = new Array();

                this.transactions.forEach(tran => {
                    if (this.listDate.indexOf(tran.created_at) === -1)
                        this.listDate.push(tran.created_at);
                });

                let dt = new Date(this.listDate[0]);
            })
            .catch(error => {
                if (error.response.status == 403) {
                    this.$router.replace({ path: "/login" });
                }
                alert(error.response.statusText);
            });
    },
    filters: {
        frindDate: function(dt) {
            let fdt = new Date(dt);
            return (
                fdt.getDate() +
                "/" +
                (fdt.getMonth() + 1) +
                "/" +
                fdt.getFullYear()
            );
        },
        showOrigin(or) {
            return (or = "I" ? "Sistema" : "API");
        },
        formatAmount(am) {
            return Math.abs(am);
        },
        getInOut(am) {
            return am > 0 ? "Adicionado" : "Removido";
        }
    }
};
</script>

<style lang="scss" scoped>
.list-group-item {
    line-height: 0.5em;
}
</style>
