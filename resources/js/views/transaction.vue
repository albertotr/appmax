<template>
    <div class="row justify-content-center">
        <div class="col-3 text-center">
            <button
                type="button"
                class="btn btn-block btn-secondary"
                @click="onAdd"
            >
                Adicionar Estoque
            </button>
        </div>

        <div class="col-3 text-center">
            <button
                type="button"
                class="btn btn-block btn-secondary"
                @click="onSend"
            >
                Enviar Produto
            </button>
        </div>
        <div class="col-7 pt-3">
            <div
                class="alert alert-danger"
                role="alert"
                v-show="productQTD < 100"
            >
                O produto chegou ao nivel de alerta com apenas
                {{ productQTD }} items em estoque
            </div>
        </div>

        <!-- Modal transaction -->
        <div class="modal fade" id="transModal" tabindex="-1" ref="transModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transModalLabel">
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
                                v-model="productData.sku"
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
                                >Quantidade</label
                            >
                            <input
                                type="number"
                                class="form-control"
                                :class="{ 'is-invalid': qtdInvalid }"
                                id="qtdEdit"
                                v-model="productData.qtd"
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
export default {
    name: "transaction",
    data() {
        return {
            productData: { sku: null, qtd: null },
            qtdInvalid: false,
            skuInvalid: false,
            modalTitle: "",
            addType: null,
            productQTD: 999
        };
    },
    methods: {
        onSave() {
            const tk = localStorage.getItem("token");
            const formData = this.productData;

            let url = "api/transaction/decrease";
            if (this.addType == "add") url = "api/transaction/increase";

            var param = {
                method: "POST",
                url: url,
                headers: {
                    Authorization: `Bearer ${tk}`
                },
                data: formData
            };

            axios(param)
                .then(result => {
                    this.productQTD = result.data.data.product.quantity;
                    let modal = this.$refs.transModal;
                    $(modal).modal("hide");
                })
                .catch(error => {
                    alert(error.response.data.error);
                });
        },
        onAdd() {
            // abre o modal de edicao
            this.modalTitle = "Adicionar produto em estoque";
            this.addType = "add";

            let modal = this.$refs.transModal;
            $(modal).modal("show");
        },
        onSend() {
            // abre o modal de edicao
            this.modalTitle = "Enviar produto";
            this.addType = "send";

            let modal = this.$refs.transModal;
            $(modal).modal("show");
        }
    }
};
</script>

<style lang="scss" scoped></style>
