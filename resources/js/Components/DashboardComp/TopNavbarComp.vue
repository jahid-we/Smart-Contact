<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import UserProfileComp from '../UserProfileComp/UserProfileComp.vue';
defineProps(['toggleSidebar']);

const profileModalVisible = ref(false);

const handleProfile = () => {
  profileModalVisible.value = true;
};

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
              <li><Link @click.prevent="handleProfile" class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</Link></li>
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
 <user-profile-comp
  :visible="profileModalVisible"
  @cancel="profileModalVisible = false"
  @updated="() => { profileModalVisible = false }"
  @created="() => { profileModalVisible = false}"
 />
</template>

<style scoped>

</style>
