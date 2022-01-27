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
import axios from 'axios'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'News' }
  },

  data: () => ({
    title: window.config.appName,
    news: [],
    loaded: false
  }),

  methods: {

    getNews() {

      axios.get( '/api/get-news' )
        .then( ( res ) => {

          this.news = res.data

          this.loaded = true

        } )

    }

  },

  mounted() {

    this.getNews()

  }
 
}
</script>