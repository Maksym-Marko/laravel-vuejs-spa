<template>
  <div class="row">

    <div
      v-if="newsItem"
      class="col-md-12 p-4"
    >

      <h1 class="mb-4">{{ newsItem.post_title }}</h1>

      <span>Date: {{ newsItem.created_at }}</span>

      <div>

        {{ newsItem.post_content }}

      </div>
      
    </div>

  </div>

</template>

<script>
import axios from 'axios'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'News single' }
  },

  data: () => ({
    title: window.config.appName,
    newsItem: null
  }),

  methods: {

    getNewsItem() {

      if( this.$route.params.slug ) {

        let data = {
          slug: this.$route.params.slug
        } 

        axios.post( '/api/get-news-item', data )
          .then( ( res ) => {

            if( res.data.length === 0 ) {

              this.$router.push( { name: 'page404'} )

            } else {

              this.newsItem = res.data[0]

            }

          } ) 

      }

    }

  },

  mounted() {
    
    this.getNewsItem()

  }
 
}
</script>