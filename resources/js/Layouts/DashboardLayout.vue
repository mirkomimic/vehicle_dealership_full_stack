<template>
  <v-layout class="rounded rounded-md">
    <v-app-bar 
      scroll-behavior="hide"
      scroll-threshold="50"
      elevation="2"
    >
      <NavBar></NavBar>
    </v-app-bar>

    <v-navigation-drawer
      :disable-resize-watcher="true"
      expand-on-hover
      permanent
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

    <v-main class="h-100">
        <v-fade-transition>
          <div v-if="animatePage">
            <slot/>
          </div>
        </v-fade-transition>
      </v-main>

      <v-bottom-navigation :elevation="0" v-if="display.smAndDown">
        <BottomNav/>
      </v-bottom-navigation>

  </v-layout>
</template>

<script setup>
import BottomNav from '@/Components/BottomNav.vue';
import NavBar from '@/Components/NavBar.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useDisplay } from 'vuetify/lib/framework.mjs';

const display = ref(useDisplay()) 
let animatePage = ref(false)

onMounted(() => {
  animatePage = true
})

</script>
