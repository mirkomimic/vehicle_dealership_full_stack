<template>
  <div class="w-full md:w-1/2 p-3">
    <div class="w-full md:w-96">
      <select
        v-model="selectedBrand"
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
</template>

<script setup>
import { toRefs, computed, ref } from 'vue';

const props = defineProps(['brands', 'models', 'selectedBrand', 'selectedModel'])
const emit = defineEmits(['update:selectedBrand', 'update:selectedModel'])
const { brands, models } = toRefs(props)

const modelsBySelectedBrand = computed(() => {
  return models.value.filter((model) => model.brand_id === props.selectedBrand)
})

const selectedBrand = computed({
  get() {
    return props.selectedBrand
  },
  set(value) {
    selectedModel.value = null
    emit('update:selectedBrand', value)
  }
})

const selectedModel = computed({
  get() {
    return props.selectedModel
  },
  set(value) {
    emit('update:selectedModel', value)
  }
})

</script>