<template>
    <div class="content__loader w-100 h-100 d-flex flex-jc-c flex-ai-c">
        <div class="loader"></div>
    </div>  
</template>

<script>
export default {
    name: 'AppLoader'
}
</script>

<style scoped>
.content__loader {
    position: fixed;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, .25);
}

.loader {
    border: 4px solid var(--alt-text-color);
    border-radius: 50%;
    border-top: 4px solid var(--action-color);
    width: 32px;
    height: 32px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { 
        transform: rotate(0deg); 
    }
    100% { 
        transform: rotate(360deg); 
    }
}
</style>