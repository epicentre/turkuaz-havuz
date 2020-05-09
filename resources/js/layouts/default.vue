<template>
    <div class="main-layout">
        <navbar/>

        <div class="container mt-4">
            <child/>
        </div>
    </div>
</template>

<script>
    import Navbar from '../components/Navbar'

    export default {
        name: 'MainLayout',

        components: {
            Navbar
        }
    }
</script>
<style scoped>
    .main-layout {
        background: #12d3cf;
        min-height: 100vh;
    }
</style>
