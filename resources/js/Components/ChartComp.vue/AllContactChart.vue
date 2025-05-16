<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Chart, registerables } from 'chart.js'
import axios from 'axios'

Chart.register(...registerables)

const chartRef = ref(null)
const chartInstance = ref(null)
const contactCount = ref(0)
let intervalId = null

const fetchContactCount = async () => {
  try {
    const response = await axios.get('/api/contact/count')
    const count = response.data.data
    if (contactCount.value !== count) {
      contactCount.value = count
      updateChart(count)
    }
  } catch (error) {
    console.error('Error fetching contact count:', error)
  }
}

const updateChart = (count) => {
  if (chartInstance.value) chartInstance.value.destroy()

  chartInstance.value = new Chart(chartRef.value, {
    type: 'bar',
    data: {
      labels: ['Total Contacts'],
      datasets: [{
        label: 'Contacts',
        data: [count],
        fill: false,
        borderColor: 'red',
        backgroundColor: 'red',
        tension: 0.4,
        pointBackgroundColor: 'red',
        pointBorderColor: '#fff',
      }],
    },
    options: {
      responsive: true,
      animation: {
        radius: {
        duration: 400,
        easing: 'linear',
        loop: (context) => context.active
      }
      },
      plugins: {
        title: {
          display: true,
          text: 'Total Contacts Count',
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
            stepSize: 5,
          },
        },
      },
    },
  })
}

onMounted(() => {
  fetchContactCount()
  intervalId = setInterval(fetchContactCount, 4000) // fetch every 4 seconds
})

onUnmounted(() => {
  clearInterval(intervalId)
})
</script>

<template>
  <div class="card shadow mb-5 mt-5">
    <div class="card-header bg-dark text-white">Total Contact Chart</div>
    <div class="card-body">
      <canvas ref="chartRef" height="60"></canvas>
    </div>
  </div>
</template>

<style scoped>
</style>
