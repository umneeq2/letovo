<template>
    <div class="container">
        <div class="d-flex justify-content-between">
            <div>
                <h1 class="mb-4">Список учеников</h1>
            </div>
            <div>
                <router-link class="btn btn-success mb-3" to="/pupil/create"
                    >Добавить</router-link
                >
            </div>
        </div>

        <loading v-if="loading"></loading>
        <div v-else>
            <div v-if="pupils.length">
                <pupil-card
                    v-for="pupil in pupils"
                    :key="pupil.id"
                    :pupil="pupil"
                >
                </pupil-card>
                <pagination
                    :meta="meta"
                    @refresh-page="changePage"
                ></pagination>
            </div>
            <div v-else>
                Учеников не найдено.
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "../partial/Loading";
import Pagination from "../partial/Pagination";
import PupilCard from "../partial/PupilCard";

export default {
    components: {
        Loading,
        Pagination,
        PupilCard
    },
    data() {
        return {
            loading: true,
            pupils: [],
            meta: {},
            page: 1
        };
    },
    computed: {},
    created() {
        if (this.$route.query.page) {
            this.page = this.$route.query.page;
        }

        this.sendRequest();
    },
    methods: {
        routerPush() {
            let query = {};

            if (this.page !== 1) {
                query.page = this.page;
            }

            this.$router
                .push({ name: "PupilsList", query: query })
                .catch(err => {});
        },
        changePage(page) {
            window.scrollTo(0, 150);
            this.page = page;
            this.sendRequest();
        },
        sendRequest() {
            const self = this;
            this.routerPush();

            axios
                .get("/api/pupils", { params: { page: self.page } })
                .then(response => {
                    self.pupils = response.data.data;
                    self.meta = response.data.meta;
                    self.page = response.data.meta.current_page;
                })
                .catch(function(error) {})
                .finally(response => {
                    self.loading = false;
                });
        }
    }
};
</script>
