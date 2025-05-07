<script setup>
import { reactive, ref, watch } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
  user: Object,
})

const emit = defineEmits(['cancel', 'updated'])

const localUser = reactive({
  id: '',
  role: '',
})

watch(
  () => props.user,
  (newVal) => {
    if (newVal) {
      localUser.id = newVal.id
      localUser.role = newVal.role
    }
  },
  { immediate: true }
)

const isUpdating = ref(false)

const handleUpdate = async () => {
  isUpdating.value = true
  try {
    await axios.post('/api/user/update-role', {
      id: localUser.id,
      role: localUser.role,
    })
    successToast('User role updated successfully')
    emit('updated')
  } catch (error) {
    errorToast('Failed to update role')
  } finally {
    isUpdating.value = false
  }
}
</script>

<template>
  <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content border-0 rounded-3 shadow-sm">
        <div class="modal-header bg-light border-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-shield-lock me-2 text-primary"></i>Update User Role
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">
          <input type="hidden" v-model="localUser.id" />

          <div class="mb-3">
            <label class="form-label fw-semibold">
              <i class="bi bi-person-badge me-1 text-secondary"></i>Role
            </label>
            <select v-model="localUser.role" class="form-select">
              <option disabled value="">Select Role</option>
              <option value="admin">Admin</option>
              <option value="editor">Editor</option>
              <option value="user">Viewer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button class="btn btn-light border" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button class="btn btn-primary" @click="handleUpdate" :disabled="isUpdating">
            <span v-if="isUpdating">
              <span class="spinner-border spinner-border-sm me-1"></span>Updating...
            </span>
            <span v-else>
              <i class="bi bi-arrow-repeat me-1"></i>Update Role
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
