<template>
  <Head title="Create Order"></Head>

  <div>
    <v-container>
      <div class="text-h4 text-uppercase text-amber-darken-1">Order</div>
      <v-stepper v-model="step" class="mt-5">
        <v-stepper-header>
          <v-stepper-item
            :value="1"
            :complete="step > 1"
            color="teal-darken-3"
            class="text-amber-darken-1"
            >Order details
          </v-stepper-item>
          
          <v-divider></v-divider>

          <v-stepper-item
            :value="2"
            :complete="step > 2"
            color="teal-darken-3"
            class="text-amber-darken-1"
            >Payment & Shipping
          </v-stepper-item>

          <v-divider></v-divider>

          <v-stepper-item
            :value="3"
            :complete="step > 3"
            color="teal-darken-3"
            class="text-amber-darken-1"
            >Confirm order
          </v-stepper-item>
        </v-stepper-header>

        <v-stepper-window>
          <v-stepper-window-item :value="1">
            <div style="height: 500px;">
              <v-row>
                <v-col
                  cols="6"
                  style="height: 500px; overflow-y: scroll;"
                >
                  <h6 class="text-h6 text-amber-darken-1 mb-3">Products</h6>
                  <v-card
                    v-for="(item, index) in cart" :key="index"
                    class="d-flex mb-3 pa-3"
                    :class="index % 2 ? 'flex-row-reverse' : ''"
                    color="grey-darken-3"
                  >
                    <div>
                      <v-img
                        :width="200"
                        :height="200"
                        cover
                        :src="`../storage/images/vehicles/${item.vehicle.id}/${item.vehicle.images[0].img}`"
                        class="rounded-lg me-auto"
                      />
                    </div>
                    <div class="text-h6 d-flex flex-column" :class="index % 2 ? 'me-auto text-left' : 'ms-auto text-right'">
                      <div>
                        ID: {{ item.vehicle.id }}
                      </div>
                      <div class="d-flex ga-3 ">
                        <div>{{ item.vehicle.brand.name }}</div>
                        <div>{{ item.vehicle.model.name }}</div>
                      </div>
                      <v-divider></v-divider>
                      <div>Price: {{ item.vehicle.price }}</div>
                      <div>Quantity: {{ item.quantity }}</div>
                      <v-divider></v-divider>
                      <div class="font-weight-bold mt-auto">Total: {{ item.total }}</div>
                    </div>
                  </v-card>
                </v-col>
                <v-divider vertical></v-divider>
                <v-col
                  cols="6"
                >
                  <div class="text-h5 mt-3 text-center">Grand Total: {{ grandTotal }}</div>
                </v-col>
              </v-row>
            </div>
          </v-stepper-window-item>

          <v-stepper-window-item :value="2">
            <div style="height: 500px;">
              Payment
            </div>
          </v-stepper-window-item>
          <v-stepper-window-item :value="3">
            <div style="height: 500px;">
              <div class="text-h5 text-center">Grand Total: {{ grandTotal }}</div>
              <div class="d-flex">
                <v-btn
                  @click="order"
                  variant="tonal"
                  color="teal-lighten-3"
                  class="mt-2 mx-auto"
                  >Order
                </v-btn>
              </div>
            </div>
          </v-stepper-window-item>
        </v-stepper-window>

        <v-stepper-actions>
          <template v-slot:next>
            <v-btn
              color="teal-lighten-3"
              variant="tonal"
              @click="step++"
              append-icon="mdi-arrow-right"
              >Next
            </v-btn>
          </template>
          <template v-slot:prev>
            <v-btn
              color="teal-lighten-3"
              variant="tonal"
              @click="step--"
              prepend-icon="mdi-arrow-left"
              >Back
            </v-btn>
          </template>
        </v-stepper-actions>
      </v-stepper>
    </v-container>
  </div>

  <v-overlay v-model="progress" class="d-flex justify-center align-center mm-blur" scrim="transparent">
    <v-progress-circular indeterminate class="ms-auto" :size="204" :width="10" color="teal-darken-3" bg-color="amber-darken-1"></v-progress-circular>
  </v-overlay>
</template>

<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const step = ref(1)
const progress = ref(false)

const cart = computed(() => usePage().props.cart)

const grandTotal = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + item.total
  }, 0);
})

const form = useForm({
  grandTotal: grandTotal.value
})

const order = () => {
  progress.value = true
  setTimeout(() => {
    progress.value = false
    form.post(route('orders.store'));
  }, 2000);
}


</script>