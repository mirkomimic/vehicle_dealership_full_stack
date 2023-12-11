<template>
  <v-app>
    <v-app-bar 
      scroll-behavior="hide"
      scroll-threshold="50"
      elevation="2"
      density="comfortable"
    >
      <NavBar></NavBar>
    </v-app-bar>

    <v-main>
      <Transition name="fade" appear>
        <div>
          <slot/>
        </div>
      </Transition>
    </v-main>

    <v-footer style="z-index: 20;">
      <MainFooter/>
    </v-footer>

  </v-app>
</template>

<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';

</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
