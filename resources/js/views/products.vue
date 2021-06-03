<template>
    <div>
        <h4>Lista de Produtos</h4>
        <div class="row">
            <div class="col-8 ">SKU - Produto</div>
            <div class="col-4">Estoque</div>
        </div>
        <div class="list-group" v-for="product in products" :key="product.id">
            <a href="#" class="list-group-item list-group-item-action">
                <div class="row">
                    <div class="col-8">
                        {{ product.sku }} - {{ product.name }}
                    </div>
                    <div class="col-2">
                        {{ product.quantity }}
                    </div>
                    <div class="col-2">
                        <div class="btn-group" role="group">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                @click="onEdit(product.id)"
                            >
                                Editar
                            </button>
                            <button type="button" class="btn btn-danger">
                                Excluir
                            </button>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal" tabindex="-1" ref="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">
                            Edição de Produto
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="skuEdit" class="form-label">SKU</label>
                            <input
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': skuInvalid }"
                                id="skuEdit"
                                v-model="productSelected.sku"
                            />
                            <div
                                id="validationServer04Feedback"
                                class="invalid-feedback"
                            >
                                O SKU já existe no cadastro de produtos.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nameEdit" class="form-label"
                                >Nome</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                :class="{ 'is-invalid': nameInvalid }"
                                id="nameEdit"
                                v-model="productSelected.name"
                            />
                            <div
                                id="validationServer04Feedback"
                                class="invalid-feedback"
                            >
                                O nome não pode ser em branco ou igual ao de
                                outro produto.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        >
                            Fechar
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="onSave"
                        >
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "producs",
    data() {
        return {
            products: null,
            productSelected: { id: null, sku: null, name: null },
            skuInvalid: false,
            nameInvalid: false
        };
    },
    methods: {
        onEdit(productId) {
            this.skuInvalid = false;
            this.nameInvalid = false;

            // filtra o produto selecionado na lista
            let product = this.products.filter(function(prod) {
                return prod.id == productId;
            });

            this.productSelected.id = product[0].id;
            this.productSelected.sku = product[0].sku;
            this.productSelected.name = product[0].name;

            // abre o modal de edicao
            let modal = this.$refs.editModal;
            $(modal).modal("show");
        },
        onSave() {
            let v = this;
            let erroValidacao = false;

            //verifica se SKU já existe cadastrado
            let existeSKU = this.products.filter(function(prod) {
                return (
                    prod.sku == v.productSelected.sku &&
                    prod.id != v.productSelected.id
                );
            });

            if (existeSKU.length) {
                this.skuInvalid = true;
                erroValidacao = true;
            } else {
                this.skuInvalid = false;
                erroValidacao = false;
            }

            //verifica se Nome já existe cadastrado ou esta em branco
            let existeName = this.products.filter(function(prod) {
                return (
                    prod.name == v.productSelected.name &&
                    prod.id != v.productSelected.id
                );
            });

            if (existeName.length || this.productSelected.name.trim() === "") {
                this.nameInvalid = true;
                erroValidacao = true;
            } else {
                this.nameInvalid = false;
            }

            if (erroValidacao) return false;

            const tk = localStorage.getItem("token");
            const formData = this.productSelected;

            var param = {
                method: "PUT",
                url: "/api/product",
                headers: {
                    Authorization: `Bearer ${tk}`
                },
                data: formData
            };

            axios(param)
                .then(result => {
                    console.info(result);
                })
                .catch(error => {
                    console.error(error);
                    if (error.response.status == 403) {
                        this.$router.replace({ path: "/login" });
                    }
                    alert(error.response.statusText);
                });

            let product = this.products.filter(function(prod) {
                return prod.id == v.productSelected.id;
            });

            product[0].name = this.productSelected.name.trim();
            product[0].sku = this.productSelected.sku.trim();

            let modal = this.$refs.editModal;
            $(modal).modal("hide");
        }
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
    }
};
</script>

<style lang="scss" scoped></style>
