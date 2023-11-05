<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { toRefs, computed, ref } from 'vue';

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
  }
});
const { brands, models } = toRefs(props)

let selectedBrand = ref(null)
let selectedModel = ref(null)

const modelsBySelectedBrand = computed(() => {
  return models.value.filter((model) => model.brand_id === selectedBrand.value)
})

</script>

<template>
  <Head title="Welcome" />
  <NavBar/>

  <MainLayout>
    <div class="max-w-[900px] mx-auto border dark:border-[#28896b] rounded-sm mt-16 h-[300px] dark:bg-[#41414124]">
      <div class="w-full md:w-1/2 p-3">
        <div class="w-full md:w-96">
          <select
            v-model="selectedBrand"
            @change="selectedModel = null"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#28896b] dark:focus:border-[#28896b]"
            name=""
            id=""
          >
            <option :value="null" disabled selected>Choose Brand</option>
            <option
              v-for="brand in brands"
              :key="brand"
              :value="brand.id"
              >{{ brand.name }}
            </option>
          </select>
        </div>
        <div class="w-full md:w-96 mt-3">
          <select
            v-model="selectedModel"
            :disabled="selectedBrand === null"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#28896b] dark:focus:border-[#28896b]"
            name=""
            id=""
          >
            <option :value="null" selected disabled>Choose Model</option>
            <option
              v-for="model in modelsBySelectedBrand"
              :key="model"
              :value="model.id"
              >{{ model.name }}
            </option>
          </select>
        </div>
      </div>
    </div>
  </MainLayout>

  <MainFooter/>
</template>