<template>
  <v-menu
    open-on-hover
    location="bottom"
    open-delay="50"
    close-delay="50"
    transition="fade-transition"
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


    <v-list density="compact" rounded="lg">
      <v-list-item
        v-for="(item, index) in items"
        :key="index"
        :value="index"
        :append-icon="item.icon"
      >
        <v-list-item-title
          @click="item.action"
          class="font-weight-bold"
          >{{ item.title }}
        </v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script setup>
import { router } from '@inertiajs/vue3';

const items = [
  {
    icon: 'mdi-account',
    title: 'Profile',
    action: () => router.get(route('profile.edit'))
  },
  {
    icon: 'mdi-car-back',
    title: 'My Vehicles',
    action: () => router.get(route('vehicles.index'))
  },
  {
    icon: 'mdi-logout',
    title: 'Logout',
    action: () => router.post(route('logout'))
  },
]
</script>

