<template>
    <div class="form-group row">
        <label class="col-3 col-form-label">{{ initialData.name }}</label>
        <div class="col-6">
            <number-input :value="initialData.quantity" :min="0" :step="1" size="small" inputtable center controls @change="updateQuantity"></number-input>
        </div>
        <div class="col-3">
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
            updateQuantity(newValue, oldValue) {
                let updatedData = {...this.initialData, quantity: newValue, elem: 'quantity'};

                this.$store.dispatch('poolRecords/updateFormData', {updatedData});
            },

            updateTotalPrice(event) {
                let updatedData = {...this.initialData, totalPrice: event.target.value, elem: 'totalPrice'};

                this.$store.dispatch('poolRecords/updateFormData', {updatedData});
            },
        }
    }
</script>
