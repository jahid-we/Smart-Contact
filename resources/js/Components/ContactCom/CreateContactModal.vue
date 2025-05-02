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
  nationality:'',
  gender:'',
  dob:'',
  designation:'',
})

const handleCreate = async () => {
    try {
        if (!contact.value.name || !contact.value.phone || !contact.value.email) {
        errorToast('Please fill in all required fields')
        return
      };
      const res = await axios.post('api/contact/create',contact.value)
      if (res.data.status === true) {
        successToast(res.data.data)
        emit('created') // trigger parent to refresh and close modal
      } else {
        errorToast(res.data.data)
      }
    } catch (error) {
      console.error('Delete Error:', error)
      errorToast(
        error?.response?.data?.data || 'Failed to delete contact.'
      )
    }
  }
</script>

<template>
    <div v-if="visible" class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">
        <h3>Add New Contact</h3>
        <div class="modal-body">
          <input v-model="contact.name" placeholder="Name" class="form-control mb-2" />
          <input v-model="contact.phone" placeholder="Phone" class="form-control mb-2" />
          <input v-model="contact.email" placeholder="Email" class="form-control mb-2" />
          <input v-model="contact.address" placeholder="Address" class="form-control mb-2" />
          <input v-model="contact.nationality" placeholder="Nationality" class="form-control mb-2" />
          <select v-model="contact.gender" class="form-control mb-2">
            <option disabled value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <input v-model="contact.dob" type="date" class="form-control mb-2" />
          <input v-model="contact.designation" placeholder="Designation" class="form-control mb-2" />
        </div>

        <div class="modal-footer d-flex gap-2 justify-end">
          <button @click="$emit('cancel')" class="btn btn-secondary">
            <i class="bi bi-x-circle me-1"></i>Cancel
          </button>
          <button @click="handleCreate" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add New Contact
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(3px);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.modal-wrapper {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-container {
  background: #fff;
  width: 100%;
  max-width: 450px;
  padding: 25px 30px;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  position: relative;
  animation: slide-down 0.3s ease-out;
}

@keyframes slide-down {
  from {
    transform: translateY(-20px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.modal-header h3 {
  margin: 0;
  font-size: 22px;
  font-weight: 600;
  color: #333;
  text-align: center;
}

.modal-body {
  margin-top: 20px;
}

.modal-body input {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 8px;
  font-size: 15px;
  background: #f9f9f9;
  transition: border-color 0.2s;
}

.modal-body input:focus {
  border-color: #4f46e5; /* Indigo tone */
  outline: none;
  background: #fff;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 20px;
}

.modal-footer button {
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 14px;
}

.modal-footer .btn-secondary {
  background-color: #e0e0e0;
  border: none;
  color: #333;
}

.modal-footer .btn-primary {
  background-color: #4f46e5;
  border: none;
  color: #fff;
}

.modal-footer .btn-secondary:hover {
  background-color: #d5d5d5;
}

.modal-footer .btn-primary:hover {
  background-color: #4338ca;
}
</style>
