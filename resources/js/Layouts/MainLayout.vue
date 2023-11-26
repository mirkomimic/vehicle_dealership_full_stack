<template>
  <v-layout>
    <v-app-bar 
      class="tw-backdrop-blur-sm tw-opacity-80"
      scroll-behavior="hide"
      scroll-threshold="50"
      elevation="2"
    >
      <NavBar></NavBar>
    </v-app-bar>

    <v-main class="h-screen">
      <v-fade-transition>
        <div v-if="animatePage" class="">
          <slot/>
        </div>
      </v-fade-transition>
    </v-main>
  </v-layout>
</template>

<script setup>
import NavBar from '@/Components/NavBar.vue';
import { ref, onMounted } from 'vue';

let animatePage = ref(false)

onMounted(() => {
  animatePage = true
})
</script>