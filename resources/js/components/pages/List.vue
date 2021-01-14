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
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">ФИО</th>
                            <th scope="col">Мобильный&nbsp;телефон</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Адрес проживания</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pupil in pupils" :key="pupil.id">
                            <td>{{ pupil.id }}</td>
                            <td>{{ pupil.fullname }}</td>
                            <td>{{ pupil.mobile_phone }}</td>
                            <td>{{ pupil.email }}</td>
                            <td>{{ pupil.address }}</td>
                            <td>
                                <div
                                    class="btn-group btn-group-sm"
                                    role="group"
                                    aria-label="Basic example"
                                >
                                    <router-link
                                        :to="`/pupil/${pupil.id}`"
                                        class="btn"
                                        title="Просмотр"
                                    >
                                        <i class="icon-eye text-primary"></i>
                                    </router-link>
                                    <router-link
                                        :to="`/pupil/update/${pupil.id}`"
                                        class="btn"
                                        title="Редактировать"
                                    >
                                        <i
                                            class="icon-pencil3 text-success"
                                        ></i>
                                    </router-link>
                                    <a
                                        to="#"
                                        class="btn"
                                        title="Удалить"
                                        @click.prevent="destroy(pupil.id)"
                                    >
                                        <i class="icon-cross3 text-danger"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

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
