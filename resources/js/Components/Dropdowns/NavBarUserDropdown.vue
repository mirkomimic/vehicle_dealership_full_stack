<template>
  <div class="pa-2">
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
          width="35"
          height="35"
        >
          <img src="/user-placeholder.png" alt="" class="rounded-circle"/>
        </v-btn>
        <v-icon v-bind="props" icon="mdi-chevron-down"></v-icon>
      </template>
      <v-list density="compact" rounded="lg" class="mt-2">
        <v-list-item
          v-for="(item, index) in items"
          :key="index"
          :value="index"
          :append-icon="item.icon"
          :subtitle="item.subtitle"
        >
          <v-list-item-title
            @click="item.action"
            class="font-weight-bold"
            >{{ item.title }}
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user

const items = [
  {
    icon: 'mdi-account',
    title: user.name,
    subtitle: user.email,
    action: () => router.get(route('profile.edit'))
  },
  // {
  //   icon: 'mdi-account',
  //   title: 'Profile',
  //   action: () => router.get(route('profile.edit'))
  // },
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

