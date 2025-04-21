<script setup>
import { Link } from "@inertiajs/vue3";
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
              ><i class="bi bi-lightbulb me-1"></i>What You Can Do</Link
            >
          </li>
          <li class="nav-item">
            <Link class="nav-link text-white" href="#contact"
              ><i class="bi bi-envelope me-1"></i>Contact</Link
            >
          </li>
          <li class="nav-item">
            <Link class="btn btn-light" href="/login"
              ><i class="bi bi-box-arrow-in-right me-1"></i>Login</Link
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style scoped></style>
