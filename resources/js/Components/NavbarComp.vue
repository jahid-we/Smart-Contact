<script setup>
import { Link } from "@inertiajs/vue3";
import { usePage } from '@inertiajs/vue3';

const { is_logged_in } = usePage().props;
</script>

<template>
    <nav
        class="navbar py-3 navbar-expand-lg navbar-light shadow-sm sticky-top"
        style="background: linear-gradient(to right, #00c6ff, #0072ff)"
    >
        <div class="container">
            <Link class="navbar-brand fw-bold text-white" href="#">
                <i class="bi bi-journal-text me-1"></i> Smart <i>Contact</i>
            </Link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <Link class="nav-link text-white" href="#features"
                            ><i class="bi bi-stars me-1"></i>Features</Link
                        >
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link text-white" href="#about"
                            ><i class="bi bi-lightbulb me-1"></i>What You Can
                            Do</Link
                        >
                    </li>
                    <li class="nav-item">
                        <Link class="nav-link text-white" href="#contact"
                            ><i class="bi bi-envelope me-1"></i>Contact</Link
                        >
                    </li>
                     <!-- Authenticated -->
                     <li v-if="is_logged_in" class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <Link href="/dashboard" class="btn btn-light">
                            <i class="bi bi-house-door-fill me-1"></i> Dashboard
                        </Link>
                    </li>

                    <!-- Guest -->
                    <li v-else class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <Link href="/LoginForm" class="btn btn-light">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped></style>
