<template>
  <v-container fluid class="pa-0">
    <v-row>
      <v-col cols="12" style="height: 200px;">
        footer
      </v-col>
    </v-row>
    <v-row>
      <v-col
        cols="12"
        md="6"
        class="bg-teal d-flex w-100 align-center "
        style="max-height: 60px;"
      >
        <strong>Get connected with us on social networks!</strong>
        <v-spacer></v-spacer>
        <v-btn
          v-for="icon in icons"
          :key="icon"
          class="mx-4"
          :icon="icon"
          variant="plain"
          size="small"
        ></v-btn>
      </v-col>
      <v-col
        cols="12"
        md="6"
        class="bg-black d-flex justify-center"
        style="height: 60px;"
      >
        <div class="my-auto">
          {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
const icons = [
  'mdi-facebook',
  'mdi-twitter',
  'mdi-linkedin',
  'mdi-instagram',
]
</script>