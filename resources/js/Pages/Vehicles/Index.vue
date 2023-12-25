<template>
  <Head title="My Vehicles" />

  <MainLayout>
      <div class="text-center">
        <v-snackbar
          v-model="$page.props.flash.success"
          location="top right"
          position="fixed"
          timeout="5000"
          variant="elevated"
          color="rgba(33,250,182,0.7)"
          vertical
        >
          <div class="text-subtitle-1 pb-2 font-weight-bold">Message</div>

          <p>{{ $page.props.flash.success }}</p>

          <template v-slot:actions>
            <v-btn
              color="black"
              variant="text"
              @click="$page.props.flash.success = false"
            >
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </div>

      <div class="text-h5 text-center text-uppercase mt-5 text-teal-darken-1">My Vehicles</div>

    <v-sheet class="pa-5 mt-16 mx-auto mm-border-green" :width="900" border="sm" rounded>

      <v-row>
        <v-dialog
          v-model="dialog"
          
          class="vuetifyInput"
          width="600"
        >
          <template v-slot:activator="{ props }">
            <v-btn
              v-bind="props"
              prepend-icon="mdi-plus"
              variant="outlined"
              :color="switchColor"
              >New Vehicle
            </v-btn>
          </template>
          <v-card>

            <v-progress-linear
              :active="addVehicleProgress"
              color="teal-darken-1"
              height="7"
              indeterminate
            ></v-progress-linear>

            <v-card-title>
              <span class="text-h5 text-teal-lighten-3">Add Vehicle</span>
            </v-card-title>
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    class="pb-0"
                  >
                    <SelectOptionsVuetifyForAddVehicleForm
                      :brands="brands"
                      :models="models"
                      v-model:selected-brand="selectedBrand"
                      v-model:selected-model="addVehicleForm.model_id"
                    />
                    <span style="position: relative; top: -15px" v-if="$page.props.errors.model_id" class="text-caption text-error">{{ $page.props.errors.model_id }}</span>
                  </v-col>
                  <v-col
                    cols="6"
                    class="pr-2"
                  >
                    <v-autocomplete
                      label="Year"
                      :items="years"
                      v-model="addVehicleForm.year"
                      :error-messages="addVehicleForm.errors.year"
                      :rules="[rules.required]"
                      density="comfortable"
                      variant="outlined"
                      clearable
                    ></v-autocomplete>
                  </v-col>
                  <v-col
                    cols="6"
                    class="pl-2"
                  >
                    <v-text-field
                      type="number"
                      label="Mileage"
                      v-model="addVehicleForm.mileage"
                      :rules="[rules.validateNullableField]"
                      :error-messages="addVehicleForm.errors.mileage"
                      variant="outlined"
                      density="comfortable"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-text-field
                      type="number"
                      label="Price"
                      v-model="addVehicleForm.price"
                      :rules="[rules.required]"
                      :error-messages="addVehicleForm.errors.price"
                      variant="outlined"
                      density="comfortable"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-file-input
                      @change="setImgs"
                      label="Add Images"
                      multiple
                      :error-messages="addVehicleForm.errors.files"
                      variant="outlined"
                      accept="image/png, image/jpeg, image/jpg"
                      prepend-icon="mdi-camera"
                    ></v-file-input>
                    <span style="position: relative; top: -15px" v-if="addVehicleForm.errors.images" class="text-caption text-error">{{ addVehicleForm.errors.images }}</span>

                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-sheet class="d-flex flex-wrap justify-center">
                      <v-img
                        v-if="vehicleImgsPreview.length"
                        v-for="(item, index) in vehicleImgsPreview" :key="index"
                        :src="item"
                        width="100"
                        height="100"
                      ></v-img>
                      <v-sheet v-else border="sm" rounded class="d-flex justify-center items-center pa-2" width="200" height="100">
                        <v-icon icon="mdi-image-frame" size="50" class="mt-3" color="teal-lighten-3"></v-icon>
                      </v-sheet>
                    </v-sheet>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="teal-lighten-2"
                variant="text"
                @click="closeAddNewVehicle"
              >
                Close
              </v-btn>
              <v-btn
                color="teal-lighten-2"
                variant="text"
                @click="addNewVehicle"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-row>
    </v-sheet>

  </MainLayout>
</template>

<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import SelectOptionsVuetifyForAddVehicleForm from '@/Components/SelectOptions/SelectOptionsVuetifyForAddVehicleForm.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { useTheme } from 'vuetify/lib/framework.mjs';

const props = defineProps(['brands', 'models', 'years']);

const dialog = ref(false)
const addVehicleProgress = ref(false)

const selectedBrand = ref(null);

let vehicleImgsPreview = ref([])

const addVehicleForm = useForm({
  model_id: null,
  price: null,
  year: null,
  mileage: null,
  images: null
})

const rules = {
  required: value => !!value || 'This field is required.',
  nullable: value => value == null || true,
  validateNullableField(value) {
    if (value === null || value === '') {
      // Allow null or empty value
      return true;
    }

    // Check if the value is a number and has at most 7 digits
    const isNumber = /^\d+$/.test(value);
    const isValidLength = value.length <= 7;

    return (isNumber && isValidLength) || 'Field must be less than 6 characters';
  },
}

const setImgs = (e) => {
  addVehicleForm.images = e.target.files

  Array.from(e.target.files).forEach((img) => {
    vehicleImgsPreview.value.push(URL.createObjectURL(img))
  })

}

const addNewVehicle = () => {
  addVehicleForm.post(route('vehicles.store'), {
    // onError: () => null,
    onSuccess: () => {
      addVehicleProgress.value = true
      addVehicleForm.reset()

      setTimeout(() => {
        addVehicleProgress.value = false
        closeAddNewVehicle();
      }, 2000)
      setTimeout(() => {
        usePage().props.flash.success = null
      }, 5000)
    }
  });


}

const closeAddNewVehicle = () => {
  addVehicleForm.reset()
  dialog.value = false;
  selectedBrand.value = null;
  vehicleImgsPreview.value = [];

}

watch(dialog, (val) => {
  val || closeAddNewVehicle()
})

const theme = useTheme()

const switchColor = computed(() => {
  return theme.global.current.value.dark  ? 'teal-lighten-3' : 'teal-darken-3';
})



</script>

<style scoped>
.vuetifyInput:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
.mm-blur {
  backdrop-filter: blur(10px);
}

</style>