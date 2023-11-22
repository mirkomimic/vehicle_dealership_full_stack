<template>
  <v-layout>
    <v-main>
      <v-fade-transition>
        <div v-if="animatePage">
          <slot/>
        </div>
      </v-fade-transition>
    </v-main>
  </v-layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';

let animatePage = ref(false)

onMounted(() => {
  animatePage = true
})
</script>