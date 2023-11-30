<template>
  <Carousel :items-to-show="4.5" :autoplay="6000" wrapAround>
    <Slide v-for="slide in latestVehicles" :key="slide">
      <v-hover v-slot="{ isHovering, props }">
        <v-card
          link
          @click="show(slide.id)"
          height="200"
          width="300"
          :image="`storage/images/vehicles/${slide.id}/${slide.images[0].img}`"
          v-bind="props"
        >
          <v-expand-transition>
            <v-card
              v-if="isHovering"
              class="transition-fast-in-fast-out v-card--reveal text-left text-teal-lighten-3 mm-blur"
              color="rgb(35, 36, 38, 0.6)"
              style="height: 100%;"
            >
              <v-card-title>{{ slide.brand.name }}</v-card-title>
              <v-card-subtitle>{{ slide.model.name }}</v-card-subtitle>

              <v-divider class="mt-4 mx-3"/>

              <v-card-text>
                <div>Mileage: {{ slide.mileage }}</div>
                <div>Year: {{ slide.year }}</div>
                <div>Price: {{ slide.price }}</div>
              </v-card-text>
            </v-card>
          </v-expand-transition>
          
          <div class="d-flex flex-column items-stretch h-100">
            <v-sheet class="mt-auto pa-2 text-teal-lighten-3 mm-blur" color="rgb(35, 36, 38, 0.6)">
              <div class="font-weight-bold">{{ slide.brand.name }}</div>
              <div>{{ slide.model.name }}</div>
            </v-sheet>
          </div>

        </v-card>
      </v-hover>
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

const props = defineProps(['latestVehicles'])

const show = (id) => {
  router.get(route('vehicles.show', id))
}
</script>

<style scoped>
.mm-blur {
  backdrop-filter: blur(10px);
}
</style>