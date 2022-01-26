<template>
  <div>
    
    <form @submit.prevent="create">      
      
      <div class="mb-3">
        <label class="form-label">Title</label>
        <input
          v-model="form.post_title"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('post_title') }"
        >
        <has-error
          v-if="form.errors.has('post_title')"
          :form="form" field="post_title"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Post slug</label>
        <input
          v-model="form.post_slug"
          type="text"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('post_slug') }"
        >
        <has-error
          v-if="form.errors.has('post_slug')"
          :form="form" field="post_slug"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Excerp</label>
        <textarea
          v-model="form.post_excerpt"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('post_excerpt') }"
        />
        <has-error
          v-if="form.errors.has('post_excerpt')"
          :form="form"
          field="post_excerpt"
        />
      </div>

      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea
          v-model="form.post_content"
          class="form-control"
          :class="{ 'is-invalid': form.errors.has('post_content') }"
        />
        <has-error
          v-if="form.errors.has('post_content')"
          :form="form"
          field="post_content"
        />
      </div>

      <button type="submit" class="btn btn-primary">Create</button>

    </form>

    <div
      v-if="success"
      class="bg-success blockquote d-inline-block fixed-bottom m-4 p-4 rounded-3 text-center text-white w-25 mx-success"
    >Created!</div>

  </div>
</template>

<script>
import axios from 'axios'
import Form from 'vform'

export default {
  middleware: 'admin',

  layout: 'admin',

  metaInfo () {
    return { title: 'Admin panel. Create News Item page.' }
  },

  data: () => ({
    title: window.config.appName,
    newsItem: null,

    form: new Form({
      post_title:   '',
      post_excerpt: '',
      post_content: '',
      post_slug:    ''
    }),

    success: false

  }),

  methods: {

    async create () {

      axios.post( '/api/admin/news/create', this.form )
        .then( ( res ) => {

          this.form.errors.set( {} )

          this.showSuccess();

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

    showSuccess() {

      this.success = true

      setTimeout( () => {

        this.success = false

        this.$router.push( { name: 'admin.news' } )

      }, 2000 )

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