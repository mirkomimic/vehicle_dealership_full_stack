<template>
  <Carousel :items-to-show="4.5" :autoplay="6000" wrapAround>
    <Slide v-for="slide in latestVehicles" :key="slide">
      <VehicleCard :vehicle="slide"/>
    </Slide>

    <template #addons>
      <Navigation />
    </template>
  </Carousel>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'
import { router } from '@inertiajs/vue3';
import VehicleCard from '../Cards/VehicleCard.vue';

const props = defineProps(['latestVehicles'])

</script>