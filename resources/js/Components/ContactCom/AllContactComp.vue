<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import ImportDataModal from './ImportDataModal.vue'
import CreateContactModal from './CreateContactModal.vue'
import EditContactModal from './EditContactModal.vue'
import DeleteContactModal from './DeleteContactModal.vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import 'vue3-easy-data-table/dist/style.css'
const EasyDataTable = Vue3EasyDataTable;

import { successToast, errorToast } from "@/utils/toast";

// Modal visibility states
const importModalVisible = ref(false);
const createModalVisible = ref(false);
const editModalVisible = ref(false);
const deleteModalVisible = ref(false);

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
const deleteId=ref(null)
const search = ref('')
const searchField = ref('') // Select field to search
const loading = ref(false)


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
// Handle Import action
const handleImport = () => {
  importModalVisible.value = true;
};

// Handle Create action
const handleCreate =() => {
    createModalVisible.value = true;
};

// Handle delete action
const handleDelete = async (id) => {
  if (!id) {
    console.error("No valid id provided for deletion");
    return; // Exit if id is invalid
  }
  deleteId.value = id
  deleteModalVisible.value = true

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
// Handle Excel Export
const exportContacts = () => {
  window.location.href = 'api/contact/export'
}

// Handle Pdf Export
const exportContactsPdf = () => {
  window.location.href = 'api/contact/export-pdf';
}
onMounted(() => {
  fetchContacts()
})
</script>

<template>
  <div>
    <div  class="space-y-4">
        <Button  class="btn btn-info disabled mb-3">All Contact</Button>
        <Button @click="handleCreate"  class="btn btn-primary mb-3 mx-3">Add New Contact</Button>
        <Button @click="exportContacts" class="btn btn-success mb-3 mx-3">Export to Excel</Button>
        <Button @click="exportContactsPdf" class="btn btn-danger mb-3 mx-3">Export to PDF</Button>
        <Button @click="handleImport" class="btn btn-warning mb-3 mx-3">Import Data</Button>
        <div class="flex gap-3 mb-3">
  <!-- Select Field to Search By -->
  <select v-model="searchField" class="form-select stylish-input mb-3" style="max-width: 150px;">
    <option disabled value="">Default</option>
    <option value="email">Email</option>
    <option value="phone">phone</option>
    <option value="Gender">Gender</option>
    <option value="designation">Designation</option>
    <option value="nationality">Nationality</option>
    <option value="dob">Date of Birth</option>
  </select>

  <!-- Search Input -->
  <input
    v-model="search"
    type="text"
    placeholder="Search..."
    class="form-control stylish-input"
  />
</div>

      <!-- Easy Data Table -->
      <EasyDataTable
        buttons-pagination
        :headers="headers"
        :items="contacts"
        :search-value="search"
        :search-field="searchField"
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

<import-data-modal
  :visible="importModalVisible"
  @cancel="importModalVisible = false"
  @imported="() => { importModalVisible = false; fetchContacts(); }"
  />

 <create-contact-modal
  :visible="createModalVisible"
  @cancel="createModalVisible = false"
  @created="() => { createModalVisible = false; fetchContacts(); }"
  />

 <edit-contact-modal
  :visible="editModalVisible"
  :contact="editContact"
  @cancel="editModalVisible = false"
  @updated="() => { editModalVisible = false; fetchContacts(); }"
  />

 <delete-contact-modal
    :visible="deleteModalVisible"
    :deleteId="deleteId"
    @cancel="deleteModalVisible = false"
    @deleted="() => { deleteModalVisible = false; fetchContacts(); }"
 />

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

</style>
