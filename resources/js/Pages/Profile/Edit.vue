<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
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
});
</script>

<template>
  <Head title="Profile" />

  <MainLayout>
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
