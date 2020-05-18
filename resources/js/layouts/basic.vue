<template>
    <div class="basic-layout d-flex align-items-center justify-content-center m-0">
        <child/>
    </div>
</template>

<script>
    export default {
        name: 'BasicLayout'
    }
</script>

<style lang="scss">
    .basic-layout {
        background: #12d3cf;
        color: #fcf9ec;
        height: 100vh;
        font-weight: 100;
        position: relative;
    }
</style>
