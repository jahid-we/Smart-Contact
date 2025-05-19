<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
})

const emit = defineEmits(['cancel', 'imported'])

const selectedFile = ref(null)
const isUploading = ref(false)
const uploadProgress = ref(0)

const handleFileChange = (event) => {
  const file = event.target.files[0]
  selectedFile.value = file ?? null
}

const handleUpload = async () => {
  if (!selectedFile.value) {
    errorToast('Please select a file to upload.')
    return
  }

  const formData = new FormData()
  formData.append('file', selectedFile.value)

  isUploading.value = true
  uploadProgress.value = 0

  try {
    const res = await axios.post('/api/contact/import', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
      onUploadProgress: (e) => {
        if (e.lengthComputable) {
          uploadProgress.value = Math.round((e.loaded * 100) / e.total)
        }
      },
    })

    if (res.data?.status === true || res.status === 200) {
      successToast('Contacts imported successfully!')
      emit('imported')
    } else {
      errorToast(res.data?.message || 'Upload failed.')
    }
  } catch (error) {
    errorToast(error.response?.data?.message || 'Upload failed.')
  } finally {
    isUploading.value = false
    selectedFile.value = null
    uploadProgress.value = 0
  }
}
</script>

<template>
  <div
    v-if="visible"
    class="modal fade show d-block"
    tabindex="-1"
    style="background-color: rgba(0, 0, 0, 0.5);"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow rounded-3">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-upload me-2"></i>Import Contacts
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <p class="mb-2">Upload your Excel or CSV file to import contacts:</p>
          <input
            type="file"
            class="form-control"
            @change="handleFileChange"
            accept=".xlsx,.csv"
          />

          <div v-if="isUploading" class="mt-3">
            <progress
              class="form-range w-100"
              :value="uploadProgress"
              max="100"
            >
              {{ uploadProgress }}%
            </progress>
            <div class="text-center small mt-1">{{ uploadProgress }}%</div>
          </div>
        </div>

        <div class="modal-footer justify-content-end border-top-0">
          <button
            type="button"
            class="btn btn-outline-secondary"
            @click="$emit('cancel')"
            :disabled="isUploading"
          >
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click="handleUpload"
            :disabled="isUploading"
          >
            <span v-if="isUploading">
              <span
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true"
              ></span>
              Uploading...
            </span>
            <span v-else>
              <i class="bi bi-upload me-1"></i>Upload
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-content {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
