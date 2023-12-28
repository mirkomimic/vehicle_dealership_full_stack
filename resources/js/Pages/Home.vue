<script setup>
import SelectMinMaxYear from '@/Components/SelectOptions/SelectMinMaxYear.vue';
import SelectOptionsVuetify from '@/Components/SelectOptions/SelectOptionsVuetify.vue';
import MainLayout from '@/Layouts/MainLayout.vue';

import { useTheme } from 'vuetify'

import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, watch } from 'vue';
import VueCarousel from '@/Components/Gallery/VueCarousel.vue';
import BtnToggleVehicleType from '@/Components/BtnToggle/BtnToggleVehicleType.vue';

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
  },
  vehiclesCount: {
    type: Object,
  }
});

const processing = ref(false)
const moreOptions = ref(false)
const numOfVehicles = ref(null)
const token = ref(null)

const form = useForm({
  brand: null,
  model: null,
  minYear: null,
  maxYear: null,
  type: null,
  mileageRange: [0, 500000]
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

const getToken = () => {
  fetch('/api/token', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({id: usePage().props.auth.user.id})
  }).then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json()
  }).then(data => {
    token.value = data.token
  }).catch(error => {
    console.log(error);
  })
}

const numOfVehiclesApi = () => {
  processing.value = true

  fetch('/api/search', {
    method: 'POST',
    headers: {
      // 'Authorization': `Bearer ${token.value}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(form)
  }).then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    processing.value = false
    return response.json();
  }).then(data => {
    numOfVehicles.value = data.vehicles
  }).catch(error => {
    console.log(error);
  })
}

onMounted(() => {
  getToken()
})


watch(form, () => {
  numOfVehiclesApi()
})

</script>

<template>
  <Head title="Welcome" />

  <MainLayout>

    <!-- Main Page Filter -->
    <div class="mt-16 mx-auto mm-border-green rounded-sm" style="width: 900px;">
      <v-sheet class="pa-5" rounded>
        <div class="mb-4">
          <BtnToggleVehicleType v-model:type="form.type"/>
        </div>
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

        <div>
          <v-expand-transition>
            <div v-if="moreOptions">
              <div class="mt-3">
                <v-range-slider
                  v-model="form.mileageRange"
                  :min="0"
                  :max="500000"
                  strict
                  density="compact"
                  color="teal-darken-3"
                  elevation="10"
                  label="Mileage"
                  step="1000"
                  thumb-label="true"
                ></v-range-slider>
              </div>
            </div>
          </v-expand-transition>
        </div>

        <div class="d-flex ga-3">
          <v-btn
            @click="moreOptions = !moreOptions"
            variant="outlined"
            :color="switchColor"
            >{{ moreOptions ? 'Less Options' : 'More Options' }}
          </v-btn>
          <v-btn
            @click="submit"
            :loading="processing"
            :disabled="processing"
            color="teal-darken-3"
            prepend-icon="mdi-magnify"
            text="Search"
          >
            <template v-slot:append>
              ({{ numOfVehicles }})
            </template>
          </v-btn>
          <v-btn @click="resetFilter" variant="plain" class="px-0">
            <span class="text-decoration-underline">Clear search</span>
          </v-btn>
        </div>      
      </v-sheet>
    </div>

    <v-divider class="mt-16 mb-8 mx-10"></v-divider>

    <div class="text-h4 text-center text-uppercase text-teal-darken-1 mb-3">Latest</div>

    <v-sheet color="transparent">
      <VueCarousel :latestVehicles="latestVehicles"/>
    </v-sheet>

    <v-divider class="mt-16 mb-8 mx-10"></v-divider>

    <v-sheet color="transparent" class="mb-3 w-75 mx-auto">
      <v-row>
        <v-col
          v-for="(item, index) in 3" :key="index"
          cols="12"
          md="4"
        >
          <v-lazy
            :options="{
              'threshold':1.0,
            }"
            transition="fade"
          >
            <div>
              <v-hover>
                <template v-slot="{ isHovering, props }">
                  <v-card
                    v-bind="props"
                    style="transition: all .2s ease-in-out;"
                    class="mx-auto"
                    title="Card title"
                    variant="tonal"
                    :color="isHovering ? 'teal-lighten-1' : 'teal-lighten-3'"
                    hover
                    link
                  >
                    <v-card-text>
                      Phasellus magna. Quisque rutrum. Nunc egestas, augue at pellentesque laoreet.
                    </v-card-text>
                  </v-card>                
                </template>
              </v-hover>
            </div>
          </v-lazy>
        </v-col>
      </v-row>
    </v-sheet>

    <v-divider class="my-10 mx-10"></v-divider>
  </MainLayout>

</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 2.5s
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0
}
</style>