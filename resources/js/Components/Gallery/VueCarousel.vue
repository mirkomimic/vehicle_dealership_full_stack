<template>
  <carousel :items-to-show="3.5" :autoplay="3000" wrapAround>
    <slide v-for="slide in 3" :key="slide">
      <v-card height="100">{{ slide }}</v-card>
    </slide>

    <template #addons>
      <navigation />
      <pagination />
    </template>
  </carousel>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
</script>