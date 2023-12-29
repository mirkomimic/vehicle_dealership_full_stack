<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  breadcrumbs: {
    type: Array
  }
});
</script>

<template>
  <Head title="Profile" />

  <MainLayout>
    <v-container fluid class="pa-0 ma-0 ps-lg-10">
      <v-breadcrumbs
        :items="breadcrumbs"
        divider="/"
        icon="mdi-account"
      >
        <template v-slot:item="{item}">
          <v-breadcrumbs-item :disabled="item.disabled">
            <Link :href="route(item.href)">{{ item.title }}</Link>
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </v-container>

    <div class="text-h5 w-75 mx-auto my-5 text-teal-lighten-3">Profile</div>

    <div class="mb-5">
      <UpdateProfileInformationForm
        :must-verify-email="mustVerifyEmail"
        :status="status"
      />
    </div>

    <div class="mb-5">
      <UpdatePasswordForm/>
    </div>

    <div class="mb-5">
      <DeleteUserForm/>
    </div>

  </MainLayout>
  
</template>
