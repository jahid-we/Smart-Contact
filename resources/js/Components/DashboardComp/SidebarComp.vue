<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { usePage} from '@inertiajs/vue3'

const userRole = computed(() => usePage().props.role)

</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark flex-column align-items-start p-3"
       style="background: linear-gradient(to right, #00c6ff, #0072ff); min-width: 250px;">
    <Link class="navbar-brand fs-4 mb-4" href="/">
      <i class="bi bi-person-lines-fill me-2"></i>CM
    </Link>
    <ul class="navbar-nav flex-column w-100">
      <li class="nav-item mb-2" v-if="userRole === 'admin'">
        <Link class="nav-link text-white" href="/dashboard">
          <i class="bi bi-house-door me-2"></i>Dashboard
        </Link>
      </li>
      <li class="nav-item mb-2" v-if="userRole === 'admin' || userRole === 'editor' || userRole === 'user'">
        <Link class="nav-link text-white" href="/contact">
          <i class="bi bi-person-lines-fill me-2"></i>Contacts
        </Link>
      </li>
      <li class="nav-item mb-2" v-if="userRole === 'admin'">
        <Link class="nav-link text-white" href="/userPage">
          <i class="bi bi-people me-2"></i>User
        </Link>
      </li>
      <li class="nav-item mb-2">
        <Link class="nav-link text-white" href="/settings">
          <i class="bi bi-gear me-2"></i>Settings
        </Link>
      </li>
    </ul>
  </nav>
</template>
