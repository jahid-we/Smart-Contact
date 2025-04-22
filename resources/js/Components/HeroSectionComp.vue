<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
<section
    class="text-center py-5 text-white"
    style="background: linear-gradient(to right, #00c6ff, #0072ff)"
  >
    <div class="container">
      <h1 class="display-4 fw-bold">
        <i class="bi bi-person-lines-fill me-2"></i>Smart Contact Management Software
      </h1>
      <p class="lead mb-4">
        Easily create, organize, and manage contacts like never before.
      </p>
      <Link href="/loginForm" class="btn btn-light btn-lg"><i class="bi bi-person-plus-fill me-1"></i>Get Started Now</Link>
    </div>
  </section>

</template>

<style scoped>
</style>
