<template>
    <div id="app" class="body">
        <div>
            <div class="container">
                <div class="alert alert-info mt-4">
                    <b>Подсказка</b>. Запросы Вы всегда можете увидеть в консоли
                    разработчика.
                </div>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    name: "App",
    components: {}
};
</script>

<style lang="scss">
body .body > div {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
}

body .body-container {
    flex: 1;
}
</style>
