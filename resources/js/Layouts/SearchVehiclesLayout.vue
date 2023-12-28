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
      <Transition name="fade" appear>
        <div>
          <slot name="main"/>
        </div>
      </Transition>
    </v-main>

    <v-navigation-drawer
      v-model="$page.props.leftDrawer"
      mobile-breakpoint="lg"
      absolute
      :style="{width: width}"
    >
      <slot name="nav-drawer"/>
    </v-navigation-drawer>

    <v-footer style="z-index: 1007;">
      <MainFooter/>
    </v-footer>
  </v-app>
</template>

<script setup>
import MainFooter from '@/Components/MainFooter.vue';
import NavBar from '@/Components/NavBar.vue';
import { computed, ref } from 'vue';
import { useDisplay } from 'vuetify/lib/framework.mjs';

const display = ref(useDisplay()) 

const width = computed(() => {
  return display.value.smAndDown ? '100%' : '300px'
})

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

.mm-w-full {
  width: 300px;
}
</style>