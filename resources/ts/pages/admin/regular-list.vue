<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
import addofficer from "../admin/Dialog-regularlist/add-dialog.vue";
import editofficer from "../admin/Dialog-regularlist/edit-dialog.vue";
import activeofficer from "../admin/Dialog-regularlist/active-dialog.vue";
import disableofficer from "../admin/Dialog-regularlist/disable-dialog.vue";



const add_dialog = ref(false);
// const officers = ref([
//   {
//   id: 1,
//   first_name: 'John',
//   last_name: 'Doe',
//   contact: '09123456789',
//   status: 'Disable',
//   email: 'doe@gmail.com',
//   depart: 'Bureau of collection',
//   position: 'Manager',
//   },

//   {
//   id: 2,
//   first_name: 'estong',
//   last_name: 'tacbas',
//   contact: '09123456789',
//   status: 'Active',
//   email: 'estong@gmail.com',
//   depart: 'health',
//   position: 'Manager',
//   },

//   {
//   id: 3,
//   first_name: 'koykoy',
//   last_name: 'tacbas',
//   contact: '09123456789',
//   status: 'Disable',
//   email: 'koykoy@gmail.com',
//   depart: 'fire',
//   position: 'Manager',
//   },

//   {
//   id: 4,
//   first_name: 'smasher',
//   last_name: 'smasher',
//   contact: '09123456789',
//   status: 'Active',
//   email: 'smasher@gmail.com',
//   depart: 'XleanRo',
//   position: 'Manager',
//   }
// ])
const dataOfficer = ref();
const activedata = ref();
const disabledata = ref();

const editdata = ref();
const active_dialog = ref(false);
const disable_dialog = ref(false);
const editofficerform = (id: any) => {
  editdata.value = id;
  edit_dialog.value = true;
};

const activeofficerform = (id: any) => {
  activedata.value = id;
  active_dialog.value = true;
};

const disablefficerform = (id: any) => {
  disabledata.value = id;
  disable_dialog.value = true;
};



const edit_dialog = ref(false);

const getofficer = () => {
  axios
    .get("/api/auth/officer/getdata")

    .then((response) => {
      dataOfficer.value = response.data.officer;
      console.log(dataOfficer.value);
    });
};

onMounted(() => {
  getofficer();
});
const add_Officer = () => {
  add_dialog.value = true;
};
const handleRefresh = () => {
  getofficer();
};

const handleEdit = () => {
  getofficer();
};

const handleActive = () => {
  getofficer();
};

const handleDisable = () => {
  getofficer();
};

</script>

<template>
  <section>
    <VCard title="Regulatory Officer List">
      <div class="d-flex flex-wrap float-right mr-2" style="margin-top: -6%">
        <VBtn @click.prevent="add_Officer" prepend-icon="tabler-plus"
          >Add Officer</VBtn
        >
      </div>
      <VDivider></VDivider>
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email Address</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Department</th>
            <th>Position</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="officer in dataOfficer" :key="officer.id">
            <td>
              {{ officer.firstname }} {{ officer.middlename }}
              {{ officer.lastname }}
            </td>
            <td>{{ officer.users.email }}</td>
            <td>{{ officer.contact }}</td>
            <td v-if="officer.status == 'Disable'">
              <VChip color="error">{{ officer.status }}</VChip>
            </td>
            <td v-if="officer.status == 'Active'">
              <VChip color="success">{{ officer.status }}</VChip>
            </td>
            <td>{{ officer.users.departments.name }}</td>
            <td>{{ officer.position }}</td>

            <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem
                      title="View"
                      :to="
                        '/admin/Dialog-regularlist/viewProfileofficer/' +
                        officer.id
                      "
                    />
                    <VListItem
                      title="Edit"
                      @click="editofficerform(officer.id)"
                    />
                    <VListItem title="Active"  @click="activeofficerform(officer.id)"/>
                    <VListItem title="Disable" @click="disablefficerform(officer.id)"/>
                  </VList>
                </VMenu>
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>
    </VCard>

    <VDialog v-model="add_dialog" scrollable width="120vh" >
      <addofficer @close="add_dialog = false" @addOfficer="handleRefresh" />
    </VDialog>

    <VDialog v-model="edit_dialog" scrollable max-width="700">
      <editofficer
        :editdata="editdata"
        @close="edit_dialog = false"
        @editOfficer="handleEdit"
      />
    </VDialog>

    <VDialog v-model="active_dialog" scrollable max-width="400">
      <activeofficer
        :activedata="activedata"
        @close="active_dialog = false"
        @activeOfficer="handleActive"
      />
    </VDialog>

    <VDialog v-model="disable_dialog" scrollable max-width="400">
      <disableofficer
        :disabledata="disabledata"
        @close="disable_dialog = false"
        @disableOfficer="handleDisable"
      />
    </VDialog>
    
  </section>
</template>
