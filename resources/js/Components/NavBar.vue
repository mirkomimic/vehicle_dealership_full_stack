<template>
  <v-toolbar
    color="transparent"
    density="compact"
  >
    <v-container>
      <div class="d-flex align-center justify-space-between">
        <div class="d-none d-md-block">
          <Link href="/">
            <img width="70" src="/icons/blue-car-logo.png">
          </Link>
        </div>

        <v-spacer></v-spacer>

        <div class="d-flex justify-center px-2" style="width: 400px;">
          <NavbarKeywordSearch/>
        </div>

        <v-spacer></v-spacer>

        <div class="d-flex align-center flex-shrink-0" style="gap: 10px;">
          <Link class="d-none d-md-block" v-if="$page.props.auth.user?.is_admin" href="/dashboard">
            <v-btn variant="tonal" color="grey-lighten-1">Dashboard</v-btn>
          </Link>

          <v-switch
            @click="toggleTheme"
            color="teal-lighten-3"
            class="mt-5"
            density="compact"
            inset
            true-icon="mdi-white-balance-sunny"
            false-icon="mdi-weather-night"
          ></v-switch>

          <CartDialog v-if="$page.props.auth.user"/>

          <Link v-if="!$page.props.auth.user" :href="route('login')">
            <v-btn variant="outlined" color="teal-lighten-3">Login</v-btn>
          </Link>
          <Link v-if="!$page.props.auth.user" :href="route('register')">
            <v-btn variant="tonal">Register</v-btn>
          </Link>

          <NavBarUserDropdown v-if="$page.props.auth.user"/>
        </div>
      </div>
    </v-container>
  </v-toolbar>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'
import NavBarUserDropdown from './Dropdowns/NavBarUserDropdown.vue';
import CartDialog from './Dialogs/CartDialog.vue';
import NavbarKeywordSearch from './Dialogs/NavbarKeywordSearch.vue';

const theme = useTheme()

function toggleTheme () {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}



</script>