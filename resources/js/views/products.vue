<template>
    <div>
        <h4>Lista de Produtos</h4>
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-primary" @click="onAdd">
                    Adicionar Produto
                </button>
            </div>
        </div>
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
                            <button
                                type="button"
                                class="btn btn-danger"
                                @click="onDelete(product.id)"
                            >
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
                            {{ modalTitle }}
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
                                O nome não pode ser em branco..
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
            nameInvalid: false,
            modalTitle: "Editar produto"
        };
    },
    methods: {
        onEdit(productId) {
            this.modalTitle = "Editar produto";
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

            if (!this.checkModalData()) return false;

            const tk = localStorage.getItem("token");
            const formData = this.productSelected;

            let typeRequest = "PUT";
            if (this.productSelected.id == 0) typeRequest = "POST";

            var param = {
                method: typeRequest,
                url: "/api/product",
                headers: {
                    Authorization: `Bearer ${tk}`
                },
                data: formData
            };

            axios(param)
                .then(result => {
                    if (typeRequest == "PUT") {
                        let product = this.products.filter(function(prod) {
                            return prod.id == v.productSelected.id;
                        });

                        product[0].name = this.productSelected.name.trim();
                        product[0].sku = this.productSelected.sku.trim();
                    } else {
                        this.products.push(result.data.data);
                    }

                    let modal = this.$refs.editModal;
                    $(modal).modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 403) {
                        this.$router.replace({ path: "/login" });
                    } else if (error.response.status == 400) {
                        alert(
                            "Erro ao salvar o registro, verifique os dados digitados."
                        );
                    } else {
                        alert(error.message);
                    }
                });
        },
        onDelete(id) {
            let v = this;
            let confirmation = confirm("Deseja realmente excluir o registro?");
            if (confirmation) {
                const tk = localStorage.getItem("token");

                var param = {
                    method: "DELETE",
                    url: `/api/product/${id}`,
                    headers: {
                        Authorization: `Bearer ${tk}`
                    }
                };

                axios(param)
                    .then(() => {
                        let prodToRemove = this.products.filter(function(prod) {
                            return prod.id == id;
                        });
                        let prodIndex = this.products.indexOf(prodToRemove[0]);
                        this.products.splice(prodIndex, 1);

                        let modal = this.$refs.editModal;
                        $(modal).modal("hide");
                    })
                    .catch(error => {
                        if (error.response.status == 403) {
                            this.$router.replace({ path: "/login" });
                        } else if (error.response.status == 400) {
                            alert(
                                "Erro ao salvar o registro, verifique os dados digitados."
                            );
                        } else {
                            alert(error.message);
                        }
                    });
            } else {
                console.log("desisti");
            }
        },
        onAdd() {
            this.modalTitle = "Adicionar produto";
            this.skuInvalid = false;
            this.nameInvalid = false;

            this.productSelected.id = 0;
            this.productSelected.sku = "";
            this.productSelected.name = "";

            // abre o modal de edicao
            let modal = this.$refs.editModal;
            $(modal).modal("show");
        },
        checkModalData() {
            let v = this;
            let erroValidacao = false;

            //verifica se SKU já existe cadastrado
            let existeSKU = this.products.filter(function(prod) {
                return (
                    prod.sku == v.productSelected.sku &&
                    prod.id != v.productSelected.id
                );
            });

            if (existeSKU.length || this.productSelected.sku.trim() === "") {
                this.skuInvalid = true;
                erroValidacao = true;
            } else {
                this.skuInvalid = false;
                erroValidacao = false;
            }

            if (this.productSelected.name.trim() === "") {
                this.nameInvalid = true;
                erroValidacao = true;
            } else {
                this.nameInvalid = false;
            }

            if (erroValidacao) return false;

            return true;
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
