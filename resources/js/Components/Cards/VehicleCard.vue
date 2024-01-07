<template>
  <v-hover v-slot="{ isHovering, props }">
    <v-card
      link
      @click="show(vehicle.id)"
      min-height="200"
      max-height="200"
      min-width="300"
      :image="`storage/images/vehicles/${vehicle.id}/${vehicle.images[0].img}`"
      v-bind="props"
      class="mx-auto"
    >
      <v-card
        class="text-left text-teal-lighten-3 mm-blur w-100"
        :class="isHovering ? 'rounded-0' : 'mm-border-radius'"
        color="rgb(35, 36, 38, 0.6)"
        style="height: 200px; position: absolute; transition: all .5s ease-in-out;"
        :style="isHovering ? {'bottom': '0px'} : {'bottom': '-120px'}"
      >
        <v-card-title>{{ vehicle.brand.name }}</v-card-title>
        <v-card-subtitle>{{ vehicle.model.name }}</v-card-subtitle>

        <v-divider class="mt-4 mx-3"/>

        <v-card-text>
          <div>
            <div>Mileage: {{ vehicle.mileage }}</div>
            <div>Year: {{ vehicle.year }}</div>
            <div>Price: {{ formatPrice(vehicle.price) }}</div>
            <div>Created: {{ new Date(vehicle.created_at).toLocaleDateString() }}</div>
          </div>
        </v-card-text>
      </v-card>
    </v-card>
  </v-hover>

</template>

<script setup>
import { router } from '@inertiajs/vue3';

const props = defineProps(['vehicle'])

const show = (id) => {
  router.get(route('vehicles.show', id))
}

const formatPrice = (price) => {
  return price.toLocaleString("de-DE", { maximumFractionDigits: 2, minimumFractionDigits: 2 })
}


</script>

<style scoped>
.mm-border-radius {
  border-top-right-radius: 50%;
}
</style>