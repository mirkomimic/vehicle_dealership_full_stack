<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar class="tw-backdrop-blur-sm tw-opacity-80">
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
          :prepend-avatar="$page.props.auth.user.image || '/user-placeholder.png'"
          :title="$page.props.auth.user.name"
          :subtitle="$page.props.auth.user.email"
        ></v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list density="compact" nav>
        <Link :href="route('dashboard.index')">
          <v-list-item
            prepend-icon="mdi-home-variant"
            :active="$page.url == '/dashboard'"
            title="Home"
            value="Home"
          ></v-list-item>
        </Link>
        <Link :href="route('dashboard.brands')">
          <v-list-item
            prepend-icon="mdi-folder"
            :active="$page.url == '/dashboard/brands'"
            title="Brands"
            value="Brands"
          ></v-list-item>
        </Link>
      </v-list>
    </v-navigation-drawer>

    <v-main class="h-100" style="">
        <v-fade-transition>
          <div v-if="animatePage">
            <slot/>
          </div>
        </v-fade-transition>
      </v-main>
  </v-layout>
</template>

<script setup>
import NavBar from '@/Components/NavBar.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';

let animatePage = ref(false)

onMounted(() => {
  animatePage = true
})

</script>

<style scoped>

</style>