<template>
  <v-btn-toggle
    v-model="selectedType"
    rounded="2"
    color="teal-darken-3"
    group
    border
    class="d-flex justify-center"
    variant="elevated"
    density="compact"
    mandatory="force"
  >
    <v-btn :value="''" class="flex-fill">
      All
    </v-btn>
    <v-btn :value="1" class="flex-fill" prepend-icon="mdi-car">
      Automobile
    </v-btn>
    <v-btn :value="2" class="flex-fill" prepend-icon="mdi-motorbike">
      Motorcycle
    </v-btn>
    <v-btn :value="3" class="flex-fill" prepend-icon="mdi-truck">
      Truck
    </v-btn>
  </v-btn-toggle>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['type'])
const emit = defineEmits(['update:type'])

const selectedType = computed({
  get() {
    return props.type
  },
  set(value) {
    emit('update:type', value)
  }
})

</script>