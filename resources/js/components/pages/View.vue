<template>
    <div class="container">
        <router-link to="/">Список учеников</router-link>
        <h1 class="mb-4">Ученик</h1>

        <loading v-if="loading"></loading>
        <div v-else>
            <div v-if="pupil">
                <pupil-card :pupil="pupil"> </pupil-card>
            </div>
            <div v-else>
                Ученик не найден.
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
            pupil: null
        };
    },
    computed: {},
    created() {
        this.sendRequest();
    },
    methods: {
        sendRequest() {
            const self = this;

            axios
                .get(`/api/pupils/${self.$route.params.id}`)
                .then(response => {
                    self.pupil = response.data.data;
                })
                .catch(function(error) {})
                .finally(response => {
                    self.loading = false;
                });
        }
    }
};
</script>
