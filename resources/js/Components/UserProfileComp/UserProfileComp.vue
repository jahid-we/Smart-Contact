<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import { successToast, errorToast } from '@/utils/toast'

const props = defineProps({
  visible: Boolean
})
const profileData = ref({
  name: '',
  phone: '',
  email: '',
  address: '',
  img_url: ''
})

const showEmailField = ref(false)
const profileFile = ref(null)
const loading = ref(false)

const handleFileChange = (e) => {
  const file = e.target.files[0]
  if (file) {
    profileFile.value = file
  }
}

// Fetch profile on mount
const fetchProfileData = async () => {
  try {
    const res = await axios.get('api/profile/get')
    if (res.data.status === true) {
      showEmailField.value = true
      profileData.value = res.data.data
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    console.error('Fetch Error:', error)
    errorToast('Unable to load profile.')
  }
}

const createProfile = async () => {
  if (loading.value) return
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('name', profileData.value.name)
    formData.append('phone', profileData.value.phone)
    formData.append('address', profileData.value.address)
    if (profileFile.value) {
      formData.append('img', profileFile.value)
    }

    const res = await axios.post('api/profile/create', formData)
    if (res.data.status === true) {
      successToast(res.data.data)
      fetchProfileData()
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    console.error('Create Error:', error)
    errorToast(error?.response?.data?.data)
  } finally {
    loading.value = false
  }
}

const updateProfile = async () => {
  if (loading.value) return
  loading.value = true

  try {
    const formData = new FormData()
    formData.append('name', profileData.value.name)
    formData.append('phone', profileData.value.phone)
    formData.append('address', profileData.value.address)
    formData.append('email', profileData.value.email)
    if (profileFile.value) {
      formData.append('img', profileFile.value)
    }

    const res = await axios.post('api/profile/update', formData)
    if (res.data.status === true) {
      successToast(res.data.data)
      if (res.data.reload === true) {
        setTimeout(() => router.visit('/LoginForm'), 1000)
      } else {
        fetchProfileData()
      }
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    console.error('Update Error:', error)
    errorToast(error?.response?.data?.data || 'Failed to update profile.')
  } finally {
    loading.value = false
  }
}

const removeProfile = async () => {
  if (loading.value) return
  loading.value = true

  try {
    const res = await axios.get('api/profile/delete')
    if (res.data.status === true) {
      successToast(res.data.data)
      window.location.reload()
    } else {
      errorToast(res.data.data)
    }
  } catch (error) {
    console.error('Remove Error:', error)
    errorToast(error?.response?.data?.data || 'Failed to remove profile.')
  } finally {
    emit('cancel')
    loading.value = false
  }
}

onMounted(fetchProfileData)
</script>

<template>
   <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">

        <!-- Profile Image -->
        <div class="text-center mb-4">
          <img
            :src="profileData.img_url"
            alt="Profile"
            class="rounded-circle img-thumbnail border"
            style="width: 100px; height: 100px; object-fit: cover;"
          />
        </div>

        <!-- Profile Form -->
        <div class="mb-3">
          <input type="text" v-model="profileData.name" placeholder="Name" class="form-control" />
        </div>
        <div class="mb-3">
          <input type="text" v-model="profileData.phone" placeholder="Phone" class="form-control" />
        </div>
        <div class="mb-3" v-if="showEmailField">
          <input type="email" v-model="profileData.email" placeholder="Email" class="form-control" />
        </div>
        <div class="mb-3">
          <textarea v-model="profileData.address" placeholder="Address" class="form-control"></textarea>
        </div>
        <div class="mb-4">
          <label for="img" class="form-label">Profile Image</label>
          <input type="file" @change="handleFileChange" id="img" class="form-control" />
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-2">
          <button
            v-if="!showEmailField"
            @click="createProfile"
            class="btn btn-outline-success"
            :disabled="loading"
          >
            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
            Create Profile
          </button>
          <button
            v-if="showEmailField"
            @click="updateProfile"
            class="btn btn-outline-primary"
            :disabled="loading"
          >
            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
            Update Profile
          </button>
          <button
            v-if="showEmailField"
            @click="removeProfile"
            class="btn btn-outline-danger"
            :disabled="loading"
          >
            <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
            Remove Profile
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
