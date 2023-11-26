<template>
  <GuestLayout>

    <Head title="Log in" />

    <div class="h-screen d-flex justify-center ">
      <v-sheet class="d-flex flex-column justify-center my-auto pa-5" height="500" width="700" rounded>
        <div class="text-h4 text-center text-uppercase  text-teal-lighten-3 ">Login</div>

        <v-form @submit.prevent="submit" class="vuetifySelect">

          <v-container fluid>
            <v-row>
              <v-col
                class="mx-auto"
                cols="12"
                md="8"
              >
                <div class="mx-auto mb-5">
                  <v-text-field
                    v-model="form.email"
                    :rules="emailRules"
                    :error-messages="form.errors.email"
                    label="Email"
                    variant="underlined"
                    base-color="teal-lighten-3" color="teal-lighten-3"
                  />
                </div>

                <div class=" mx-auto">
                  <v-text-field
                    v-model="form.password"
                    :rules="passwordRules"
                    :error-messages="form.errors.password"
                    autocomplete
                    label="Password"
                    variant="underlined"
                    base-color="teal-lighten-3" color="teal-lighten-3"
                    :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="show ? 'text' : 'password'"
                    @click:append="show = !show"
                  />
                </div>

                <div class=" mx-auto">
                  <v-checkbox
                    v-model="form.remember"
                    label="Remember me"
                    color="teal-darken-3"
                  />
                </div>
                <div class=" mx-auto text-center text-teal-lighten-4">
                    <Link
                      v-if="canResetPassword"
                      :href="route('password.request')"
                    >
                      Forgot your password?
                    </Link>
                </div>
                <div class=" mx-auto text-center text-teal-lighten-4">
                    <Link
                      :href="route('register')"
                    >
                      Don't have an account? Register.
                    </Link>
                </div>
                <div class=" mx-auto d-flex mt-8">
                  <v-btn
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    class="mx-auto"
                    variant="tonal"
                    color="teal-lighten-3"
                  >
                    Login
                  </v-btn>
                </div>
              </v-col>
            </v-row>
          </v-container>

        </v-form>
      </v-sheet>
    </div>
  </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  // status: {
  //   type: String,
  // },
});

const show = ref(false)

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
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

<style scoped>
.vuetifySelect:deep() input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>
