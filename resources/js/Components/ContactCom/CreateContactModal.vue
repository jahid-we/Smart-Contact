<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
})
const emit = defineEmits(['cancel', 'created'])

const contact = ref({
  name: '',
  phone: '',
  email: '',
  address: '',
  nationality: '',
  gender: '',
  dob: '',
  designation: '',
})

const isCreating = ref(false)

const handleCreate = async () => {
  if (!contact.value.name || !contact.value.phone || !contact.value.email) {
    errorToast('Please fill in all required fields.')
    return
  }

  isCreating.value = true
  try {
    const res = await axios.post('api/contact/create', contact.value)
    if (res.data.status === true) {
      successToast(res.data.data)
      emit('created')
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    errorToast(error?.response?.data?.data || 'Failed to create contact.')
  } finally {
    isCreating.value = false
  }
}
</script>

<template>
  <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-bottom-0">
          <h5 class="modal-title fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>Add New Contact
          </h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input v-model="contact.name" type="text" placeholder="Name" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone</label>
              <input v-model="contact.phone" type="text" placeholder="Phone" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input v-model="contact.email" type="email" placeholder="Email" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Address</label>
              <input v-model="contact.address" type="text" placeholder="Address" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Nationality</label>
              <input v-model="contact.nationality" type="text" placeholder="Nationality" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Gender</label>
              <select v-model="contact.gender" class="form-select">
                <option disabled value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Date of Birth</label>
              <input v-model="contact.dob" type="date" class="form-control" />
            </div>
            <div class="col-md-6">
              <label class="form-label">Designation</label>
              <input v-model="contact.designation" type="text" placeholder="Designation" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 justify-content-end">
          <button type="button" class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button type="button" class="btn btn-primary" @click="handleCreate" :disabled="isCreating">
            <span v-if="isCreating">
              <span class="spinner-border spinner-border-sm me-1" role="status"></span>
              Creating...
            </span>
            <span v-else>
              <i class="bi bi-plus-circle me-1"></i>Add Contact
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
