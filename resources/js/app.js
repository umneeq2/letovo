import "es6-promise/auto";
import router from "./router";
import App from "./components/App";
require("./bootstrap");

const app = new Vue({
    el: "#app",
    router,
    created() {},
    render: h => h(App)
});
