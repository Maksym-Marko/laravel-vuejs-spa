<template>
  <div>
    
    <p>This is the main page of the admin panel.</p>

  </div>
</template>

<script>
import axios from 'axios'

export default {
  middleware: 'admin',

  layout: 'admin',

  metaInfo () {
    return { title: 'Admin panel' }
  },

  data: () => ({
    title: window.config.appName
  }),

  mounted() {

    // axios.get( '/api/admin-test' )
    //   .then( ( res ) => {

    //     console.log(res)

    //   } )    

  }

}
</script>