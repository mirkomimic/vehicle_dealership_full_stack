<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar height="50">
      <NavBar></NavBar>
    </v-app-bar>

    <v-navigation-drawer
      class="d-none d-md-block"
      disable-resize-watcher
      expand-on-hover
      rail
    >
      <v-list>
        <v-list-item
          prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
          title="Sandra Adams"
          subtitle="sandra_a88@gmailcom"
        ></v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <Link :href="route('dashboard.index')">
          <v-list-item prepend-icon="mdi-home-variant" title="Home" value="Home">
          </v-list-item>
        </Link>
        <Link :href="route('dashboard.brands')">
          <v-list-item prepend-icon="mdi-folder" title="Brands" value="Brands">
          </v-list-item>
        </Link>
      </v-list>
    </v-navigation-drawer>

    <v-main class="h-100" style="">
        <slot/>
      </v-main>
  </v-layout>
</template>

<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Link } from '@inertiajs/vue3';


</script>

<style scoped>

</style>