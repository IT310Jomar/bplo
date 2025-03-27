<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
const approveData =ref();
const getApproveRequest = ()=>{
  axios.get('/api/auth/approveListcleanro')

.then(response=>{
  approveData.value=response.data.approverequestlist
  console.log(approveData.value)
})
}

onMounted(()=>{
  getApproveRequest();
})




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
            <th>CleanRo</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <tr v-for="approveDatas in approveData" :key="approveDatas.id">
            <td>{{approveDatas.client.firstname}} {{approveDatas.client.middlename}} {{approveDatas.client.lastname}}</td>
            <td>{{approveDatas.client.contact}}</td>
            <td>{{approveDatas.client.email}}</td>
            <td>{{approveDatas.client.address}}</td>

            <td v-if="approveDatas.cleanro_status == 'Approved'">
            <VChip color="success">Approved</VChip>
          </td>
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + approveDatas.id"/>
                  </VList>
                </VMenu>
              </VBtn>
             </td>
          </tr>

        </tbody>
      </VTable>
    </VCard>
  </section>
</template>

