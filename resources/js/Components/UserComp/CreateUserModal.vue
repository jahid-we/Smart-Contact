<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
})
const emit = defineEmits(['cancel','created'])

const isCreating = ref(false)
const user = ref({
  email: '',
  role: 'user',
})

const handleCreate = async () => {
  if (!user.value.email || !user.value.role) {
    errorToast('Email and Role are required')
    return
  }

  isCreating.value = true
  try {
    const response  =await axios.post('api/user/create-user', user.value)
    if(response.data.status === true) {
        successToast(response.data.data)
        emit('created')
        return
    }
    errorToast(response.data.data)
  } catch (error) {
    errorToast(error?.response?.data?.data|| 'Failed to create user')
  } finally {
    isCreating.value = false
  }
}
</script>

<template>
  <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-0">
          <h5 class="modal-title fw-bold">Create New User</h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input v-model="user.email" type="email" placeholder="Enter email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select v-model="user.role" class="form-select">
              <option disabled value="">Select Role</option>
              <option value="admin">Admin</option>
              <option value="editor">Editor</option>
              <option value="user">Viewer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-end">
          <button class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button class="btn btn-primary" @click="handleCreate" :disabled="isCreating">
            <span v-if="isCreating">
              <span class="spinner-border spinner-border-sm me-1"></span> Creating...
            </span>
            <span v-else>
              <i class="bi bi-plus-circle me-1"></i>Add User
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
