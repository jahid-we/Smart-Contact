<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const totalUsers = ref(0)
const adminCount = ref(0)
const editorCount = ref(0)
const viewerCount = ref(0)
const contactCount = ref(0)

const chartRef = ref(null)
let chartInstance = null

const fetchUserCounts = async () => {
    try {
        const [userResponse, adminResponse, editorResponse, viewerResponse, contactResponse] = await Promise.all([
            axios.get('/api/user/count-all'),
            axios.get('/api/user/count-admin'),
            axios.get('/api/user/count-editor'),
            axios.get('/api/user/count-viewer'),
            axios.get('/api/contact/count')
        ])

        totalUsers.value = userResponse.data.data
        adminCount.value = adminResponse.data.data
        editorCount.value = editorResponse.data.data
        viewerCount.value = viewerResponse.data.data
        contactCount.value = contactResponse.data.data

        renderBarChart()
    } catch (error) {
        console.error('Error fetching user counts:', error)
    }
}

const renderBarChart = () => {
    if (chartInstance) {
        chartInstance.destroy()
    }

    chartInstance = new Chart(chartRef.value, {
        type: 'bar',
        data: {
            labels: ['Admin', 'Editor', 'Viewer'],
            datasets: [{
                label: 'User',
                data: [adminCount.value, editorCount.value, viewerCount.value],
                backgroundColor: ['#198754', '#ffc107', '#dc3545'],
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                    }
                }
            }
        }
    })
}

onMounted(() => {
    fetchUserCounts()
})
</script>

<template>
  <div class="container mt-5">
    <!-- Card Section -->
    <div class="row g-4 mb-5">
      <div class="col-md-3" v-for="(card, index) in [
        { title: 'Total Users', count: totalUsers, color: 'primary' },
        { title: 'Admins', count: adminCount, color: 'success' },
        { title: 'Editors', count: editorCount, color: 'warning' },
        { title: 'Viewers', count: viewerCount, color: 'danger' },
        { title: 'Contacts', count: contactCount, color: 'info' }
      ]" :key="index">
        <div :class="`card text-white bg-${card.color} shadow`">
          <div class="card-body text-center">
            <h5 class="card-title">{{ card.title }}</h5>
            <h2 class="card-text">{{ card.count }}</h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Section -->
    <div class="card shadow mb-5">
      <div class="card-header bg-dark text-white">User Chart</div>
      <div class="card-body">
        <canvas ref="chartRef" height="60"></canvas>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
