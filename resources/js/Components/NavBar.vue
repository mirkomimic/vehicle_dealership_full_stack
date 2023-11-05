<template>
  <nav class="sticky top-0 z-10 w-full shadow-sm h-[50px] bg-gray-100 dark:bg-[#28896b] opacity-80">
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
/* .myblur {
  -webkit-backdrop-filter: blur(8px);
  backdrop-filter: blur(8px);
} */
</style>