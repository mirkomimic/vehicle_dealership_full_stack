<template>
  <v-btn @click="router.get(route('home.index'))">
    <v-icon>mdi-home</v-icon>

    <span>Home</span>
  </v-btn>

  <v-btn @click="router.get(route('profile.edit'))">
    <v-icon>mdi-account</v-icon>

    <span>Profile</span>
  </v-btn>

  <v-btn @click="router.get(route('vehicles.index'))">
    <v-icon>mdi-car-back</v-icon>

    <span>My Vehicles</span>
  </v-btn>

  <!-- <v-btn @click="router.get(route('logout'))">
    <v-icon>mdi-logout</v-icon>

    <span>Logout</span>
  </v-btn> -->

  <v-btn v-if="$page.props.auth.user?.is_admin" @click="router.get(route('dashboard.index'))">
    <v-icon>mdi-shield-account</v-icon>

    <span>Dashboard</span>
  </v-btn>
</template>

<script setup>
import { router } from '@inertiajs/vue3';


</script>