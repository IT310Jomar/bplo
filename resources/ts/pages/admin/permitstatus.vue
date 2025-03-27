<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
const approveData =ref();
const getApproveRequest = ()=>{
  axios.get('/api/auth/approverequestlist')

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
    <VCard title="List of Endorsed Service">
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email Address</th>
            <th>Address</th>
            <td>Admin</td>
            <th>BFP</th>
            <th>CleanRo</th>
            <th>Health</th>
            <th>BuCu</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <tr v-for="approveDatas in approveData" :key="approveDatas.id">
            <td>{{approveDatas.client.firstname}} {{approveDatas.client.middlename}} {{approveDatas.client.lastname}}</td>
            <td>{{approveDatas.client.contact}}</td>
            <td>{{approveDatas.client.address}}</td>
            <td v-if="approveDatas.status.name == 'Approve'">
            <VChip color="success">{{ approveDatas.status.name }}</VChip>
            </td>

            
            
        
            
             <!-- <td>{{approveDatas.bfpstatus.name}}</td> -->

           
          
          

          <!-- <td v-if="approveDatas.bfp.bfp == 'Reject'">
            <VChip color="error">{{ approveDatas.bfp.bfp }}</VChip>
          </td> -->


        
          
            <td></td>
            <td></td>
            <td></td>
            <td></td>
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + approveDatas.id"/>
                    <VListItem title="Approve"/>
                    <VListItem title="Reject"/>

                    
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
