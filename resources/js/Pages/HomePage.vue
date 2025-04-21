<script setup>
import NavbarComp from "../Components/NavbarComp.vue";
</script>

<template>
  <!-- Navbar -->
  <navbar-comp />
  <!-- Hero Section -->
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
      <a href="/register" class="btn btn-light btn-lg"
        ><i class="bi bi-person-plus-fill me-1"></i>Get Started Now</a
      >
    </div>
  </section>

  <!-- Features -->
  <section
    id="features"
    class="py-5"
    style="background: linear-gradient(to right, #00c6ff, #0072ff)"
  >
    <div class="container text-center">
      <h2 class="fw-bold text-white mb-5">
        <i class="bi bi-gear-fill me-2"></i>Features You’ll Love
      </h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="border rounded p-4 h-100 shadow-sm bg-white">
            <h5 class="fw-bold">
              <i class="bi bi-ui-checks me-2"></i>User-Friendly Interface
            </h5>
            <p>Designed for simplicity and speed—manage your contacts with ease.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded p-4 h-100 shadow-sm bg-white">
            <h5 class="fw-bold">
              <i class="bi bi-person-badge me-2"></i>Role-Based Access
            </h5>
            <p>Control access and permissions for teams with powerful role management.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded p-4 h-100 shadow-sm bg-white">
            <h5 class="fw-bold"><i class="bi bi-shield-lock me-2"></i>Fast & Secure</h5>
            <p>Secure sessions, encrypted data, and high-performance operations.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- What You Can Do -->
  <section
    id="about"
    class="py-5"
    style="background: linear-gradient(to right, #00c6ff, #0072ff)"
  >
    <div class="container">
      <h2 class="fw-bold text-center text-white mb-5">
        <i class="bi bi-tools me-2"></i>What Can You Do with Smart Contact?
      </h2>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="p-4 border rounded bg-white h-100 shadow-sm">
            <h5 class="fw-bold">
              <i class="bi bi-person-lines-fill me-2"></i>Manage Your Contacts
            </h5>
            <p>
              Add, edit, search, and filter contact data in a highly intuitive system.
            </p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-4 border rounded bg-white h-100 shadow-sm">
            <h5 class="fw-bold">
              <i class="bi bi-sliders2-vertical me-2"></i>Customizable Fields
            </h5>
            <p>Create custom fields to fit your contact management needs perfectly.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-4 border rounded bg-white h-100 shadow-sm">
            <h5 class="fw-bold">
              <i class="bi bi-people-fill me-2"></i>Team & Role Management
            </h5>
            <p>Assign roles and manage team access across different modules.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-4 border rounded bg-white h-100 shadow-sm">
            <h5 class="fw-bold">
              <i class="bi bi-graph-up-arrow me-2"></i>Analytics Dashboard
            </h5>
            <p>
              Get insights into your contact usage and activities with built-in reports.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section
    id="contact"
    class="py-5 text-white"
    style="background: linear-gradient(to right, #00c6ff, #0072ff)"
  >
    <div class="container text-center">
      <h2 class="fw-bold mb-4"><i class="bi bi-headset me-2"></i>Need Help?</h2>
      <p class="mb-3">We're here to support you every step of the way.</p>
      <a href="mailto:support@laravelpoint.com" class="fw-semibold text-light"
        ><i class="bi bi-envelope-at me-1"></i>support@laravelpoint.com</a
      >
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark text-center py-4 text-white">
    <i class="bi bi-c-circle me-1"></i>2025 Smart Contact. All rights reserved.
  </footer>
</template>

<style scoped>
/* Additional styling if needed */
</style>
