<script setup>
import { ref, onMounted } from 'vue'
import { Chart, registerables } from 'chart.js'
import axios from 'axios'

Chart.register(...registerables)

const chartRef = ref(null)
const chartInstance = ref(null)

const fetchUserCount = async () => {
  try {
    const response = await axios.get('/api/user/count-all')
    const count = response.data.data

    // Destroy existing chart if re-rendering
    if (chartInstance.value) chartInstance.value.destroy()

    chartInstance.value = new Chart(chartRef.value, {
      type: 'line',
      data: {
        labels: ['Total Users'],
        datasets: [{
          label: 'Users',
          data: [count],
          fill: false,
          borderColor: '#4f46e5',
          backgroundColor: '#4f46e5',
          tension: 0.4,
          pointBackgroundColor: '#4f46e5',
          pointBorderColor: '#fff',
        }],
      },
      options: {
        responsive: true,
        animation: {
          duration: 1200,
          easing: 'easeOutQuart', // Smooth and noticeable
        },
        plugins: {
          title: {
            display: true,
            text: 'Total User Count',
            font: {
              size: 18,
            },
          },
          legend: {
            display: true,
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
            },
          },
        },
      },
    })
  } catch (error) {
    console.error('Chart fetch error:', error)
  }
}

onMounted(fetchUserCount)
</script>

<template>
   <div class="card shadow mb-5">
      <div class="card-header bg-dark text-white">Total User Count Chart</div>
      <div class="card-body">
        <canvas ref="chartRef" height="100"></canvas>
      </div>
    </div>
</template>
<style scoped>
</style>
