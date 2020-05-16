<template>
    <div>
        <card :title="cardTitle">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Ad</th>
                        <th scope="col">Açıklama</th>
                        <th scope="col">Fiyat</th>
                        <th scope="col">Düzenlenme Tarihi</th>
                        <th scope="col">İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="customerType in customerTypes">
                        <td scope="row">{{ customerType.name }}</td>
                        <td>{{ customerType.description }}</td>
                        <td>{{ customerType.price }} ₺</td>
                        <td>{{ customerType.updated_at }}</td>
                        <td>
                            <button class="btn btn-primary" @click="editCustomerType(customerType)">Düzenle</button>
                            <button class="btn btn-danger" @click="showDeleteModal(customerType)">Sil</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </card>

        <!-- Edit Modal -->
        <div class="modal fade" id="customerTypeEditModal" tabindex="-1" role="dialog" aria-labelledby="customerTypeEditModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerTypeEditModalTitle">Düzenle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateCustomerType" @keydown="form.onKeydown($event)">
                        <div class="modal-body">
                            <alert-success :form="form" message="Başarıyla güncellendi."/>

                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">Ad</label>
                                <div class="col-md-7">
                                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control"
                                           type="text" name="name">
                                    <has-error :form="form" field="name"/>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">Açıklama</label>
                                <div class="col-md-7">
                                    <input v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }" class="form-control"
                                           type="test" name="description">
                                    <has-error :form="form" field="description"/>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">Fiyat</label>
                                <div class="col-md-7">
                                    <input v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }"class="form-control"
                                           type="number" min="1" step="any" name="price">
                                    <has-error :form="form" field="price"/>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                            <!-- Submit Button -->
                            <v-button :loading="form.busy" type="success">
                                Güncelle
                            </v-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <div class="modal fade" id="customerTypeDeleteModal" tabindex="-1" role="dialog" aria-labelledby="customerTypeDeleteModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerTypeDeleteModalTitle">Silme İşlemi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <b>{{ activeCustomerType && activeCustomerType.name }}</b> adlı müşteri tipini silmek istediğine emin misin?
                        <b>Bu işlem geri alınamaz!!</b>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete">Sil</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'vform';
    import axios from 'axios';
    import {mapGetters, mapActions} from 'vuex';

    export default {
        middleware: 'auth',
        scrollToTop: false,

        metaInfo() {
            return {title: 'Müşteri Tipleri'}
        },

        data: () => ({
            activeCustomerType: null,
            form: new Form({
                name: '',
                description: '',
                price: '',
            }),
            cardTitle: 'Müşteri Tipleri'
        }),

        computed: mapGetters({
            customerTypes: 'customerTypes/customerTypes'
        }),

        methods: {
            editCustomerType(customerType) {
                this.activeCustomerType = customerType;

                this.form.keys().forEach(key => {
                    this.form[key] = this.activeCustomerType[key];
                });

                jQuery('#customerTypeEditModal').modal('show');
            },
            async updateCustomerType() {
                await this.form.put(`/api/customer-types/${this.activeCustomerType.id}`);

                this['customerTypes/fetchCustomerTypes']();
            },
            showDeleteModal(customerType) {
                this.activeCustomerType = customerType;

                jQuery('#customerTypeDeleteModal').modal('show');
            },
            async confirmDelete() {
                await axios.delete(`/api/customer-types/${this.activeCustomerType.id}`);

                jQuery('#customerTypeDeleteModal').modal('hide');

                this['customerTypes/fetchCustomerTypes']();
            },
            ...mapActions([
                'customerTypes/fetchCustomerTypes'
            ])
        },

        created() {
            this['customerTypes/fetchCustomerTypes']();
        },
    }
</script>
