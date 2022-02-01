<template>
	<input
		:value="content"
    	id="tinymce"
    />
</template>

<script>

import tinymce from 'tinymce/tinymce'
import 'tinymce/themes/silver'
import 'tinymce/icons/default/icons'

// import 'tinymce/plugins/image/plugin'
// import 'tinymce/plugins/paste/plugin'

export default {

	name: 'Editor',

	props: {
		content: {
			type: String
		}
	},

	data: () => ({

	}),

	methods: {

		tinymceInit() {

			const _this = this

			tinymce.remove()

			tinymce.init({
				selector: '#tinymce',
				height: 400,
				init_instance_callback: function( editor ) {

					editor.on( 'change', function( e ) {

						_this.$emit( 'content', editor.getContent() )

					});
				}
			})

		}

	},

	mounted() {

		this.tinymceInit()

	}

}
</script>