<template>
  <div class="vuetifySelect">
    <div>
      <v-autocomplete
        label="Select Brand"
        :items="brands"
        v-model="selectedBrand"
        variant="outlined"
        :item-props="brandProps"
        clearable
        density="compact"
      >
        <template v-slot:item="{ props, item }">
          <v-list-item v-bind="props" bg-color="transparent">
            <template v-slot:prepend>
              <v-avatar>
                <v-img :src="'/storage/images/brands/'+props.props.image"></v-img>
              </v-avatar>
            </template>
          </v-list-item>
        </template>
      </v-autocomplete>
    </div>
    <div>
      <v-autocomplete
        label="Select Model"
        :items="modelsBySelectedBrand"
        v-model="selectedModel"
        :disabled="selectedBrand === null"
        variant="outlined"
        :item-props="modelProps"
        clearable
        density="compact"
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

const modelProps = (model) => {
  // let subtitle;
  // if (model.vehicles.length === 1) {
  //   subtitle = model.vehicles.length + ' vehicle'
  // } else if (model.vehicles.length > 0) {
  //   subtitle = model.vehicles.length + ' vehicles'
  // } else {
  //   subtitle = '0 vehicles'
  // }

  return {
    title: model.name,
    value: model.id,
    // subtitle: subtitle
  }
}

const brandProps = (brand) => {
  return {
    title: brand.name,
    value: brand.id,
    props: {
      image: brand.image
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