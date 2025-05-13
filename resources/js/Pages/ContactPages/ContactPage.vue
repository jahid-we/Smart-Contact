<script setup>
import DashboardLayoutComp from '@/Layouts/DashboardLayoutComp.vue'
import AllContactComp from '../../Components/ContactCom/AllContactComp.vue';
import AllContactChart from '../../Components/ChartComp.vue/AllContactChart.vue';

defineOptions({ layout: DashboardLayoutComp })
</script>

<template>
    <div>
        <all-contact-comp />
        <all-contact-chart />
    </div>

</template>
