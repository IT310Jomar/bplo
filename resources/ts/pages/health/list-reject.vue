<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
const rejectData =ref();
const getrejectRequest = ()=>{
  axios.get('/api/auth/rejecthealths')

.then(response=>{
  rejectData.value=response.data.rejectrequestlist
  console.log(rejectData.value)
})
}

onMounted(()=>{
  getrejectRequest();
})




</script>

<template>
  <section>
    <VCard title="List of Reject List">
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



          <tr v-for="rejectDatas in rejectData" :key="rejectDatas.id">
            <td>{{rejectDatas.client.firstname}} {{rejectDatas.client.middlename}} {{rejectDatas.client.lastname}}</td>
            <td>{{rejectDatas.client.contact}}</td>
            <td>{{rejectDatas.client.email}}</td>
            <td>{{rejectDatas.client.address}}</td>

            <td v-if="rejectDatas.health_status == 'Reject'">
            <VChip color="error">Rejected</VChip>
          </td>

             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + rejectDatas.id"/>
                   

                    
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

