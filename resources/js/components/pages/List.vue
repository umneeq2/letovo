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
                <div v-for="pupil in pupils" :key="pupil.id" class="card mb-4">
                    <div class="card-header">
                        {{ "ID: #" + pupil.id + ", " + pupil.fullname }}
                    </div>
                    <div class="card-body">
                        E-mail: {{ pupil.email }}<br />
                        Мобильный телефон: {{ pupil.mobile_phone }}<br />
                        Адрес проживания: {{ pupil.address }}<br />
                        <span v-show="pupil.address_normalized"
                            >Нормализованный адрес проживания:
                            {{ pupil.address_normalized }}<br
                        /></span>
                        <span v-show="pupil.geo_lat"
                            >Широта: {{ pupil.geo_lat }}<br
                        /></span>
                        <span v-show="pupil.geo_lon"
                            >Долгота: {{ pupil.geo_lon }}<br
                        /></span>
                    </div>
                    <div class="card-footer">
                        <button
                            v-show="
                                !pupil.geo_lon &&
                                    !pupil.geo_lat &&
                                    !pupil.address_normalized
                            "
                            class="btn btn-sm btn-secondary"
                            @click.prevent="normalize(pupil.id)"
                            :ref="`btn-normalize-${pupil.id}`"
                        >
                            Нормализация / обогащение
                        </button>
                        <router-link
                            :to="`/pupil/${pupil.id}`"
                            class="btn btn-sm btn-primary"
                        >
                            Просмотр
                        </router-link>
                        <router-link
                            :to="`/pupil/update/${pupil.id}`"
                            class="btn btn-sm btn-success"
                        >
                            Редактировать
                        </router-link>
                        <a
                            to="#"
                            class="btn btn-sm btn-danger"
                            @click.prevent="destroy(pupil.id)"
                        >
                            Удалить
                        </a>
                    </div>
                </div>
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

export default {
    components: {
        Loading,
        Pagination
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
                .get("/api/pupils/list", { params: { page: self.page } })
                .then(response => {
                    self.pupils = response.data.data;
                    self.meta = response.data.meta;
                    self.page = response.data.meta.current_page;
                })
                .catch(function(error) {})
                .finally(response => {
                    self.loading = false;
                });
        },
        normalize(id) {
            const self = this;

            self.$refs[`btn-normalize-${id}`][0].disabled = true;

            axios
                .post(`/api/pupils/normalize/${id}`)
                .then(response => {
                    _.each(self.pupils, function(item, i) {
                        if (item.id === id) {
                            item.address_normalized =
                                response.data.address_normalized;
                            item.geo_lat = response.data.geo_lat;
                            item.geo_lon = response.data.geo_lon;
                            return false;
                        }
                    });
                })
                .catch(function(error) {})
                .finally(response => {
                    self.$refs[`btn-normalize-${id}`][0].disabled = false;
                });
        },
        destroy(id) {
            const self = this;
            if (confirm("Точно удалить ученика?")) {
                axios.delete(`/api/pupils/${id}`).then(function(response) {
                    self.sendRequest();
                });
            }
        }
    }
};
</script>
