<template>
  <div
    v-show="loaded"
  >
   
    <div
      v-if="homePageId === 0"
    >

      <h1 class="mt-5 text-center">Home Page doesn't setted up!</h1>

    </div>
    <div
      v-else
    >
      
      <div
        v-if="page"
      >

        <h1>{{ page.title }}</h1>

        <div
          v-html="page.content"
        ></div>
      </div>

    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'Home Page' }
  },

  data: () => ({
    title: window.config.appName,
    homePageId: 0,
    page: null,
    loaded: false
  }),

  computed: mapGetters({
    pages: 'pages/list'
  }),

  methods: {

    getHomePageId() {

      axios.get( '/api/get-home-page' )
        .then( ( res ) => {

          if( typeof res.data.value !== undefined && parseInt( res.data.value ) !== 0 ) {

            this.homePageId = res.data.value            

            this.getPageById()

          }

          this.loaded = true

        } )

    },

    getPageById() {

      axios.post( '/api/get-page-by-id/' + this.homePageId )
        .then( ( res ) => {

          const slug = res.data.slug

          if( this.pages[slug] === undefined ) {

            if( res.data.id !== undefined ) {

              this.$store.dispatch( 'pages/addPage', {

                [slug]: res.data

              } )

                this.page = res.data

              } else {

                this.$router.push( { name: 'page404' } )

              }

          } else {

            this.page = this.pages[slug]

          }

        } )
        .catch( ( err ) => {

          console.log( err )

        } )      

    }

  },

  mounted() {

    this.getHomePageId()

  }

}
</script>

<style scoped>

</style>
