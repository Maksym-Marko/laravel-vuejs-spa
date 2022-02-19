<template>
  <div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">

      <div class="aside bg-white p-4 pe-0">
        
        <ul class="mx-admin-nav">
          <li>
            <router-link :to="{ name: 'admin' }" class="p-2 text-secondary d-block" exact>Dashboard</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'admin.news' }" class="p-2 text-secondary d-block">News</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'admin.pages' }" class="p-2 text-secondary d-block">Pages</router-link>
          </li>
        </ul>

      </div>

      <div class="wrapper d-flex flex-column flex-row-fluid pb-4 px-4 w-100">

        <div class="admin-header bg-white mb-4 p-4 d-flex align-items-center">

          <h6>Admin Dashboard</h6>

          <ul class="navbar-nav ms-auto">
            <!-- Authenticated -->
            <li v-if="user" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark"
                 href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
              >
                <img :src="user.photo_url" class="rounded-circle profile-photo me-1">
                {{ user.name }}
              </a>
              <div class="dropdown-menu">

                <router-link :to="{ name: 'settings.profile' }" class="dropdown-item ps-3">
                  <fa icon="cog" fixed-width />
                  {{ $t('settings') }}
                </router-link>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item ps-3" @click.prevent="logout">
                  <fa icon="sign-out-alt" fixed-width />
                  {{ $t('logout') }}
                </a>

              </div>
            </li>
          </ul>
          
        </div>

        <div class="bg-white p-4">

          <child />
          
        </div>        
        
      </div>

    </div>
  </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
  name: 'AdminLayout',

  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }

}

</script>

<style scoped>
  .dropdown-menu {
    margin: 0;
  }
  .router-link-active {
    background-color: #0dcaf0;
    color: white !important;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
  }
  .mx-admin-nav {
    list-style-type: none;
    padding: 0;
  }
  .aside {
    width: 300px;
    height: 100vh;
  }
</style>