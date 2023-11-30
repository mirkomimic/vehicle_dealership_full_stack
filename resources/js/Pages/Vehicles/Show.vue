<template>
  <Head title="Vehicle"/>
  <MainLayout>

    <v-overlay v-model="galleryOverlay" class="d-none d-md-flex items-center justify-center">
      <FullScreenVueCarouselGallery :vehicle="vehicle"/>
    </v-overlay>

    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <VueCarouselGallery 
            :vehicle="vehicle" v-model:gallery-overlay="galleryOverlay"
          />
        </v-col>
        <v-col
          cols="12"
          md="6"
          class="mt-md-15"
        >
          <v-table density="comfortable">
            <tbody>
              <tr>
                <td>ID</td>
                <td>{{ vehicle.id }}</td>
              </tr>
              <tr>
                <td>Year</td>
                <td>{{ vehicle.year }}</td>
              </tr>
              <tr>
                <td>Brand</td>
                <td>{{ vehicle.brand.name }}</td>
              </tr>
              <tr>
                <td>Model</td>
                <td>{{ vehicle.model.name }}</td>
              </tr>
              <tr>
                <td>Mileage</td>
                <td>{{ vehicle.mileage }}</td>
              </tr>
              <tr>
                <td>Price</td>
                <td>{{ vehicle.price }}</td>
              </tr>
              <tr>
                <td>Created</td>
                <td>{{ new Date(vehicle.created_at).toLocaleDateString() }}</td>
              </tr>
            </tbody>
          </v-table>
        </v-col>
      </v-row>
    </v-container>
  </MainLayout>
  <MainFooter/>
</template>

<script setup>
import FullScreenVueCarouselGallery from '@/Components/Gallery/FullScreenVueCarouselGallery.vue';
import VueCarouselGallery from '@/Components/Gallery/VueCarouselGallery.vue';
import MainFooter from '@/Components/MainFooter.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['vehicle'])

const galleryOverlay = ref(false)
</script>