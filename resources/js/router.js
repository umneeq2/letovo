import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import List from "./components/pages/List";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "PupilsList",
            component: List
        }
    ]
});

export default router;
