<template>

  <v-toolbar
    color="transparent"
    density="compact"
  >
    <v-container>
      <div class="d-flex align-center">
        <div>
          <Link href="/">
            <img width="70" class="" src="/icons/blue-car-logo.png" alt="">
          </Link>
        </div>
        <v-spacer></v-spacer>
        <div class="d-flex align-center" style="gap: 10px;">
          <Link v-if="$page.props.auth.user" href="/dashboard">
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

          <CartDialog/>

          <Link v-if="!$page.props.auth.user" :href="route('login')" >Login</Link>
          <Link v-if="!$page.props.auth.user" :href="route('register')" >Register</Link>

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

const theme = useTheme()

function toggleTheme () {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}



</script>