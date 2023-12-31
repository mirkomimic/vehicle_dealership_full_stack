<template>
  <Head title="Search" />

  <SearchVehiclesLayout>

    <template v-slot:main>

      <!-- <KeywordSearchDialog/> -->

      <v-container fluid class="pa-0 ma-0 ps-lg-10">
        <v-breadcrumbs
          :items="breadcrumbs"
          divider="/"
          icon="mdi-home"
        >
          <template v-slot:item="{item}">
            <v-breadcrumbs-item :disabled="item.disabled">
              <Link :href="route(item.href)">{{ item.title }}</Link>
            </v-breadcrumbs-item>
          </template>
        </v-breadcrumbs>
      </v-container>

      <v-container>
        <div class="vuetifySelect mx-auto d-flex flex-column align-center flex-sm-row justify-sm-space-between ">

          <div>
            <v-btn
              @click="$page.props.leftDrawer = true"
              prepend-icon="mdi-menu"
              class="mb-3 mb-sm-0 d-lg-none"
              >Filters
            </v-btn>
          </div>

          <div style="min-width: 200px;">
            <SearchPageSort
              v-model:vehicles-sort="form.sort"
            />
          </div>
        </div>

      </v-container>

      <v-container fluid>

        <div v-if="vehicles.data.length" class="min-h-screen">
          <v-row no-gutters style="max-width: 1000px;" class="mx-auto">
            <v-col
              v-for="(vehicle, index) in vehicles.data" :key="index"
              cols="12"
              sm="6"
              md="4"
              no-gutters
              class="pa-3"
            >
              <v-skeleton-loader
                :loading="loading"
                type="card"
                color="transparent"
              >
                <VehicleCard :vehicle="vehicle"/>
              </v-skeleton-loader>
            </v-col>
          </v-row>
        </div>

        <div v-else class="h-screen text-center">
          No vehicles found!
        </div>

        <div v-if="vehicles.data.length" class="mb-5">
          <v-pagination
            v-model="form.page"
            :length="Math.ceil(vehicles.total / vehicles.per_page)"
            :total-visible="3"
            class="mx-auto"
            active-color="teal-lighten-3"
            show-first-last-page
          ></v-pagination>
        </div>
      </v-container>
    </template>

    <template v-slot:nav-drawer>

      <div class="px-3" style="height: 1500px;">

        <div class="d-flex mt-2 mb-10">
          <v-btn
            @click="$page.props.leftDrawer = false"
            icon="mdi-close"
            class="ms-auto d-lg-none"
            flat
          />
        </div>

        <div>
          <VehicleTypeDropdown v-model:type="form.type"/>
        </div>

        <div>
          <SelectOptionsVuetifyForAddVehicleForm
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
            thumb-label="always"
          ></v-range-slider>
        </div>

        <v-sheet
          class="text-center mt-5 mb-3 rounded-lg pa-2"
          style="position: sticky; top: 20px; z-index: 1;"
          color="gray-darken-4"
        >
          <v-btn
            @click="submit"
            :loading="processing"
            :disabled="processing"
            color="teal-darken-3"
            prepend-icon="mdi-magnify"
            >Apply Filter
          </v-btn>
          <v-btn @click="reset" variant="plain" class="px-0">
            <span class="text-decoration-underline">Clear search</span>
          </v-btn>
        </v-sheet>

      </div>
    </template>
    
  </SearchVehiclesLayout>

</template>

<script setup>
import VehicleCard from '@/Components/Cards/VehicleCard.vue';
import SelectMinMaxYear from '@/Components/SelectOptions/SelectMinMaxYear.vue';
import SelectOptionsVuetifyForAddVehicleForm from '@/Components/SelectOptions/SelectOptionsVuetifyForAddVehicleForm.vue';
import SearchVehiclesLayout from '@/Layouts/SearchVehiclesLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch, ref, onMounted } from 'vue';
import SearchPageSort from '@/Components/SelectOptions/SearchPageSort.vue';
import VehicleTypeDropdown from '@/Components/Dropdowns/VehicleTypeDropdown.vue';
import { useDisplay } from 'vuetify/lib/framework.mjs';

const props = defineProps(['vehicles', 'filters', 'brands', 'models', 'years', 'sort', 'breadcrumbs'])

const processing = ref(false)
const loading = ref(true)

const display = ref(useDisplay())

const form = useForm({
  brand: Number(props.filters.brand) || null,
  model: Number(props.filters.model) || null,
  minYear: (props.filters.minYear) || null,
  maxYear: props.filters.maxYear || null,
  mileageRange: props.filters.mileageRange || [0, 500000],
  // search: props.filters.search || null,
  sort: props.filters.sort || null,
  type: Number(props.filters.type) || null,
  page: props.vehicles.current_page,
})

const submit = () => {
  processing.value = true

  setTimeout(() => {
    processing.value = false

    form.get(route('vehicles.search'), {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        window.scrollTo({ top: 0, behavior: 'smooth' })
        loading.value = false
        if (display.value.mdAndDown) {
          usePage().props.leftDrawer = false
        }
      },
    });    
  }, 2000)

  setTimeout(() => {
    loading.value = true
  }, 1500);
}

onMounted(() => {
  if (display.value.mdAndDown) {
    usePage().props.leftDrawer = false
  }
})

const reset = () => {
  form.reset();
  if (display.value.mdAndDown) {
    usePage().props.leftDrawer = false
  }
  router.get(route('vehicles.search'));
}

watch(computed(() => form.page), () => {
  submit()
});

watch(computed(() => form.sort), () => {
  submit()
});

onMounted(() => {
  setTimeout(() => {
    loading.value = false
  }, 1000);
})
</script>

<style scoped>
.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>