<template>
  <!-- :autoplay="3000" -->
  <carousel :items-to-show="3.5"  wrapAround>
    <slide v-for="slide in latestVehicles" :key="slide">
      <v-hover v-slot="{ isHovering, props }">
        <v-card
          hover
          height="200"
          width="300"
          :image="`storage/images/vehicles/${slide.id}/${slide.images[0].img}`"
          v-bind="props"
        >
          <v-fade-transition>
            <v-card
              v-if="isHovering"
              class="transition-fast-in-fast-out v-card--reveal text-left text-teal-lighten-3"
              color="rgb(35, 36, 38, 0.9)"
              style="height: 100%;"
            >
              <v-card-title>{{ slide.brand.name }}</v-card-title>
              <v-card-subtitle>{{ slide.model.name }}</v-card-subtitle>
              <v-card-text>
                <div>Mileage: {{ slide.mileage }}</div>
                <div>Year: {{ slide.year }}</div>
                <div>Price: {{ slide.price }}</div>
              </v-card-text>
            </v-card>
          </v-fade-transition>
        </v-card>
      </v-hover>
    </slide>

    <template #addons>
      <navigation />
    </template>
  </carousel>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'

const props = defineProps(['latestVehicles'])
</script>