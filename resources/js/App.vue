<template>
    <div class="d-flex flex-jc-c w-100 h-100">
        <router-view></router-view>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import chartMixin from './mixins/chartMixin'

export default {
    name: 'App',
    mixins: [chartMixin],
    methods: {
        ...mapActions({
            setupApp: 'app/setup'
        })
    },
    created() {
        this.setupApp()
    }
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