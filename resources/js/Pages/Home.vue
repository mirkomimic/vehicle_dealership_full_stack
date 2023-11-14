<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';
import SelectMinMaxYear from '@/Components/SelectOptions/SelectMinMaxYear.vue';
import SelectOptionsBrandModel from '@/Components/SelectOptions/SelectOptionsBrandModel.vue';
import SelectOptionsBrandModelWithVModel from '@/Components/SelectOptions/SelectOptionsBrandModelWithVModel.vue';
import SelectOptionsVuetify from '@/Components/SelectOptions/SelectOptionsVuetify.vue';
import MainLayout from '@/Layouts/MainLayout.vue';

import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

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
  }
});
// const { brands, models } = toRefs(props)

let selectedBrand = ref(null)
let selectedModel = ref(null)
let selectedMinYear = ref(null)
let selectedMaxYear = ref(null)

</script>

<template>
  <Head title="Welcome" />
  <NavBar />
  <MainLayout>
    <!-- Main Page Filter -->
    <div class="tw-max-w-[900px] tw-p-3 tw-mx-auto tw-border dark:tw-border-[#28896b] tw-rounded-sm tw-mt-16 tw-h-[300px] dark:tw-bg-[#41414124]">

      <div>
        <SelectOptionsVuetify
          :brands="brands"
          :models="models"
          v-model:selected-brand="selectedBrand"
          v-model:selected-model="selectedModel"
        />
      </div>

      <div>
        <SelectMinMaxYear
          :years="years"
          v-model:selected-min-year="selectedMinYear"
          v-model:selected-max-year="selectedMaxYear"
        />
      </div>

      <div class="tw-flex tw-gap-3">
        <v-btn variant="outlined" color="teal-lighten-3">More options</v-btn>
        <v-btn color="teal-darken-3" prepend-icon="mdi-magnify">Search</v-btn>
      </div>

      <!-- <v-btn color="teal-darken-3">
        <template v-slot:prepend>
          <v-icon color="red-darken-4" icon="mdi-magnify"></v-icon>
        </template>
        btn
      </v-btn> -->

    </div>
  </MainLayout>

  <MainFooter />
</template>