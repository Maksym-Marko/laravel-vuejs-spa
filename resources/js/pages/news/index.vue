<template>
  <div
    v-show="loaded"
    class="row"
  >

    <div
      v-if="news.length>0"
      class="col-md-12"
    >

      <div
        v-for="item in news"
        class="bg-white p-4 mb-4">
        <h2>{{ item.post_title }}</h2>
        <p>{{ item.post_excerpt }}</p>

        <router-link :to="'/news/' + item.post_slug">Read More</router-link>
      </div>
      
    </div>

    <div 
      v-else
      class="col-md-12"
    >
      No news!
    </div>

  </div>

</template>

<script>

import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'News' }
  },

  data: () => ({
    title: window.config.appName,
    loaded: false
  }),

  computed: mapGetters({
    news: 'news/list'
  }),

  methods: {

    async getNews() {

      if( this.news.length === 0 ) {

        let { data } = await axios.get( '/api/get-news' )

        // save news list
        await this.$store.dispatch( 'news/setNews', {
          list: data
        } )

      }

      this.loaded = true

    }

  },

  mounted() {

    this.getNews()

  }
 
}
</script>