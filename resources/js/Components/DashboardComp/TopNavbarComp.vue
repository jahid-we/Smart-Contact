<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { router } from "@inertiajs/vue3";
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'
defineProps(['toggleSidebar']);


// Logout function Start
const logout = async () => {
  try {
    const response = await axios.get('/api/auth/logout');
    if (response.data.status === true) {
      successToast(response.data.data);
      setTimeout(() => {
                router.visit("/LoginForm");
            }, 1000);
    } else {
      errorToast(response.data.data);
    }
  } catch (error) {
    console.error('Logout Error:', error);
    errorToast(error?.response?.data?.data || 'Failed to logout.');
  }
}
// Logout function End

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
            <Link
              class="nav-link dropdown-toggle text-white"
              href="#"
              role="button"
              data-bs-toggle="dropdown"
            >
              <i class="bi bi-person-circle me-1"></i>Admin
            </Link>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><Link  class="dropdown-item" href="/userProfile"><i class="bi bi-person me-2"></i>Profile</Link></li>
              <li><hr class="dropdown-divider" /></li>
              <li>

                  <button class="dropdown-item" @click="logout">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
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
