<template>
  <form id="payment-form">
    <div id="card-element"></div>
    <button id="submit">
      <div id="spinner"></div>
      <span id="button-text">Processing</span>
    </button>
    <div id="card-error"></div>
  </form>
</template>

<script setup>
let stripe = null;
let elements = null;
let card = null;
let formStripe = null;
let isProcessing = ref(false);


// onMounted(() => {
//   stripe = Stripe('pk_test_51NRtV0KnRuwVl5IvfPH8T24zLnFKxdiLuZwgmFAQjaeWBgmbHyaErJjJibeaKCLvqgaa9JI0nQu4Am4iT0PiRidc00MWk8xoZz');
  
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
//   card.mount("#card-element");

  
// })

</script>

<style scoped>

</style>