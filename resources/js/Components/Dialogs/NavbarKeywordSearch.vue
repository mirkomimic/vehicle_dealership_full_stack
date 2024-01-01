<template>
  <v-dialog 
    class="mm-blur"
    scrim="transparent"
    :transition="false"
  >
    <template v-slot:activator="{ props }">
      <v-btn
        v-bind="props"
        @click="handleDialogActivated"
        variant="tonal"
        prepend-icon="mdi-magnify"
        rounded
        bg-color="grey-darken-3"
        class="w-100"
        max-width="400"
        >Search
      </v-btn>
    </template>

    <template v-slot:default="{ isActive }">
      <v-card
        class="pa-5"
        rounded="lg"
      >
        <v-text-field
          v-model="keyword"
          @input="keywordSearch"
          ref="keywordTextField"
          class="vuetifyInput mb-5"
          placeholder="Search"
          prepend-inner-icon="mdi-magnify"
          variant="solo"
          rounded
          density="compact"
          bg-color="grey-darken-3"
          flat
          hide-details
        ></v-text-field>

        <div style="height: 300px;">
          <v-row>
            <v-col v-if="brands" style="overflow: hidden; height: 300px;">
              <div class="text-uppercase text-subtitle-1 font-weight-bold ms-3">Brands</div>
              <v-list>
                  <v-list-item
                    v-for="(brand, index) in brands" :key="index"
                    :value="index"
                  >
                    <v-list-item-title @click="search(`/vehicles_search?brand=${brand.id}`)">
                      {{ brand.name }}
                    </v-list-item-title>
                  </v-list-item>
              </v-list>
            </v-col>
            <v-divider vertical></v-divider>
            <v-col v-if="models" style="overflow: hidden; height: 300px;">
              <div class="text-uppercase text-subtitle-1 font-weight-bold ms-3">Models</div>
              <v-list>
                <v-list-item
                  v-for="(model, index) in models" :key="index"
                  :value="index"
                >
                  <v-list-item-title @click="search(`/vehicles_search?brand=${model.brand.id}&model=${model.id}`)">
                    {{ model.name }}
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-col>
          </v-row>
        </div>
      </v-card>
    </template>

  </v-dialog>
  
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const keyword = ref(null);
const keywordTextField = ref(null);
const brands = ref([])
const models = ref([])

const handleDialogActivated = () => {
  setTimeout(() => {
    keywordTextField.value.focus();
  }, 500);
}

const keywordSearch = () => {

  fetch('/api/keyword_search', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    },
    body: JSON.stringify({keyword: keyword.value})
  }).then(response => {
    if (!response.ok) {
      brands.value = []
      models.value = []
      throw new Error('Network response was not ok');
    }
    return response.json();
  }).then(data => {
    if (data.message === 'The keyword field is required.') {
      brands.value = []
      models.value = []
    }
    brands.value = data.brands
    models.value = data.models
  }).catch(error => {
    console.log(error);
  })
}

const search = (url) => {
  router.get(url);
}


</script>

<style scoped>
.vuetifyInput:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>