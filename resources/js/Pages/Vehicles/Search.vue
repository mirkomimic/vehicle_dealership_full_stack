<template>
  <Head title="Search" />

  <SearchVehiclesLayout>

    <template v-slot:main>
      <v-container fluid>
        <v-sheet color="transparent" max-width="1000" class="vuetifySelect d-sm-flex mx-auto">
          <div style="width: 300px;" class="mx-auto">
            <v-text-field
              v-model="form.search"
              @keyup.enter="submit"
              clearable
              rounded="md"
              append-inner-icon="mdi-magnify"
              label="Search"
              density="compact"
              variant="outlined"
              color="teal-lighten-3"
            ></v-text-field>
          </div>
          
          <div style="width: 200px;" class="mx-auto mx-md-0">
            <SearchPageSort
              v-model:vehicles-sort="form.sort"
            />
          </div>
        </v-sheet>

        <div v-if="vehicles.data.length" class="h-screen">
          <v-row no-gutters style="max-width: 1000px;" class="mx-auto">
            <v-col
              v-for="(vehicle, index) in vehicles.data" :key="index"
              cols="12"
              sm="6"
              md="4"
              no-gutters
              class="pa-3"
            >
              <VehicleCard :vehicle="vehicle"/>
            </v-col>
          </v-row>
        </div>

        <div v-else class="h-screen">
          <v-row>
            <v-col class="text-center">
              No vehicles found!
            </v-col>
          </v-row>
        </div>

        <v-row v-if="vehicles.data.length" class="mb-5">
          <v-pagination
            v-model="form.page"
            :length="Math.ceil(vehicles.total / vehicles.per_page)"
            :total-visible="3"
            class="mx-auto"
            active-color="teal-lighten-3"
            show-first-last-page
          ></v-pagination>
        </v-row>
      </v-container>
    </template>

    <template v-slot:nav-drawer>

      <div class="px-3" style="height: 1500px;">

        <div style="height: 90px;"></div>

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
import { Head, router, useForm } from '@inertiajs/vue3';
import { computed, watch, ref } from 'vue';
import SearchPageSort from '@/Components/SelectOptions/SearchPageSort.vue';
import { onMounted } from 'vue';

const props = defineProps(['vehicles', 'filters', 'brands', 'models', 'years', 'sort'])

const processing = ref(false)

const form = useForm({
  brand: Number(props.filters.brand) || null,
  model: Number(props.filters.model) || null,
  minYear: (props.filters.minYear) || null,
  maxYear: props.filters.maxYear || null,
  page: props.vehicles.current_page,
  search: props.filters.search || null,
  sort: props.filters.sort || null,
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
      },
    });    
  }, 2000)
}

const reset = () => {
  form.reset();
  router.get(route('vehicles.search'));
}

const page = computed(() => {
  return form.page;
})

watch(page, () => {
  submit();
})

const sort = computed(() => {
  return form.sort;
})

watch(sort, () => {
  submit();
})
</script>

<style scoped>
.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>