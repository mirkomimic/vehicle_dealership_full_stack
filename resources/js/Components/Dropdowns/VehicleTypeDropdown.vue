<template>
  <v-list class="pa-0 mb-5">
    <v-list-item
      @click="openType = !openType"
      class="pa-0 ps-3 text-grey-lighten-1"
      :ripple="false"
      density="compact"
      style="border-bottom: 1px solid gray;"
      >Type
      <template v-slot:append>
        <v-icon icon="mdi-menu-down" class="me-3"></v-icon>
      </template>
    </v-list-item>

    <v-expand-transition>
      <v-radio-group v-if="openType" v-model="selectedType" hide-details="auto">
        <v-radio label="Automobile" :value="1"></v-radio>
        <v-radio label="Motorcycle" :value="2"></v-radio>
        <v-radio label="Truck" :value="3"></v-radio>
      </v-radio-group>
    </v-expand-transition>
  </v-list>
</template>

<script setup>
import { computed, ref } from 'vue';

const openType = ref(false)

const props = defineProps(['type'])
const emit = defineEmits(['update:type'])

const selectedType = computed({
  get: () => props.type,
  set: (value) => emit('update:type', value)
})
</script>