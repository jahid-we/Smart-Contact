<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <section
        id="contact"
        class="py-5 text-white"
        style="background: linear-gradient(to right, #00c6ff, #0072ff)"
    >
        <div class="container text-center">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-headset me-2"></i>Need Help?
            </h2>
            <p class="mb-3">We're here to support you every step of the way.</p>
            <Link
                href="mailto:support@laravelpoint.com"
                class="fw-semibold text-light"
                ><i class="bi bi-envelope-at me-1"></i
                >support@laravelpoint.com</Link>
        </div>
    </section>
</template>

<style scoped></style>
