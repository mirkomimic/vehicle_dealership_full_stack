<template>
  <div style="width: 1300px;" class="bg-black h-screen">
    <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide">
      <Slide v-for="slide in vehicle.images" :key="slide">
        <div class="carousel__item">
          <v-img
            :width="1000"
            :height="650"
            :src="`../storage/images/vehicles/${vehicle.id}/${slide.img}`"
          />
        </div>
      </Slide>
      <template #addons>
        <Navigation>
          <template #next>
            <span>
              <v-btn icon="mdi-arrow-right"></v-btn>
            </span>
          </template>
          <template #prev>
            <span>
              <v-btn icon="mdi-arrow-left"></v-btn>
            </span>
          </template>
        </Navigation>
      </template>
    </Carousel>
    <Carousel
      id="thumbnails"
      :items-to-show="vehicle.images.length > 5 ? 5 : vehicle.images.length"
      :wrap-around="true"
      v-model="currentSlide"
      ref="carousel"
    >
      <Slide v-for="(slide, index) in vehicle.images" :key="slide">
        <div class="carousel__item" @click="slideTo(index)">
          <v-img
            :width="100"
            :height="100"
            cover
            :src="`../storage/images/vehicles/${vehicle.id}/${slide.img}`"
            class="mb-5"
          />
        </div>
      </Slide>
    </Carousel>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Carousel, Slide, Navigation } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'

const props = defineProps(['vehicle'])

const currentSlide = ref(0)

const slideTo = (val) => {
  currentSlide.value = val
}
</script>