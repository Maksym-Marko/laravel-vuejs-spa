<template>
  <div>
    
    <form @submit.prevent="create">      
      
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input
          v-model="form.title"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('title') }"
        >
        <has-error
          v-if="form.errors.has('title')"
          :form="form" field="title"
        />
      </div>

      <div class="mb-3">
        <div class="d-flex justify-content-between">
          <label class="form-label">Post slug</label>
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
        <has-error
          v-if="form.errors.has('slug')"
          :form="form" field="slug"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Excerp</label>
        <textarea
          v-model="form.excerpt"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('excerpt') }"
        />
        <has-error
          v-if="form.errors.has('excerpt')"
          :form="form"
          field="excerpt"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Content</label>
        <editor
          :content="form.content"
          @content="setContent"
        />
        <has-error
          v-if="form.errors.has('content')"
          :form="form"
          field="content"
        />
      </div>      

      <button type="submit" class="btn btn-primary">Create</button>

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
    return { title: 'Admin panel. Create News Item page.' }
  },

  data: () => ({
    title: window.config.appName,
    newsItem: null,

    form: new Form({
      title:   '',
      excerpt: '',
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

    async create () {

      axios.post( '/api/admin/news/create', this.form )
        .then( ( res ) => {

          this.form.errors.set( {} )

          this.$store.dispatch( 'notification/notify', {
            message: 'Created!'
          } )

          this.$router.push( { name: 'admin.news' } )

        } )
        .catch( ( error ) => {

          let errors = {}

          this.form.errors.set( errors )

          for (const [key, value] of Object.entries( error.response.data.errors )) {

            errors[key] = value[0]            

          }

          this.form.errors.set( errors )

        } )

    }

  },

  watch: {

    'form': {
      handler: function( v ) {

        this.form.keys().forEach((key) => {

          if( this.form[key] !== '' ) {

            if( this.form.errors.errors[key] !== undefined ) {

              delete this.form.errors.errors[key]

            }

          }

        })

      },
      deep: true
    },

  },

  mounted() {
  

  }

}
</script>

<style scoped>
  .mx-success {
    left: unset;
  }
</style>