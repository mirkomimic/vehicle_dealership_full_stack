<script setup>
import { useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const passwordRules = [
  value => {
    if (value) return true

    return 'The password field is required.'
  },
  // value => {
  //   if (value?.length <= 10) return true

  //   return 'Name must be less than 10 characters.'
  // },
];

const passwordConfirmationRule = computed(() => {
  return form.password_confirmation == form.password || "Password must match"
})
</script>

<template>
  <v-col
    cols="12"
    md="9"
    class="mx-auto"
  >
    <v-card
      title="Update Password"
      subtitle="Ensure your account is using a long, random password to stay secure."
      class="mx-auto"
    >
      <v-form @submit.prevent="updatePassword" class="vuetifySelect">
        <v-col
          cols="12"
          sm="8"
          md="6"
          class="pa-0"
        >
          <v-card-text class="py-0">
            <div class="mb-2">
              <v-text-field
                v-model="form.current_password"
                :error-messages="form.errors.current_password"
                type="password"
                label="Current Password"
                variant="solo-filled"
                base-color="teal-lighten-3" color="teal-lighten-3"
              />
            </div>
            <div class="mb-2">
              <v-text-field
                v-model="form.password"
                :rules="passwordRules"
                :error-messages="form.errors.password"
                type="password"
                label="Password"
                variant="solo-filled"
                base-color="teal-lighten-3" color="teal-lighten-3"
              />
            </div>
            <div class="mb-2">
              <v-text-field
                v-model="form.password_confirmation"
                :rules="[passwordConfirmationRule]"
                :error-messages="form.errors.password_confirmation"
                type="password"
                label="Confirm Password"
                variant="solo-filled"
                base-color="teal-lighten-3" color="teal-lighten-3"
              />
            </div>
          </v-card-text>
        </v-col>
        <v-card-actions class="ps-4">
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
