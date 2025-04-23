<script setup>
defineProps(['toggleSidebar']);
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light" style="background: linear-gradient(to right, #00c6ff, #0072ff);">
    <div class="container-fluid">
      <button class="btn btn-outline-light me-2" @click="toggleSidebar">
        <i class="bi bi-list"></i>
      </button>
      <span class="navbar-brand text-white">Dashboard</span>
      <div class="ms-auto">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle text-white"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
            >
              <i class="bi bi-person-circle me-1"></i>Admin
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <form method="POST" action="/logout">
                  <button class="dropdown-item" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<style scoped>

</style>
