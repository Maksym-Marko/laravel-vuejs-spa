<template>

  <div>
    
    <div
      v-show="loaded"
      class="card-body pt-0"
    >

      <div class="d-flex justify-content-end mb-4">
        <router-link :to="{ name: 'admin.pages.create' }" class="btn btn-primary">
          Add Page
        </router-link>
      </div>
      

      <div class="table-responsive">
        
        <table          
          class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
        >

          <thead>
            
            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
              
              <th class="min-w-200px">
                
                Title

              </th>

              <th class="text-end min-w-100px">
                
                Status

              </th>

              <th class="text-end min-w-70px">
                
                Actions 

              </th>
                
            </tr>

          </thead>

          <tbody
            v-if="pages.length>0"
          >
            
            <tr
              v-for="item in pages"
            >
              
              <td>
                <router-link :to="'/admin/pages/edit/' + item.slug" class="blockquote">
                  {{ item.title }}
                </router-link>
              </td>

              <td class="text-end">
                <span class="mx-publish">publish</span> 
              </td>
              <td class="d-flex justify-content-end text-end">
                
                <div class="d-flex justify-content-between max-w-100px w-100">
                  
                  <router-link :to="'/admin/pages/edit/' + item.slug" class="text-success">
                    <i class="far fa-edit"></i>
                  </router-link>

                  <a
                    href="#"
                    class="text-danger"
                    @click.prevent="removePost( item.id )"
                  ><i class="fas fa-trash-alt"></i></a>

                </div>

              </td>

            </tr>

          </tbody>
          
        </table>

      </div>
      
    </div>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  middleware: 'admin',

  layout: 'admin',

  metaInfo () {
    return { title: 'Admin panel. Pages.' }
  },

  data: () => ({
    title: window.config.appName,
    loaded: false
  }),

  computed: mapGetters({
    pages: 'admin/pages/list'
  }),

  methods: {

    removePost( id ) {

      // if ( window.confirm( 'Do you want to delete this post?' ) ) {        
      
      //   axios.post( '/api/admin/news/destroy/' + id, { post_id: id } )
      //     .then( ( res ) => {

      //       if( res.data === 'success' ) {

      //         this.news.map( ( v, i ) => {

      //           if( v.id === id ) {

      //              this.news.splice( i, 1 )

      //           }         

      //         } )

      //       }

      //     } )

      // }

    },

    async getPages() {

      if( this.pages.length === 0 ) {

        let { data } = await axios.get( '/api/admin/get-pages' )

        // save pages list
        await this.$store.dispatch( 'admin/pages/setPages', {
          list: data
        } )

      }

      this.loaded = true

    }

  },

  mounted() {

    this.getPages()

  }

}
</script>

<style scoped>

</style>