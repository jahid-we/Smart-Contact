<!-- resources/js/Layouts/DashboardLayoutComp.vue -->
<script setup>
import FooterComp from '@/Components/FooterComp.vue'
import SidebarComp from '../Components/DashboardComp/SidebarComp.vue'
import TopNavbarDashboardComp from '../Components/DashboardComp/TopNavbarComp.vue'
import { ref } from 'vue'

const sidebarVisible = ref(true)
const toggleSidebar = () => {
  sidebarVisible.value = !sidebarVisible.value
}
</script>

<template>
  <div class="d-flex" style="min-height: 100vh;">
    <SidebarComp v-show="sidebarVisible" />

    <div class="flex-grow-1 d-flex flex-column">
      <TopNavbarDashboardComp :toggleSidebar="toggleSidebar" />

      <main class="flex-grow-1 p-4" style="background-color: #f8f9fa;">
        <slot />
      </main>
    </div>
  </div>
      <FooterComp />
</template>
