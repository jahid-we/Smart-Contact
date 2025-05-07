<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { computed } from 'vue'

import Vue3EasyDataTable from 'vue3-easy-data-table'
import 'vue3-easy-data-table/dist/style.css'
import { successToast, errorToast } from "@/utils/toast";
import CreateUserModal from './CreateUserModal.vue'
import UpdateUserModal from './UpdateUserModal.vue'
import DeleteUserModal from './DeleteUserModal.vue'


const EasyDataTable = Vue3EasyDataTable

const loading = ref(false)
const users = ref([])
const search = ref('')
const searchField = ref('') // Select field to search
const createModalVisible = ref(false)
const updateModalVisible = ref(false)
const deleteModalVisible = ref(false)
const deleteId = ref(null)
const updateUser = ref({
  id: '',
  email: '',
  role: '',
  is_logged_in: '',
})

// Table headers
const headers = [
  { text: "Email", value: "email" },
  { text: "Role", value: "role" },
  { text: "Logged_In", value: "is_logged_in" },
  { text: "Action", value: "action" },
]

// Fetch Users from API
const fetchUsers = async () => {
  try {
    const response = await axios.get('api/user/all-user')
    users.value = response.data.data
  } catch (error) {
    console.error('Failed to fetch users:', error)
  } finally {
    loading.value = false
  }
}

// Handle Create action
const handleCreate = () => {
  createModalVisible.value = true
}

// Update Modal Open
const handleUpdate = async (id) => {
    if (!id) {
        console.error("No valid id provided for updating");
        return;
    }
    try {
        const response = await axios.get('api/user/user-by-id', {
            params: { id: id }
        });
        if (response.data.status === true && response.data.data) {
            updateUser.value = response.data.data ;
            updateModalVisible.value = true;
        } else {
            errorToast('Failed to fetch User details.');
        }
    } catch (error) {
        console.error('Fetch Single user Error:', error);
        errorToast('Something went wrong while fetching User.');
    }
}

// Handle delete action
const handleDelete = (id) => {
    deleteModalVisible.value = true
    deleteId.value = id
}

onMounted(() => {
  fetchUsers()
})
</script>

<template>
  <div class="container mx-auto">
    <div class="flex justify-between items-center mb-4">
      <button class="btn btn-info disabled mb-1">All Users</button>
      <button @click="handleCreate" class="btn btn-primary mx-3 mb-1">Create New User</button>
    </div>

    <!-- Search Controls -->

<div class="flex gap-3 mb-3">
  <!-- Select Field to Search By -->
  <select v-model="searchField" class="form-select stylish-input mb-3" style="max-width: 150px;">
    <option disabled value="">Default</option>
    <option value="email">Email</option>
    <option value="role">Role</option>
  </select>

  <!-- Search Input -->
  <input
    v-model="search"
    type="text"
    placeholder="Search..."
    class="form-control stylish-input"
  />
</div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
      <EasyDataTable
        buttons-pagination
        :headers="headers"
        :items="users"
        :search-value="search"
        :search-field="searchField"
        :rows-per-page="10"
        show-index
        table-class-name="custom-table"
      >
        <!-- Format Logged In Column -->
        <template #item-is_logged_in="{ is_logged_in }">
          <span :class="is_logged_in ? 'text-info' : 'text-danger'">
            {{ is_logged_in ? 'Logged In' : 'Not Logged In' }}
          </span>
        </template>

        <!-- Action Buttons -->
        <template #item-action="{ id }">
          <div class="d-flex align-items-center gap-2 justify-center">
            <button @click="handleUpdate(id)" class="btn btn-sm btn-outline-primary">
              <i class="bi bi-pencil"></i>
            </button>
            <button @click="handleDelete(id)" class="btn btn-sm btn-outline-danger">
              <i class="bi bi-trash"></i>
            </button>
          </div>
        </template>
      </EasyDataTable>
    </div>

    <!-- Create Modal -->
    <create-user-modal
      :visible="createModalVisible"
      @cancel="createModalVisible = false"
      @created="() => { createModalVisible = false; fetchUsers(); }"
    />

    <!-- Update Modal -->
    <update-user-modal
      :visible="updateModalVisible"
      :user="updateUser"
      @cancel="updateModalVisible = false"
      @updated="() => { updateModalVisible = false; fetchUsers(); }"
    />
    <!-- Delete Modal -->
    <delete-user-modal
      :visible="deleteModalVisible"
      :deleteId="deleteId"
      @cancel="deleteModalVisible = false"
      @deleted="() => { deleteModalVisible = false; fetchUsers(); }"
    />
  </div>
</template>

<style scoped>
.custom-table {
  width: 100%;
  overflow-x: auto;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  font-family: 'Poppins', sans-serif;
}

@media (max-width: 768px) {
  .custom-table {
    display: block;
    white-space: nowrap;
  }
}

.custom-table thead th {
  background-color: #f8f9fa;
  color: #333;
  font-weight: 600;
  font-size: 15px;
  padding: 15px;
  text-align: center;
  border-bottom: 1px solid #dee2e6;
}

.custom-table tbody td {
  font-size: 14px;
  color: #555;
  padding: 14px 10px;
  vertical-align: middle;
  text-align: center;
}

.custom-table tbody tr:hover {
  background-color: #f1f1f1;
  cursor: pointer;
}

.stylish-input {
  font-size: 16px;
  padding: 10px 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.d-flex.gap-2 > * {
  margin-right: 6px;
}

.btn-outline-primary, .btn-outline-danger {
  width: 32px;
  height: 32px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
