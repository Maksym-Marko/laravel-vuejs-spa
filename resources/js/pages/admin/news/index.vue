<template>
  <div>
    
    <div
      v-show="loaded"
      class="card-body pt-0"
    >

      <div class="d-flex justify-content-end mb-4">
        <router-link :to="{ name: 'admin.news.create' }" class="btn btn-primary">
          Add News Item
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
            v-if="news.length>0"
          >
            
            <tr
              v-for="item in news"
            >
              
              <td>
                <router-link :to="'/admin/news/edit/' + item.post_slug" class="blockquote">
                  {{ item.post_title }}
                </router-link>
              </td>

              <td class="text-end">
                <span class="mx-publish">publish</span> 
              </td>
              <td class="d-flex justify-content-end text-end">
                
                <div class="d-flex justify-content-between max-w-100px w-100">
                  
                  <router-link :to="'/admin/news/edit/' + item.post_slug" class="text-success">
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
import axios from 'axios'

export default {
  middleware: 'admin',

  layout: 'admin',

  metaInfo () {
    return { title: 'Admin panel. News page.' }
  },

  data: () => ({
    title: window.config.appName,
    news: [],
    loaded: false
  }),

  methods: {

    removePost( id ) {

      if ( window.confirm( 'Do you want to delete this post?' ) ) {        
      
        axios.post( '/api/admin/news/destroy/' + id, { post_id: id } )
          .then( ( res ) => {

            if( res.data === 'success' ) {

              this.news.map( ( v, i ) => {

                if( v.id === id ) {

                   this.news.splice( i, 1 )

                }         

              } )

            }

          } )

      }

    },

    getNews() {

      axios.get( '/api/admin/get-news' )
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

<style scoped>
  .mx-publish {
    padding: 8px 18px;
    background-color: #8fd18f;
    border-radius: 21px;
    color: #fff;
    line-height: 18px;
    display: inline-block;
  }
  .max-w-100px {
    max-width: 100px;
  }
  .table > :not(caption) > * > * {
    border-bottom-width: 0;
  }
  .table thead {
    border-color: #000000;
    border-bottom-width: 2px;
  }
  .table tbody tr {
    border-color: #d3d3d3;
    border-bottom-width: 1px;
  }
</style>