<template>
  <div
    v-if="page"
  >

    <h1>{{ page.title }}</h1>

    <div
      v-html="page.content"
    ></div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'Page template' }
  },

  data: () => ({
    title: window.config.appName,
    page: null
  }),

  computed: mapGetters({
    pages: 'pages/list'
  }),

  methods: {

    getPage() {

      const slug = this.$route.params.slug

      if( this.pages[slug] === undefined ) {

        axios.post( '/api/get-page/' + slug )
          .then( ( res ) => {

            if( res.data.id !== undefined ) {

              this.$store.dispatch( 'pages/addPage', {

                [slug]: res.data

              } )

              this.page = res.data

            } else {

              this.$router.push( { name: 'page404' } )

            }

          } )
          .catch( ( err ) => {

            console.log( err )

          } )

      } else {

        this.page = this.pages[slug]

      }

    }

  },

  mounted() {

    this.getPage()

  }

}
</script>