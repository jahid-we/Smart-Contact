<script setup>
import {ref} from 'vue'



import DashboardLayoutComp from '@/Layouts/DashboardLayoutComp.vue'
import AllContactComp from '../../Components/ContactCom/AllContactComp.vue';
import CreateContactModal from '../../Components/ContactCom/CreateContactModal.vue';



defineOptions({ layout: DashboardLayoutComp })
</script>

<template>
    <div>
        <all-contact-comp />
    </div>

</template>
