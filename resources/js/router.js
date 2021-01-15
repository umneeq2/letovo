import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import List from "./components/pages/List";
import View from "./components/pages/View";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "PupilsList",
            component: List
        },
        {
            path: "/pupil/:id(\\d+)",
            name: "PupilsView",
            component: View
        }
    ]
});

export default router;
