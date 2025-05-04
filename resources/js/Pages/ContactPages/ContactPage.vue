<script setup>
import DashboardLayoutComp from '@/Layouts/DashboardLayoutComp.vue'
import AllContactComp from '../../Components/ContactCom/AllContactComp.vue';

defineOptions({ layout: DashboardLayoutComp })
</script>

<template>
    <div>
        <all-contact-comp />
    </div>

</template>
