<script setup>
import { reactive, ref, watch } from 'vue'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean,
  contact: Object,
})

const emit = defineEmits(['cancel', 'updated'])

const localContact = reactive({
  id: '',
  name: '',
  phone: '',
  email: '',
  address: '',
  nationality: '',
  gender: '',
  dob: '',
  designation: '',
})

const isUpdating = ref(false)

watch(
  () => props.contact,
  (newContact) => {
    if (newContact) Object.assign(localContact, newContact)
  },
  { immediate: true, deep: true }
)

const handleUpdate = async () => {
  if (!localContact.name || !localContact.phone || !localContact.email) {
    errorToast('Please fill in all required fields')
    return
  }

  isUpdating.value = true
  try {
    const res = await axios.post(`api/contact/update/${localContact.id}`, localContact)
    if (res.data.status === true) {
      successToast(res.data.data)
      emit('updated')
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    errorToast(error?.response?.data?.data || 'Failed to update contact.')
  } finally {
    isUpdating.value = false
  }
}
</script>
<template>
    <div v-if="visible" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 rounded-3 shadow">
        <div class="modal-header bg-light border-0">
          <h5 class="modal-title fw-bold">Edit Contact</h5>
          <button type="button" class="btn-close" @click="$emit('cancel')"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <input v-model="localContact.name" placeholder="Name" class="form-control" />
            </div>
            <div class="col-md-6">
              <input v-model="localContact.phone" placeholder="Phone" class="form-control" />
            </div>
            <div class="col-md-6">
              <input v-model="localContact.email" placeholder="Email" class="form-control" />
            </div>
            <div class="col-md-6">
              <input v-model="localContact.address" placeholder="Address" class="form-control" />
            </div>
            <div class="col-md-6">
              <input v-model="localContact.nationality" placeholder="Nationality" class="form-control" />
            </div>
            <div class="col-md-6">
              <select v-model="localContact.gender" class="form-select">
                <option disabled value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <input v-model="localContact.dob" type="date" class="form-control" />
            </div>
            <div class="col-md-6">
              <input v-model="localContact.designation" placeholder="Designation" class="form-control" />
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 justify-content-end">
          <button class="btn btn-outline-secondary" @click="$emit('cancel')">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button class="btn btn-primary" @click="handleUpdate" :disabled="isUpdating">
            <span v-if="isUpdating">
              <span class="spinner-border spinner-border-sm me-1"></span>
              Updating...
            </span>
            <span v-else>
              <i class="bi bi-pencil-square me-1"></i>Update Contact
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
  </template>



<style scoped>
</style>
