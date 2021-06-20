<template>
    <div class="d-flex flex-jc-c w-100 h-100">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: 'App'
}
</script>

<style>
#app {
    min-height: 100vh;
    width: 100%;
    font-family: 'Nunito', sans-serif;
    background-color: var(--main-bg-color);
    color: var(--main-text-color);
}
</style>