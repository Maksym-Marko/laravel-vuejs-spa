export const mxSlugCreatorMixin = {

	methods: {

		createSlug( title ) {

			const regex = /[\W_]+/g

			return title.replace( regex, '-' ).toLowerCase()

		}

	}

}