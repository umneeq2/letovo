<template>
  <div class="_pagination">
    <nav v-if="meta.last_page > 1" aria-label="Pagination" class="mt-5">
      <ul class="pagination justify-content-center">
        <li :class="['page-item', { disabled: meta.current_page === 1 }]">
          <a
            @click.prevent="$emit('refresh-page', meta.current_page - 1)"
            class="page-link"
            href="#"
            tabindex="-1"
            aria-disabled="true"
            >Предыдущая</a
          >
        </li>

        <li
          v-for="n in meta.last_page"
          :key="n"
          :class="['page-item', { disabled: meta.current_page === n }]"
        >
          <template
            v-if="n < meta.current_page + 4 && n > meta.current_page - 4"
          >
            <a
              :class="['page-link', { current: meta.current_page === n }]"
              href="#"
              @click.prevent="$emit('refresh-page', n)"
              >{{ n }}</a
            >
          </template>
        </li>

        <li
          :class="[
            'page-item',
            { disabled: meta.last_page <= meta.current_page },
          ]"
        >
          <a
            @click.prevent="$emit('refresh-page', meta.current_page + 1)"
            class="page-link"
            href="#"
            aria-disabled="true"
            >Следующая</a
          >
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
// const meta = {
//     "meta": {
//         "current_page": 1,
//         "from": 1,
//         "last_page": 9,
//         "path": "http://new.kinocensor.localhost/api/ideas",
//         "per_page": 15,
//         "to": 15,
//         "total": 131
//     }
// };

export default {
  components: {},
  props: ["meta"],
  data() {
    return {};
  },
  created() {},
  methods: {
    // печатать? Если страниц больше 20-ти, нужно вырезать средние, чтобы пагинация не была на весь экран
    printIt() {},
  },
};
</script>

<style lang="scss">
// @import '../../../sass/_variables.scss';

._pagination {
  .current {
    background-color: #f0f0f0 !important;
  }
  a {
    color: #333;
  }
}
</style>
