<template>
  <nav class="sticky top-0 z-10 w-full shadow-sm h-[50px] bg-gray-100 dark:bg-[rgba(33,250,182,0.57)] backdrop-blur-sm opacity-80">
    <div class="container container-sm mx-auto w-full h-full flex items-center">
      <div class="text-[30px] me-auto">
        ICON
      </div>
      <div class="flex gap-4 ms-auto text-[20px]">
        <Link href="/">Login</Link>
        <Link href="/">Register</Link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';


</script>

<style scoped>
.myblur {
  background-color: rgba(255,255,255,.25);
  -webkit-backdrop-filter: blur(8px);
  backdrop-filter: blur(8px);
}
</style>