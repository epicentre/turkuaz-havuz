<template>
    <div class="form-group row">
        <label class="col-4 col-form-label">{{ initialData.name }}</label>
        <div class="col-sm-4">
            <input type="number" min="0" step="1" class="form-control" :value="initialData.quantity" @input="updateQuantity">
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="number" min="0" step="any" class="form-control" :value="initialData.totalPrice" @input="updateTotalPrice">
                <div class="input-group-append">
                    <span class="input-group-text">₺</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CustomerTypeElement',

        props: {
            initialData: {
                type: Object,
                required: true
            }
        },

        methods: {
            updateQuantity(event) {
                let updatedData = {...this.initialData, quantity: event.target.value, elem: 'quantity'};

                this.$store.dispatch('poolRecords/updateFormData', {updatedData});
            },

            updateTotalPrice(event) {
                let updatedData = {...this.initialData, totalPrice: event.target.value, elem: 'totalPrice'};

                this.$store.dispatch('poolRecords/updateFormData', {updatedData});
            },
        }
    }
</script>
