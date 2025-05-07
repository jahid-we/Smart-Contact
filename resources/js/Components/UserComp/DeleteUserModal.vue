<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
  deleteId: Number,
})

const emit = defineEmits(['cancel', 'deleted'])

const newDeleteId = ref(null)
const isDeleting = ref(false)

watch(
  () => props.deleteId,
  (newId) => {
    if (newId) newDeleteId.value = newId
  },
  { immediate: true }
)

const handleDelete = async () => {
  if (!newDeleteId.value) return
  isDeleting.value = true
  try {
    const res = await axios.post('/api/user/delete-user', { id: newDeleteId.value })
    if (res.data.status === true) {
      successToast(res.data.data)
      emit('deleted')
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    errorToast(error?.response?.data?.data || 'Failed to delete user.')
  } finally {
    isDeleting.value = false
  }
}
</script>

<template>
  <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow rounded-3">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title text-danger fw-semibold">
            <i class="bi bi-trash me-2"></i>Confirm Deletion
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="mb-2 fs-6 text-dark">Are you sure you want to delete this user?</p>
          <p class="text-danger small"><i class="bi bi-info-circle me-1"></i>This action is permanent and cannot be undone.</p>
        </div>
        <div class="modal-footer justify-content-end border-top-0">
          <button type="button" class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-danger" @click="handleDelete" :disabled="isDeleting">
            <span v-if="isDeleting">
              <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
              Deleting...
            </span>
            <span v-else>
              <i class="bi bi-trash me-1"></i>Delete
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
