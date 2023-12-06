<template>
  <v-app>
      <v-app-bar
        elevation="2"
        scroll-behavior="hide"
        scroll-threshold="50"
        density="comfortable"
      >
        <NavBar></NavBar>
      </v-app-bar>
      
      <v-main>
        <slot name="main"/>
      </v-main>
  
      <v-navigation-drawer
        absolute
        class="d-none d-md-block"
        color="transparent"
        width="300"
        style="z-index: 1;"
      >
        <slot name="nav-drawer"/>
      </v-navigation-drawer>

      <v-footer style="z-index: 20;">
        <MainFooter/>
      </v-footer>

  </v-app>
</template>

<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';

</script>
