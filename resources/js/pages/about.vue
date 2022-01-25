<template>
  <div>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat dicta vero magni culpa. Eaque, nesciunt quasi dolorem hic fuga perferendis dignissimos debitis reprehenderit, qui recusandae, esse illo. Accusamus, esse, ipsa.
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'default',

  metaInfo () {
    return { title: 'About' }
  },

  data: () => ({
    title: window.config.appName
  })

}
</script>