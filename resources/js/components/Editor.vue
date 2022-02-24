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

import 'tinymce/plugins/image/plugin'
import 'tinymce/plugins/paste/plugin'
import 'tinymce/plugins/advlist/plugin'
import 'tinymce/plugins/autolink/plugin'
import 'tinymce/plugins/lists/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/charmap/plugin'
import 'tinymce/plugins/print/plugin'
import 'tinymce/plugins/preview/plugin'
import 'tinymce/plugins/anchor/plugin'
import 'tinymce/plugins/searchreplace/plugin'
import 'tinymce/plugins/visualblocks/plugin'
import 'tinymce/plugins/code/plugin'
import 'tinymce/plugins/fullscreen/plugin'
import 'tinymce/plugins/insertdatetime/plugin'
import 'tinymce/plugins/media/plugin'
import 'tinymce/plugins/table/plugin'
import 'tinymce/plugins/wordcount/plugin'

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
				},
				
				plugins: [
					'advlist autolink lists link image charmap print preview anchor',
					'searchreplace visualblocks code fullscreen',
					'insertdatetime media table paste wordcount'
				],
				toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',

				// image upload
				images_upload_url: '/api/admin/image-upload',
				images_upload_base_path: '/images',
				file_picker_types: 'image',
				content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'

			})

		}

	},

	mounted() {

		this.tinymceInit()

	}

}
</script>

<style scoped>
  @import 'tinymce/skins/ui/oxide/skin.min.css';
</style>