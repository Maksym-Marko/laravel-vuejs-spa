<template>
	<div
      v-if="show"
      class="bg-success blockquote d-inline-block fixed-bottom m-4 p-4 rounded-3 text-center text-white w-25 mx-success"
    >{{ message }}</div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
	name: 'Notification',

	computed: mapGetters({
		show: 'notification/show',
		message: 'notification/message'
	}),
}
</script>