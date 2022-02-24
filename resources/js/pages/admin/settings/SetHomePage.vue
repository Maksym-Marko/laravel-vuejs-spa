<template>
	<div>
		<h3>Set Home Page</h3>

		<select
			class="form-select form-control"
			aria-label="Set Home Page"
			@change="setHomePage( $event )"
			:class="{ 'is-invalid': errors.homePageId }"
			v-model="homePageId"
		>
			<option value="0">No page selected</option>
			<option
				v-for="page in pages"
				:value="page.id"
			>{{ page.title }}</option>

		</select>

		<div
			v-if="errors.homePageId"
			class="invalid-feedback d-block"
		>
			<p v-for="error in errors.homePageId">{{ error }}</p>
		</div>
		
	</div>
</template>

<script>
import axios from 'axios'

export default {
	name: 'SetHomePage',

	props: {
		errors: Object
	},

	data: () => ( {
		pages: [],
		homePageId: 0
	} ),

	methods: {

		setHomePage( e ) {

			this.$emit( 'homePageId', e.target.value )

		},

		getHomePage() {

			axios.get( '/api/get-home-page' )
				.then( ( res ) => {

					if( typeof res.data.value !== undefined ) {

						this.homePageId = res.data.value

					}

				} )

		},

		getAvailablePages() {

			axios.get( '/api/admin/get-available-pages' )
				.then( ( res ) => {

					this.pages = res.data

				} )

		}

	},

	mounted() {

		this.getHomePage()

		this.getAvailablePages()

	}
}
</script>