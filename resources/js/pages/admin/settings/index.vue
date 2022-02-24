<template>

	<form @submit.prevent="saveOptions">
		<SetHomePage
			@homePageId="setHomePage"
			:errors="errors"
		/>

		<div class="mt-5">
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>
	
</template>

<script>
import axios from 'axios'
import SetHomePage from './SetHomePage.vue'
import Form from 'vform'

export default {
  middleware: 'admin',

  components: {
		SetHomePage
  },

  layout: 'admin',

  metaInfo () {
    return { title: 'Admin panel. Settings.' }
  },

  data: () => ( {

  	form: new Form( {

  		homePageId: 0

  	} ),

  	errors: {}

  } ),

  methods: {
  	setHomePage( id ) {

  		this.form.homePageId = id

  	},
  	saveOptions() {

  		axios.post( '/api/admin/set-options', this.form )
  			.then( ( res ) => {

  				this.errors = {}

  				this.$store.dispatch( 'notification/notify', {
  					message: 'Settings Saved!'
  				} )

  			} )
  			.catch( ( err ) => {

  				this.errors = err.response.data.errors

  			} )

  	}
  }

}
</script>