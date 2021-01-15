<template>
    <div class="container">
        <router-link to="/">Список учеников</router-link>
        <h1 v-show="isCreateScenario" class="mb-4">Добавление ученика</h1>
        <h1 v-show="isUpdateScenario" class="mb-4">Редактирование ученика</h1>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>ФИО студента</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="pupil.fullname"
                        :disabled="loading"
                    />
                    <span class="text-danger">{{ errors.fullname }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Адрес</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="pupil.address"
                        :disabled="loading"
                    />
                    <span class="text-danger">{{ errors.address }}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>E-mail</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="pupil.email"
                        :disabled="loading"
                    />
                    <span class="text-danger">{{ errors.email }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Мобильный номер телефона</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="pupil.mobile_phone"
                        :disabled="loading"
                    />
                    <span class="text-danger">{{ errors.mobile_phone }}</span>
                </div>
            </div>
        </div>
        <div>
            <button
                :disabled="loading"
                @click.prevent="save"
                class="btn btn-success"
            >
                Сохранить
            </button>
        </div>
    </div>
</template>

<script>
import Loading from "../partial/Loading";

export default {
    components: {
        Loading
    },
    data() {
        return {
            loading: false,
            pupil: {
                fullname: "",
                address: "",
                email: "",
                mobile_phone: ""
            },
            errors: {
                fullname: "",
                address: "",
                email: "",
                mobile_phone: ""
            }
        };
    },
    computed: {
        isCreateScenario() {
            return this.$route.name === "PupilsCreate";
        },
        isUpdateScenario() {
            return this.$route.name === "PupilsUpdate";
        }
    },
    created() {
        if (this.isUpdateScenario) {
            const self = this;
            self.loading = true;

            axios
                .get(`/api/pupils/${self.$route.params.id}`)
                .then(response => {
                    self.pupil = response.data.data;
                })
                .finally(response => {
                    self.loading = false;
                });
        }
    },
    methods: {
        clearErrors() {
            this.errors = {
                fullname: "",
                address: "",
                email: "",
                mobile_phone: ""
            };
        },
        save() {
            const self = this;
            self.loading = true;
            self.clearErrors();

            const data = {
                fullname: self.pupil.fullname,
                address: self.pupil.address,
                mobile_phone: self.pupil.mobile_phone,
                email: self.pupil.email
            };

            if (this.isCreateScenario) {
                axios
                    .post("/api/pupils", data)
                    .then(response => {
                        alert("Новый ученик сохранён.");
                    })
                    .catch(function(error) {
                        self.catchErrors(error);
                    })
                    .finally(response => {
                        self.loading = false;
                    });
            } else if (this.isUpdateScenario) {
                axios
                    .put(`/api/pupils/${self.pupil.id}`, data)
                    .then(response => {
                        alert("Данные ученика обновлены.");
                    })
                    .catch(error => {
                        self.catchErrors(error);
                    })
                    .finally(response => {
                        self.loading = false;
                    });
            }
        },
        catchErrors(error) {
            if (error.response.status === 422) {
                if (
                    typeof error.response.data.errors["fullname"] !==
                    "undefined"
                ) {
                    this.errors.fullname =
                        error.response.data.errors["fullname"][0];
                }
                if (
                    typeof error.response.data.errors["email"] !== "undefined"
                ) {
                    this.errors.email = error.response.data.errors["email"][0];
                }
                if (
                    typeof error.response.data.errors["address"] !== "undefined"
                ) {
                    this.errors.address =
                        error.response.data.errors["address"][0];
                }
                if (
                    typeof error.response.data.errors["mobile_phone"] !==
                    "undefined"
                ) {
                    this.errors.mobile_phone =
                        error.response.data.errors["mobile_phone"][0];
                }
            }
        }
    }
};
</script>
