<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import { usePage} from '@inertiajs/vue3'
import ImportDataModal from './ImportDataModal.vue'
import CreateContactModal from './CreateContactModal.vue'
import EditContactModal from './EditContactModal.vue'
import DeleteAllContactModal from './DeleteAllContactModal.vue'
import DeleteContactModal from './DeleteContactModal.vue'
import Vue3EasyDataTable from 'vue3-easy-data-table'
import 'vue3-easy-data-table/dist/style.css'
const EasyDataTable = Vue3EasyDataTable;

import { successToast, errorToast } from "@/utils/toast";
import { capitalize } from "@/utils/stringFormatter";

// Modal visibility states
const importModalVisible = ref(false);
const createModalVisible = ref(false);
const editModalVisible = ref(false);
const deleteModalVisible = ref(false);
const deleteAllModalVisible = ref(false);
const userRole = computed(() => usePage().props.role)

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
const headers = computed(() => [
  { text: "Name", value: "name" },
  { text: "Phone", value: "phone" },
  { text: "Email", value: "email" },
  { text: "Address", value: "address" },
  { text: "Nationality", value: "nationality" },
  { text: "Gender", value: "gender" },
  { text: "Date of Birth", value: "dob" },
  { text: "Designation", value: "designation" },
  ...(userRole.value !== 'user' ? [{ text: "Action", value: "action" }] : [])
]);

// Fetch contacts from API
const fetchContacts = async () => {
  try {
    const response = await axios.get('api/contact/list')
   contacts.value = response.data.data.map(contact => ({
      ...contact,
      name: capitalize(contact.name),
      phone: contact.phone,
      email: contact.email,
      address: capitalize(contact.address),
      nationality: capitalize(contact.nationality),
      gender: capitalize(contact.gender),
      dob: contact.dob,
      designation: capitalize(contact.designation),
    }))
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

// Handle delete all action
const handleDeleteAll = () => {
  deleteAllModalVisible.value = true
}

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
       <Button class="btn btn-info disabled shadow mb-3">
  <i class="bi bi-people-fill me-1"></i> All Contact
</Button>

<Button @click="handleCreate" v-if="userRole !== 'user'" class="btn btn-primary shadow mb-3 mx-2">
  <i class="bi bi-person-plus-fill me-1"></i> Add New Contact
</Button>

<Button @click="exportContacts" v-if="userRole !== 'user'" class="btn btn-success shadow mb-3 mx-2">
  <i class="bi bi-file-earmark-excel-fill me-1"></i> Export to Excel
</Button>

<Button @click="exportContactsPdf" v-if="userRole !== 'user'" class="btn btn-light shadow mb-3 mx-2">
  <i class="bi bi-file-earmark-pdf-fill me-1"></i> Export to PDF
</Button>

<Button @click="handleImport" v-if="userRole !== 'user'" class="btn btn-warning shadow mb-3 mx-2">
  <i class="bi bi-upload me-1"></i> Import Data
</Button>

<Button @click="handleDeleteAll" v-if="userRole !== 'user'" class="btn btn-danger shadow mb-3 mx-2">
  <i class="bi bi-trash-fill me-1"></i> Delete All Contact
</Button>

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
        <template v-if="userRole !== 'user'" #item-action="{ id }">
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
 <delete-all-contact-modal
        :visible="deleteAllModalVisible"
        @cancel="deleteAllModalVisible = false"
        @deleted="() => { deleteAllModalVisible = false; fetchContacts(); }"
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
