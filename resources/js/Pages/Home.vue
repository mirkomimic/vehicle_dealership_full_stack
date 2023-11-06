<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';
import SelectOptionsBrandModel from '@/Components/SelectOptionsBrandModel.vue';
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
  },
});
// const { brands, models } = toRefs(props)

let selectedBrand = ref(null)
let selectedModel = ref(null)

// const modelsBySelectedBrand = computed(() => {
//   return models.value.filter((model) => model.brand_id === selectedBrand.value)
// })
const testEmit = (e) => {
  console.log(e.value);
}
</script>

<template>
  <Head title="Welcome" />
  <NavBar/>
  <MainLayout>
    <div class="max-w-[900px] mx-auto border dark:border-[#28896b] rounded-sm mt-16 h-[300px] dark:bg-[#41414124]">
      <SelectOptionsBrandModel
        :brands="brands"
        :models="models"
        @selected-brand-emit="selectedBrand = $event;"
        @selected-model-emit="selectedModel = $event;"
      />
    </div>
  </MainLayout>

  <MainFooter/>
</template>