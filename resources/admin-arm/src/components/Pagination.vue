<template>
  <section class="pagination">
    <a
      v-if="hprevPage"
      :href="hallData.prev_page_url"
      @click.prevent="getPageData(prevPage)"
      class="pagination__prev-btn"
      >Назад</a
    >
    <ul class="pagination__list">
      <li
        v-for="(page, index) in getPagination"
        class="pagination__item"
        :class="{
          'pagination__item--current': page.active,
          'pagination__item--dots': !page.url,
        }"
        :key="index"
      >
        <a
          :href="page.url"
          :data-page="page"
          class="pagination__link"
          @click.prevent="getPageData(page.url)"
          >{{ page.label }}</a
        >
      </li>
    </ul>
    <a
      v-if="nextPage"
      :href="nextPage"
      @click.prevent="getPageData(nextPage)"
      class="pagination__more-btn"
      >Вперед</a
    >
  </section>
</template>
<script>
const links = [
  // MOCKS
  {},
  { active: true, label: '1', url: '12312312' },
  { active: false, label: '2', url: '12312312' },
  {},
]
export default {
  data() {
    return {}
  },
  props: {
    hallData: {
      type: Object,
      default: () => ({
        links,
        next_page_url: '123123123',
        prev_page_url: '123123123',
      }),
    },
    dataCallback: {
      type: Function,
      default: () => {},
    },
  },
  computed: {

    prevPage(){
      return this.hallData && this.hallData.prev_page_url ? this.hallData.prev_page_url : '' 
    },
    nextPage(){
      return this.hallData && this.hallData.next_page_url ? this.hallData.next_page_url : '' 
    },
    getPagination() {
      let reply = []
      if (this.hallData && this.hallData.links) {
        reply = [...this.hallData.links]
        reply.shift()
        reply.pop()
      }
      return reply
    },
  },
  methods: {
    getPageData(url) {
      if (url) {
        this.$axios.get(url).then((resp) => {
          this.dataCallback(resp.data)
        })
      }
    },
  },
}
</script>
