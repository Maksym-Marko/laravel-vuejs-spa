<template>
  <div>
    
    <form @submit.prevent="update">      
      
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input
          v-model="form.title"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('title') }"
        >
        <has-error :form="form" field="post_title" />
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between">
          <label class="form-label">Page slug</label>
          <button
            class="btn btn-primary"
            @click.prevent="setSlug()"
          >Create slug</button>
        </div>
        <input
          v-model="form.slug"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('slug') }"
        >
        <has-error :form="form" field="slug" />
      </div>

      <div class="mb-3">
        <label class="form-label">Content</label>
        <editor
          :content="form.content"
          @content="setContent"
        />
        <has-error :form="form" field="content" />
      </div>

      <button type="submit" class="btn btn-primary">Save</button>

    </form>

  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'
import Editor from '../../../components/Editor'

import { mxSlugCreatorMixin } from '../../../mixins/mxSlugCreatorMixin'

export default {
  mixins: [mxSlugCreatorMixin],

  middleware: 'admin',

  layout: 'admin',

  components: {
    Editor
  },

  metaInfo () {
    return { title: 'Admin panel. Edit News Item page.' }
  },

  data: () => ({
    
    title: window.config.appName,
    page: null,

    form: new Form({
      title:   '',
      content: '',
      slug:    ''
    }),

    success: false

  }),

  methods: {

    setSlug() {

      if( this.form.slug !== '' ) {

        if( confirm( 'Are you sure you want to change the slug?' ) ) {

          this.form.slug = this.createSlug( this.form.title )

        }

      } else {

        this.form.slug = this.createSlug( this.form.title )

      }

    },

    setContent( content ) {

      this.form.content = content

    },

    async update () {

      axios.post( '/api/admin/pages/edit/' + this.page.id, this.form )
        .then( ( res ) => {

          this.form.errors.set( {} )

          this.$store.dispatch( 'notification/notify', {
            message: 'Saved!'
          } )

          this.$router.push( { name: 'admin.pages' } )

        } )
        .catch( ( error ) => {

          let errors = {}

          this.form.errors.set( errors )

          for (const [key, value] of Object.entries( error.response.data.errors )) {

            errors[key] = value[0]            

          }

          this.form.errors.set( errors )

        } )

    },

    getPage() {

      if( this.$route.params.slug ) {

        let data = {
          slug: this.$route.params.slug
        }

        axios.post( '/api/admin/get-page', data )
          .then( ( res ) => {

            if( res.data.length === 0 ) {

              this.$router.push( { name: 'page404'} )

            } else {

              this.page = res.data[0]

              this.fillInForm()

            }

          } ) 

      }

    },

    fillInForm() {

      this.form.keys().forEach(key => {
        this.form[key] = this.page[key]
      })

    }

  },

  mounted() {

    this.getPage()    

  }

}
</script>

<style scoped>
  .mx-success {
    left: unset;
  }
</style>