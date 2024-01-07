<template>
  <v-dialog scrim="transparent" class="mm-blur">
    <template v-slot:activator="{ props }">
      <v-badge 
        v-bind="props"
        :content="qtyInCart"
        text-color="grey-lighten-4"
        color="red-lighten-1"
        style="cursor: pointer;"
      >
        <v-icon icon="mdi-cart-variant" size="x-large"/>
      </v-badge>
    </template>

    <template v-slot:default="{ isActive }">
      <v-card>
        <div class="d-flex align-center ms-3">
          <v-icon color="teal-lighten-3" icon="mdi-cart"></v-icon>
          <v-card-title class="text-teal-lighten-3">
            Shopping Cart
          </v-card-title>
        </div>

        <v-table v-if="cart.length" class="text-center mt-5" hover>
          <thead>
            <th>ID</th>
            <th style="width: 150px;">Brand</th>
            <th style="width: 150px;">Model</th>
            <th style="width: 150px;">Image</th>
            <th>Year</th>
            <th>Mileage</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
          </thead>
          <tbody>
            <tr v-for="(item, index) in cart" :key="index">
              <td>{{ item.vehicle.id }}</td>
              <td class="pa-1">
                <v-img
                  :width="100"
                  :height="100"
                  cover
                  :src="`../storage/images/brands/${item.vehicle.brand.image}`"
                  class="rounded-lg mx-auto"
                />
              </td>
              <td>{{ item.vehicle.model.name }}</td>
              <td>
                <v-img
                  :width="100"
                  :height="100"
                  cover
                  :src="`../storage/images/vehicles/${item.vehicle.id}/${item.vehicle.images[0].img}`"
                  class="rounded-lg mx-auto"
                />
              </td>
              <td>{{ item.vehicle.year }}</td>
              <td>{{ item.vehicle.mileage }}</td>
              <td>{{ formatPrice(item.vehicle.price) }}</td>
              <td>{{ item.quantity }}</td>
              <td>{{ formatPrice(item.total) }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="7"></td>
              <td class="font-weight-bold">Grand Total</td>
              <td class="font-weight-bold">{{ formatPrice(grandTotal) }}</td>
            </tr>
          </tfoot>
        </v-table>

        <div v-else class="text-center">Empty Cart!</div>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn 
            @click="clearCart"
            variant="tonal"
            color="red-lighten-3"
            >Clear cart
          </v-btn>

          <Link :href="route('checkout.index')" class="mx-2">
            <v-btn
              text="Checkout"
              variant="tonal"
              color="teal-lighten-3"
            ></v-btn>
          </Link>

          <v-btn
            text="Close Dialog"
            color="teal-lighten-3"
            @click="isActive.value = false"
          ></v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const cart = computed(() => usePage().props.cart)

const qtyInCart = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + item.quantity
  }, 0);
})

const grandTotal = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + item.total
  }, 0);
})

const clearCart = () => {
  router.post(route('cart.clear'))
}

const formatPrice = (price) => {
  return price.toLocaleString("de-DE", { maximumFractionDigits: 2, minimumFractionDigits: 2 })
}

</script>