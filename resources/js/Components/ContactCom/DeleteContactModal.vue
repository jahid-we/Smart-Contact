<script setup>
  import {ref, watch } from 'vue'
  import axios from 'axios'
  import { successToast, errorToast } from '@/utils/toast'

  const props = defineProps({
    visible: Boolean,
    deleteId: Number, // coming from parent
  })

  const newDeleteId = ref(null);

 const emit = defineEmits(['cancel', 'deleted']);

 watch(
    () => props.deleteId,
    (newId) => {
      if (newId) {
        newDeleteId.value = newId
      }
    },
    { immediate: true, deep: true }
  )

  const handleDelete = async () => {
    try {
      const res = await axios.post('api/contact/delete',{ id: newDeleteId.value });
      if (res.data.status === true) {
        successToast(res.data.data)
        emit('deleted') // trigger parent to refresh and close modal
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
          <h3>Do you really want to delete this contact?</h3>
          <div class="modal-body">
            <p>This action is permanent and cannot be undone. ⚠️</p>
          </div>

          <div class="modal-footer d-flex gap-2 justify-end">
            <button @click="$emit('cancel')" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i>Cancel</button>
            <button @click="handleDelete" class="btn btn-primary">Delete</button>
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
