<template>
  <div class="vuetifySelect">
    <div>
      <v-select
        v-model="vehiclesSort"
        :items="sort"
        :item-props="sortProps"
        label="Sort"
        density="compact"
        variant="underlined"
        color="teal-lighten-3"
        prepend-inner-icon="mdi-sort"
      ></v-select>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps(['vehiclesSort'])
const emit = defineEmits(['update:vehiclesSort'])

const vehiclesSort = computed({
  get() {
    return props.vehiclesSort
  },
  set(value) {
    emit('update:vehiclesSort', value)
  }
})

const sort = [
  {
    title: 'Price Low to High',
    value: 'priceAsc',
  },
  {
    title: 'Price High to Low',
    value: 'priceDesc',
  },
  {
    title: 'Newest',
    value: 'createdDesc',
  },
  {
    title: 'Oldest',
    value: 'createdAsc',
  },
]

const sortProps = (item) => {
  return {
    title: item.title,
    value: item.value,
    props: {
      icon: item.icon
    }
  }
}
</script>

<style scoped>
.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}

</style>