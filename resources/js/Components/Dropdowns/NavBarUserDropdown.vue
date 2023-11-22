<template>
  <v-menu
    open-on-hover
    location="bottom"
  >
    <template v-slot:activator="{ props }">
      <v-btn
        v-bind="props"
        icon
        width="40"
        height="40"
      >
        <img src="/user-placeholder.png" alt="" class="rounded-circle"/>
      </v-btn>
    </template>

    <v-list>
      <v-list-item>
        <v-btn class="w-100" prepend-icon="mdi-account" :href="route('profile.edit')" type="submit">Profile</v-btn>
      </v-list-item>
      <v-list-item>
        <v-btn class="w-100" @click="logout" prepend-icon="mdi-logout" type="submit">Logout</v-btn>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

const logout = () => {
  router.post(route('logout'));
}
</script>

