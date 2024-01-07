<template>
  <Head title="Create Order"></Head>

  <div class="pa-5">
    <div>
      <div class="d-flex justify-space-between mb-5">
        <div class="text-h4 text-uppercase text-amber-darken-1">
          Order #{{ order.id }}
        </div>
        <div>
          <v-btn
            @click="router.get(route('checkout.destroy'))"
            variant="outlined"
            color="red-lighten-3"
            >Cancel Order
          </v-btn>
        </div>
      </div>

      <v-card
        class="pa-3 w-50 mx-auto"
      >
        <form id="payment-form">
          <div id="card-element"></div>
          <button id="submit" class="mt-3">
            <!-- <div v-if="isProcessing" id="button-text">Processing...</div> -->
            <v-btn
              id="button-text"
              variant="tonal"
              color="teal-lighten-3"
              :loading="isProcessing"
              :disabled="isProcessing"
              >Place your order in USD
            </v-btn>
          </button>
          <p id="card-error"></p>
        </form>
      </v-card>

    </div>
  </div>

</template>

<script setup>
import { Head, router, useForm, usePage} from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const props = defineProps(['order', 'intent']);

// let stripe = null;
// const stripe = Stripe("pk_test_51NRtV0KnRuwVl5IvfPH8T24zLnFKxdiLuZwgmFAQjaeWBgmbHyaErJjJibeaKCLvqgaa9JI0nQu4Am4iT0PiRidc00MWk8xoZz");

let stripe = null;
let elements = null;
let card = null;
let isProcessing = ref(false);
const form = useForm({
  payment_intent: null,
})


onMounted(() => {
  stripe = Stripe(usePage().props.stripe_key);
  
  elements = stripe.elements();
  // const paymentElement = elements.create('payment', options);
  // paymentElement.mount('#payment-element');

  let style = {
    base: {
      color: "#32325d",
      fontFamily: 'Arial, sans-serif',
      fontSmoothing: "antialiased",
      fontSize: "16px",
      "::placeholder": {
        color: "#32325d"
      }
    },
    invalid: {
      fontFamily: 'Arial, sans-serif',
      color: "#fa755a",
      iconColor: "#fa755a"
    }
  };

  card = elements.create("card", { style: style });
  card.mount("#card-element");

  card.on("change", function (event) {
    // Disable the Pay button if there are no card details in the Element
    document.querySelector("button").disabled = event.empty;
    document.querySelector("#card-error").textContent = event.error ? event.error.message : "";
  });

  var form = document.getElementById("payment-form");
  form.addEventListener("submit", function(event) {
    event.preventDefault();
    // Complete payment when the submit button is clicked
    payWithCard(stripe, card, props.intent.client_secret);
  });

  // setTimeout(() => {
  //   router.post(route('orders.index'), {
  //     total: totalWithoutDot(),
  //     total_decimal: total,
  //     items: cart.value,
  //   })
  // }, 10)

})

const payWithCard = (stripe, card, clientSecret) => {
  loading(true);
  stripe
    .confirmCardPayment(clientSecret, {
      payment_method: {
        card: card
      }
    })
    .then(function (result) {
      if (result.error) {
        // Show error to your customer
        showError(result.error.message);
      } else {
        // The payment succeeded!
        orderComplete(result.paymentIntent.id);
      }
    });
}

// Shows a success message when the payment is complete
const orderComplete = (paymentIntentId) => {
  form.payment_intent = paymentIntentId
  form.put(route('orders.update', props.order.id))
};

// Show the customer the error from Stripe if their card fails to charge
let showError = (errorMsgText) => {
  loading(false);
  var errorMsg = document.querySelector("#card-error");
  errorMsg.textContent = errorMsgText;
  setTimeout(function() {
    errorMsg.textContent = "";
  }, 4000);
};

// Show a spinner on payment submission
let loading = (isLoading) => {
  if (isLoading) {
    // Disable the button and show a spinner
    document.querySelector("button").disabled = true;
    isProcessing.value = true;
  } else {
    document.querySelector("button").disabled = false;
    isProcessing.value = false;
  }
};



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

.submit-btn {
  border: 1px solid white;
}

</style>