<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  name: user.name,
  email: user.email,
});

const nameRules = [
  value => {
    if (value) return true

    return 'This field is required.'
  },
  // value => {
  //   if (value?.length <= 10) return true

  //   return 'Name must be less than 10 characters.'
  // },

];

const emailRules = [
  value => {
    if (value) return true

    return 'The email field is required.'
  },
  value => {
    if (/.+@.+\..+/.test(value)) return true

    return 'The email field must be a valid email address.'
  },
]

</script>

<template>
  <v-col
    cols="12"
    md="9"
    class="mx-auto"
  >
    <v-card
      title="Profile Information"
      subtitle="Update your account's profile information and email address."
    >
      <v-form @submit.prevent="form.patch(route('profile.update'))" class="vuetifySelect">
        <v-col
          cols="12"
          sm="8"
          md="6"
          class="pa-0"
        >
          <v-card-text class="py-0">
            <div class="mb-2">
              <v-text-field
                v-model="form.name"
                :rules="nameRules"
                :error-messages="form.errors.name"
                label="Name"
                variant="solo-filled"
                base-color="teal-lighten-3" color="teal-lighten-3"
              />
            </div>
            <div>
              <v-text-field
                v-model="form.email"
                :rules="emailRules"
                :error-messages="form.errors.email"
                label="Email"
                variant="solo-filled"
                base-color="teal-lighten-3" color="teal-lighten-3"
              />
            </div>
          </v-card-text>
        </v-col>
        <v-card-actions class="py-0 ps-4">
          <div v-if="mustVerifyEmail && user.email_verified_at === null">
            <p>Your email address is unverified.
              <Link
                :href="route('verification.send')"
                method="post"
                as="button"
              >
                Click here to re-send the verification email.
              </Link>
            </p>
            <div
              v-show="status === 'verification-link-sent'"
            >
              A new verification link has been sent to your email address.
            </div>
          </div>
          <div class="d-flex">
            <v-btn type="submit" :disabled="form.processing" variant="tonal" color="teal-lighten-3">
              Save
            </v-btn>
            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p v-if="form.recentlySuccessful" class="text-teal-lighten-3 pt-1 ps-1">Saved.</p>
            </Transition>
          </div>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-col>
</template>

<style scoped>
.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>
