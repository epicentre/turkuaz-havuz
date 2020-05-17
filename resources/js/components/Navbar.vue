<template>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
                {{ appName }}
            </router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                    aria-controls="navbarToggler" aria-expanded="false">
                <span class="navbar-toggler-icon"/>
            </button>

            <div id="navbarToggler" class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <!--
                        <locale-dropdown/>
                    -->
                </ul>

                <ul class="navbar-nav ml-auto">
                    <!-- Authenticated -->
                    <template v-if="user">
                        <li class="nav-item">
                            <router-link :to="{ name: 'poolRecords' }" class="nav-link" active-class="active">
                                Kayıtlar
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                                İstatistikler
                            </router-link>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark"
                               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            >
                                <fa icon="user" fixed-width/>
                                {{ user.name }}
                            </a>
                            <div class="dropdown-menu">
                                <router-link :to="{ name: 'customer_types.index' }" class="dropdown-item pl-3">
                                    <fa icon="cog" fixed-width/>
                                    {{ $t('settings') }}
                                </router-link>

                                <div class="dropdown-divider"/>
                                <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                                    <fa icon="sign-out-alt" fixed-width/>
                                    {{ $t('logout') }}
                                </a>
                            </div>
                        </li>
                    </template>
                    <!-- Guest -->
                    <template v-else>
                        <li class="nav-item">
                            <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                                {{ $t('login') }}
                            </router-link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    import {mapGetters} from 'vuex'
    import LocaleDropdown from './LocaleDropdown'

    export default {
        components: {
            LocaleDropdown
        },

        data: () => ({
            appName: 'Turkuaz Havuz'
        }),

        computed: mapGetters({
            user: 'auth/user'
        }),

        methods: {
            async logout() {
                // Log out the user.
                await this.$store.dispatch('auth/logout');

                // Redirect to login.
                this.$router.push({name: 'login'});
            }
        }
    }
</script>

<style scoped>
    .navbar {
        background: #fcf9ec;
    }
</style>
