<template>
    <card title="Profil">
        <form @submit.prevent="update" @keydown="form.onKeydown($event)">
            <alert-success :form="form" message="Bilgilerin başarıyla güncellendi."/>

            <!-- Name -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('name') }}</label>
                <div class="col-md-7">
                    <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control"
                           type="text" name="name">
                    <has-error :form="form" field="name"/>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('email') }}</label>
                <div class="col-md-7">
                    <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"
                           type="email" name="email">
                    <has-error :form="form" field="email"/>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('new_password') }}</label>
                <div class="col-md-7">
                    <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }"
                           class="form-control" type="password" name="password">
                    <has-error :form="form" field="password"/>
                </div>
            </div>

            <!-- Password Confirmation -->
            <div class="form-group row">
                <label class="col-md-3 col-form-label text-md-right">{{ $t('confirm_password') }}</label>
                <div class="col-md-7">
                    <input v-model="form.password_confirmation"
                           :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control"
                           type="password" name="password_confirmation">
                    <has-error :form="form" field="password_confirmation"/>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group row">
                <div class="col-md-9 ml-md-auto">
                    <v-button :loading="form.busy" type="success">
                        {{ $t('update') }}
                    </v-button>
                </div>
            </div>
        </form>
    </card>
</template>

<script>
    import Form from 'vform';
    import {mapGetters} from "vuex";

    export default {
        scrollToTop: false,

        metaInfo() {
            return {title: this.$t('settings')}
        },

        data: () => ({
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        created() {
            // Fill the form with user data.
            this.form.keys().forEach(key => {
                this.form[key] = this.user[key];
            })
        },

        methods: {
            async update() {
                const {data} = await this.form.post('/api/auth/user');

                this.$store.dispatch('auth/updateUser', {user: data.data})
            }
        }
    }
</script>
