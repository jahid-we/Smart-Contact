<script setup>
import { ref, onMounted } from 'vue'
import { successToast, errorToast } from "@/utils/toast";
import axios from 'axios'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import 'vue3-easy-data-table/dist/style.css'
const EasyDataTable = Vue3EasyDataTable;

const editModalVisible = ref(false);
const editContact = ref({
  id:'',
  name: '',
  phone: '',
  email: '',
  address:'',
  nationality:'',
  gender:'',
  dob:'',
  designation:''
});


// Data variables
const contacts = ref([])
const loading = ref(true)
const search = ref('')

// Table headers
const headers = [
  { text: "Name", value: "name" },
  { text: "Phone", value: "phone" },
  { text: "Email", value: "email" },
  { text: "Address", value: "address" },
  { text: "Nationality", value: "nationality" },
  { text: "Gender", value: "gender" },
  { text: "Date of Birth", value: "dob" },
  { text: "Designation", value: "designation" },
  { text: "Action", value: "action" }, // Action column
]

// Fetch contacts from API
const fetchContacts = async () => {
  try {
    const response = await axios.get('api/contact/list')
    contacts.value = response.data.data
  } catch (error) {
    console.error('Failed to fetch contacts:', error)
  } finally {
    loading.value = false
  }
}

// Handle delete action
const handleDelete = async (id) => {
  if (!id) {
    console.error("No valid id provided for deletion");
    return; // Exit if id is invalid
  }

  if (!confirm('Are you sure you want to delete this contact?')) {
    return;
  }

  try {
    const res = await axios.post('api/contact/delete', { id: id });
    if (res.data.status === true) {
      successToast(res.data.data);
      fetchContacts();
    } else {
      errorToast(res.data.data);
    }
  } catch (error) {
    console.error('Delete Error:', error);
    errorToast('Failed to delete contact.');
  }
};

// Edit Modal Open
const handleEdit = async (id) => {
    if (!id) {
        console.error("No valid id provided for editing");
        return;
    }
    try {
        const response = await axios.get('api/contact/listById', {
            params: { id: id }
        });
        if (response.data.status === true && response.data.data) {
            editContact.value = response.data.data ;
            editModalVisible.value = true;
        } else {
            errorToast('Failed to fetch contact details.');
        }
    } catch (error) {
        console.error('Fetch Single Contact Error:', error);
        errorToast('Something went wrong while fetching contact.');
    }
}


// Modal Save Update (Example)
const handleUpdate = async () => {
  try {
    if (!editContact.value.name) {
      errorToast('Please enter a name');
      return;
    }
    if(!editContact.value.phone) {
      errorToast('Please enter a phone number');
      return;
    }
    if(!editContact.value.email) {
      errorToast('Please enter an email');
      return;
    }

    const res = await axios.post(`api/contact/update/${editContact.value.id}`,{
      name: editContact.value.name,
      phone: editContact.value.phone,
      email: editContact.value.email,
      address: editContact.value.address,
      nationality: editContact.value.nationality,
      gender: editContact.value.gender,
      dob: editContact.value.dob,
      designation: editContact.value.designation,
    });
    if (res.data.status === true) {
      successToast(res.data.data);
      fetchContacts();
      editModalVisible.value = false;
    } else {
      errorToast(res.data.data);
    }
  } catch (error) {
    console.error('Update Error:', error);
    if (error.response && error.response.data && error.response.data.data) {
      errorToast(error.response.data.data); // this shows "Contact email or phone already exists"
    } else {
      errorToast('Failed to update contact.');
    }
  }
};



onMounted(() => {
  fetchContacts()
})
</script>

<template>
  <div>
    <div v-if="!loading" class="space-y-4">
      <!-- Search Input -->
      <input
        v-model="search"
        type="text"
        placeholder="Search contacts..."
        class="form-control mb-3 stylish-input"
      />

      <!-- Easy Data Table -->
      <EasyDataTable
        buttons-pagination
        :headers="headers"
        :items="contacts"
        :search-value="search"
        :rows-per-page="10"
        show-index
        table-class-name="custom-table"
      >
        <!-- Slot for Action Icons -->
        <template #item-action="{ id }">
          <div class="d-flex align-items-center gap-2 justify-center">
            <button @click="handleEdit(id)" class="btn btn-sm btn-outline-primary ">
              <i class="bi bi-pencil"></i>
            </button>
            <button @click="handleDelete(id)" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-trash"></i>
            </button>
          </div>
        </template>
      </EasyDataTable>
    </div>
    <!-- Modal for Edit Contact -->
    <div v-if="editModalVisible" class="modal-mask">
     <div class="modal-wrapper">
    <div class="modal-container">

      <h3>Edit Contact</h3>

      <div class="modal-body">
        <input v-model="editContact.name" placeholder="Name" class="form-control mb-2" />
        <input v-model="editContact.phone" placeholder="Phone" class="form-control mb-2" />
        <input v-model="editContact.email" placeholder="Email" class="form-control mb-2" />
        <input v-model="editContact.address" placeholder="Address" class="form-control mb-2" />
        <input v-model="editContact.nationality" placeholder="Nationality" class="form-control mb-2" />
        <select v-model="editContact.gender" class="form-control mb-2">
            <option disabled value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
        <input v-model="editContact.dob" type="date" placeholder="Date of Birth" class="form-control mb-2" />
        <input v-model="editContact.designation" placeholder="Designation" class="form-control mb-2" />
        <!-- Add more fields as needed -->
      </div>

      <div class="modal-footer d-flex gap-2 justify-end">
        <button @click="editModalVisible = false" class="btn btn-secondary">Cancel</button>
        <button @click="handleUpdate" class="btn btn-primary">Update</button>
      </div>

    </div>
  </div>
 </div>

    <div v-else class="text-center py-8">Loading...</div>
</div>
</template>

<style scoped>
/* Make the table container beautiful */
.custom-table {
  width: 100%;
  overflow-x: auto;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  font-family: 'Poppins', sans-serif;
}

/* Responsive Table */
@media (max-width: 768px) {
  .custom-table {
    display: block;
    white-space: nowrap;
  }
}

/* Table Header Styling */
.custom-table thead th {
  background-color: #f8f9fa;
  color: #333;
  font-weight: 600;
  font-size: 15px;
  padding: 15px;
  text-align: center;
  border-bottom: 1px solid #dee2e6;
}

/* Table Row Text Styling */
.custom-table tbody td {
  font-size: 14px;
  color: #555;
  padding: 14px 10px;
  vertical-align: middle;
  text-align: center;
}

/* Row Hover Effect */
.custom-table tbody tr:hover {
  background-color: #f1f1f1;
  cursor: pointer;
}

/* Center Loading Text */
.text-center {
  text-align: center;
  font-size: 18px;
  color: #6c757d;
}

/* Stylish Input Box */
.stylish-input {
  font-size: 16px;
  padding: 10px 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  width: 100%;
}

/* Gap between action icons */
.d-flex.gap-2 > * {
  margin-right: 6px;
}

/* Small round action buttons */
.btn-outline-primary, .btn-outline-danger {
  width: 32px;
  height: 32px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
}

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
