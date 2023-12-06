<template>
  <nav class="tw-w-full">
    <div class="tw-container tw-container-sm tw-mx-auto tw-w-full tw-h-full tw-flex tw-items-center">
      <div>
        <Link href="/">
          <img width="70" class="" src="/icons/blue-car-logo.png" alt="">
        </Link>
      </div>
      <v-spacer></v-spacer>
      <div class="tw-flex tw-items-center tw-justify-center tw-gap-4 tw-text-[20px]">
        <v-switch
          @click="toggleTheme"
          color="teal-lighten-3"
          class="mt-5"
          inset
          true-icon="mdi-white-balance-sunny"
          false-icon="mdi-weather-night"
        ></v-switch>
        <Link v-if="!$page.props.auth.user" :href="route('login')">Login</Link>
        <Link v-if="!$page.props.auth.user" :href="route('register')">Register</Link>
        <Link v-if="$page.props.auth.user" href="/dashboard">Dashboard</Link>
        <NavBarUserDropdown v-if="$page.props.auth.user"/>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { useTheme } from 'vuetify'
import NavBarUserDropdown from './Dropdowns/NavBarUserDropdown.vue';

const theme = useTheme()

function toggleTheme () {
  theme.global.name.value = theme.global.current.value.dark ? 'light' : 'dark'
}



</script>