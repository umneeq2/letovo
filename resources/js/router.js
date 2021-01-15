import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

import List from "./components/pages/List";
import View from "./components/pages/View";
import CreateUpdateForm from "./components/pages/CreateUpdateForm";

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
        },
        {
            path: "/pupil/update/:id(\\d+)",
            name: "PupilsUpdate",
            component: CreateUpdateForm
        },
        {
            path: "/pupil/create",
            name: "PupilsCreate",
            component: CreateUpdateForm
        }
    ]
});

export default router;
