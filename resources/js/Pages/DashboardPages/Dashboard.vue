<!-- resources/js/Pages/Dashboard.vue -->
<script setup>
import DashboardLayoutComp from '@/Layouts/DashboardLayoutComp.vue'
import CountUserComp from '../../Components/DashboardComp/CountUserComp.vue';
defineOptions({ layout: DashboardLayoutComp })
</script>

<template>

    <CountUserComp />


</template>
