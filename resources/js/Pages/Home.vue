<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import SelectMinMaxYear from '@/Components/SelectOptions/SelectMinMaxYear.vue';
import SelectOptionsVuetify from '@/Components/SelectOptions/SelectOptionsVuetify.vue';
import MainLayout from '@/Layouts/MainLayout.vue';

import { useTheme } from 'vuetify'

import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import VueCarousel from '@/Components/Gallery/VueCarousel.vue';

const props = defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  brands: {
    type: Object,
  },
  models: {
    type: Object
  },
  years: {
    type: Array
  },
  latestVehicles: {
    type: Object,
  }
});

const processing = ref(false)

const form = useForm({
  brand: null,
  model: null,
  minYear: null,
  maxYear: null,
})

const submit = () => {
  processing.value = true
  setTimeout(() => {
    // processing.value = false
    form.get(route('vehicles.search'));
  }, 2000)
}

const resetFilter = () => {
  form.reset()
}

const theme = useTheme()

const switchColor = computed(() => {
  return theme.global.current.value.dark  ? 'teal-lighten-3' : 'teal-darken-3';
})
</script>

<template>
  <Head title="Welcome" />

  <MainLayout>
    <!-- Main Page Filter -->
    <v-sheet class="pa-5 mt-16 mx-auto mm-border-green" :width="900" border="sm" rounded>

      <div>
        <SelectOptionsVuetify
          :brands="brands"
          :models="models"
          v-model:selected-brand="form.brand"
          v-model:selected-model="form.model"
        />
      </div>


      <div>
        <SelectMinMaxYear
          :years="years"
          v-model:selected-min-year="form.minYear"
          v-model:selected-max-year="form.maxYear"
        />
      </div>

      <div class="tw-flex tw-gap-3">
        <v-btn variant="outlined" :color="switchColor">More options</v-btn>
        <v-btn
          @click="submit"
          :loading="processing"
          :disabled="processing"
          color="teal-darken-3"
          prepend-icon="mdi-magnify"
          >Search
        </v-btn>
        <v-btn @click="resetFilter" variant="plain" class="px-0">
          <span class="tw-underline">Clear search</span>
        </v-btn>
      </div>
      
    </v-sheet>

    <v-divider class="mt-16 mb-8 mx-10"></v-divider>

    <div class="text-h4 text-center text-uppercase text-teal-darken-1 mb-3">Latest</div>

    <v-sheet color="transparent">
      <VueCarousel :latestVehicles="latestVehicles"/>
    </v-sheet>

    <v-divider class="mt-16 mb-8 mx-10"></v-divider>

    <div>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Consequuntur labore iste commodi aperiam repellendus libero provident illo soluta cum. Animi sed, quos tempora iusto ut libero suscipit ipsum ipsa consequatur!</div>

    <MainFooter/>
  </MainLayout>

</template>

<style scoped>
.mm-border-green {
  border-color: #28896b !important;
}
html {
  scroll-behavior: smooth;
}
</style>
