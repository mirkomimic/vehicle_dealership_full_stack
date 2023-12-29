<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps(['breadcrumbs'])
</script>

<template>
  <Head title="Dashboard" />

  <DashboardLayout>
    
    <v-container fluid class="pa-0 ma-0 ps-lg-10">
      <v-breadcrumbs
        :items="breadcrumbs"
        divider="/"
        icon="mdi-shield-account"
      >
        <template v-slot:item="{item}">
          <v-breadcrumbs-item :disabled="item.disabled">
            <Link :href="route(item.href)">{{ item.title }}</Link>
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </v-container>

    <section>
      index
    </section>
  </DashboardLayout>
</template>
