<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
import sendSchedule from '../health/Dialog-RequesthealthPermit/healthsms.vue';

const approveData =ref();
const approveID =ref();
const DataList =ref();
const send_dialog =ref();
const getApproveRequest = ()=>{
  axios.get('/api/auth/approveListhealth')

.then(response=>{
  approveData.value=response.data.approverequestlist
  console.log(approveData.value)
})
}

onMounted(()=>{
  getApproveRequest();
})

const send_scheduleform = (id: any) => {
  approveID.value = id;
  DataList.value = approveData.value
  send_dialog.value = true;
};

const handleRefresh = () => {
  getApproveRequest();
};




</script>

<template>
  <section>
    <VCard title="List of Approve ">
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Contact</th>
            <th>Email Address</th>
            <th>Address</th>
            <th>Health</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <tr v-for="approveDatas in approveData" :key="approveDatas.id">
            <td>{{approveDatas.client.firstname}} {{approveDatas.client.middlename}} {{approveDatas.client.lastname}}</td>
            <td>{{approveDatas.client.contact}}</td>
            <td>{{approveDatas.client.email}}</td>
            <td>{{approveDatas.client.address}}</td>

            <td v-if="approveDatas.health_status == 'Approved'">
            <VChip color="success">Approved</VChip>
          </td>
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + approveDatas.id"/>
                    <VListItem title="Send Schedule"  @click="send_scheduleform(approveDatas.id)"/>

                  </VList>
                </VMenu>
              </VBtn>
             </td>
          </tr>

        </tbody>
      </VTable>
    </VCard>

    <VDialog v-model="send_dialog" scrollable width="120vh">
      <sendSchedule @close="send_dialog = false" :approveID="approveID" @senddata="handleRefresh" :DataList="DataList" />
    </VDialog>

  </section>
</template>

