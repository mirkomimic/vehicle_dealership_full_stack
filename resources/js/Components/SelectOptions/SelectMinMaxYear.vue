<template>
  <div class="vuetifySelect tw-flex tw-gap-3">
    <div class="tw-w-1/2">
      <v-autocomplete
        label="Min Year"
        :items="years"
        v-model="selectedMinYear"
        density="comfortable"
        variant="outlined"
        clearable
      ></v-autocomplete>
    </div>
    <div class="tw-w-1/2">
      <v-autocomplete
        label="Max Year"
        :items="years"
        density="comfortable"
        variant="outlined"
        v-model="selectedMaxYear"
        clearable
      ></v-autocomplete>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['years', 'selectedMinYear', 'selectedMaxYear'])
const emit = defineEmits(['update:selectedMinYear', 'update:selectedMaxYear'])

const selectedMinYear = computed({
  get() {
    return props.selectedMinYear
  },
  set(value) {
    if (value && value > props.selectedMaxYear) {
      emit('update:selectedMinYear', value)
      emit('update:selectedMaxYear', null)
    } else {
      emit('update:selectedMinYear', value)
    }
  }
})

const selectedMaxYear = computed({
  get() {
    return props.selectedMaxYear
  },
  set(value) {
    if (value && value < props.selectedMinYear) {
      emit('update:selectedMaxYear', value)
      emit('update:selectedMinYear', null)
    }
    emit('update:selectedMaxYear', value)
  }
})

</script>

<style scoped>

.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>