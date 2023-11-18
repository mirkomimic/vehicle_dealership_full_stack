<template>
  <nav class="tw-sticky tw-top-0 tw-z-10 tw-w-full tw-shadow-sm tw-h-full tw-bg-gray-100 dark:tw-bg-[rgba(33,250,182,0.57)] tw-backdrop-blur-sm tw-opacity-80 tw-text-black">
    <div class="tw-container tw-container-sm tw-mx-auto tw-w-full tw-h-full tw-flex tw-items-center">
      <div class="tw-text-[30px] tw-me-auto">
        <Link href="/">
          <img width="100" class="tw-rounded-lg" src="/car-logo2.jpeg" alt="">
        </Link>
      </div>
      <div class="tw-flex tw-gap-4 tw-ms-auto tw-text-[20px]">
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