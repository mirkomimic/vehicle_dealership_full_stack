<template>
  <Head title="Create Order"></Head>

  <div>
    <v-container>
      <div class="d-flex justify-space-between">
        <div class="text-h4 text-uppercase text-amber-darken-1">Order</div>
        <div>
          <v-btn
            @click="router.get(route('checkout.destroy'))"
            variant="outlined"
            color="red-lighten-3"
            >Cancel Order
          </v-btn>
        </div>
      </div>

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
            >Payment
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
                      <div>Price: {{ formatPrice(item.vehicle.price) }}</div>
                      <div>Quantity: {{ item.quantity }}</div>
                      <v-divider></v-divider>
                      <div class="font-weight-bold mt-auto">Total: {{ formatPrice(item.total) }}</div>
                    </div>
                  </v-card>
                </v-col>
                <v-divider vertical></v-divider>
                <v-col
                  cols="6"
                >
                  <div class="text-h5 mt-3 text-center">Grand Total: {{ formatPrice(grandTotal) }}</div>
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
              <div class="text-h5 text-center">Grand Total: {{ formatPrice(grandTotal) }}</div>
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

  <!-- <v-overlay v-model="progress" class="d-flex justify-center align-center mm-blur" scrim="transparent">
    <v-progress-circular indeterminate class="ms-auto" :size="204" :width="10" color="teal-darken-3" bg-color="amber-darken-1"></v-progress-circular>
  </v-overlay> -->
</template>

<script setup>
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';

const step = ref(1)
const progress = ref(false)

const cart = computed(() => usePage().props.cart)

const grandTotal = computed(() => {
  return cart.value.reduce((accumulator, item) => {
    return accumulator + item.total
  }, 0);
})

const form = useForm({
  grandTotal: grandTotal.value * 100,
  grandTotalDecimal: parseFloat(grandTotal.value).toFixed(2),
})

const formatPrice = (price) => {
  return price.toLocaleString("de-DE", { maximumFractionDigits: 2, minimumFractionDigits: 2 })
}


const order = () => {
  progress.value = true
  setTimeout(() => {
    progress.value = false
    form.post(route('orders.store'));
  }, 2000);
}
// ------------------------------------------------------------

// let stripe = null;
// let elements = null;
// let card = null;
// let formStripe = null;
// let isProcessing = ref(false);


// onMounted(() => {
// stripe = Stripe('pk_test_51NRtV0KnRuwVl5IvfPH8T24zLnFKxdiLuZwgmFAQjaeWBgmbHyaErJjJibeaKCLvqgaa9JI0nQu4Am4iT0PiRidc00MWk8xoZz');
  
//   elements = stripe.elements();
//   // const paymentElement = elements.create('payment', options);
//   // paymentElement.mount('#payment-element');

//   let style = {
//     base: {
//       color: "#32325d",
//       fontFamily: 'Arial, sans-serif',
//       fontSmoothing: "antialiased",
//       fontSize: "16px",
//       "::placeholder": {
//         color: "#32325d"
//       }
//     },
//     invalid: {
//       fontFamily: 'Arial, sans-serif',
//       color: "#fa755a",
//       iconColor: "#fa755a"
//     }
//   };

//   card = elements.create("card", { style: style });
//   console.log(document.getElementById('card-element'));
//   card.mount("#card-element");

  
// })




</script>

<style scoped>
#card-element {
  border-radius: 4px 4px 0 0 ;
  padding: 12px;
  border: 1px solid rgba(50, 50, 93, 0.1);
  height: 44px;
  width: 100%;
  background: white;
}

#payment-request-button {
  margin-bottom: 32px;
}

</style>