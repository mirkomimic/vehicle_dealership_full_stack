<template>
  <div class="vuetifySelect">
    <div>
      <v-autocomplete
        label="Select Brand"
        :items="brands"
        item-title="name"
        item-value="id"
        v-model="selectedBrand"
        variant="outlined"
      ></v-autocomplete>
    </div>
    <div>
      <v-autocomplete
        label="Select Model"
        :items="modelsBySelectedBrand"
        item-title="name"
        item-value="id"
        v-model="selectedModel"
        :disabled="selectedBrand === null"
        variant="outlined"
      ></v-autocomplete>
    </div>
  </div>
</template>

<script setup>
import { toRefs, computed } from 'vue';

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

// onMounted(() => {
//   selectedBrand.value = null
//   selectedModel.value = null
// }),

</script>

<style scoped>
.vuetifySelect >>> input {
  background-color: transparent !important;
  box-shadow: none;
}

</style>