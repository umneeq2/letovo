<template>
    <div class="card mb-4">
        <div class="card-header">
            {{ "ID: #" + pupil.id + ", " + pupil.fullname }}
        </div>
        <div class="card-body">
            E-mail: {{ pupil.email }}<br />
            Мобильный телефон: {{ pupil.mobile_phone }}<br />
            Адрес проживания: {{ pupil.address }}<br />
            <span v-show="pupil.address_normalized"
                >Нормализованный адрес проживания: {{ pupil.address_normalized
                }}<br
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
                v-show="$route.name === 'PupilsList'"
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
</template>

<script>
export default {
    props: ["pupil"],
    components: {},
    data() {
        return {};
    },
    computed: {},
    created() {},
    methods: {
        normalize(id) {
            const self = this;

            self.$refs[`btn-normalize-${id}`].disabled = true;

            axios
                .post(`/api/pupils/normalize/${id}`)
                .then(response => {
                    self.pupil.address_normalized =
                        response.data.address_normalized;
                    self.pupil.geo_lat = response.data.geo_lat;
                    self.pupil.geo_lon = response.data.geo_lon;
                })
                .catch(function(error) {})
                .finally(response => {
                    self.$refs[`btn-normalize-${id}`].disabled = false;
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
