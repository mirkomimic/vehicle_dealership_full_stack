<template>
  <Head title="Order Complete"></Head>

  <div class="h-screen d-flex align-center">
    <v-row>
      <v-col
        cols="12"
        md="6"
        class="mx-auto"
      >
        <v-card height="500">
          <v-card-title>
            <v-icon icon="mdi-check" color="success"/>
            Order Complete!
          </v-card-title>
          <v-card-text>
            Email has been sent!
          </v-card-text>
          <v-card-actions>
            <Link href="/">
              <v-btn variant="text" color="teal-lighten-3">Back to Home</v-btn>
            </Link>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';


</script>