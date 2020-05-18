<template>
    <div class="d-flex justify-content-center align-items-center">
        <div class="top-right">
            <template v-if="authenticated">
                <router-link class="btn btn-lg btn-outline-secondary text-white" :to="{ name: 'home' }">
                    {{ $t('home') }}
                </router-link>
            </template>
            <template v-else>
                <router-link class="btn btn-lg btn-outline-secondary text-white" :to="{ name: 'login' }">
                    {{ $t('login') }}
                </router-link>
            </template>
        </div>

        <div class="text-center">
            <div class="title mb-4">
                Turkuaz Havuz
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        layout: 'basic',

        metaInfo() {
            return {title: this.$t('home')}
        },

        computed: mapGetters({
            authenticated: 'auth/check'
        })
    }
</script>

<style scoped>
    .top-right {
        position: absolute;
        right: 18px;
        top: 18px;
    }

    .title {
        font-size: 85px;
    }
</style>
