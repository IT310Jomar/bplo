<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
import approvepermit from "./Dialog-Requestbfp/approvebfp.vue";
import rejectpermit from "./Dialog-Requestbfp/rejectbfp.vue";

const approveData =ref();
const approve_dialog = ref(false);
const reject_dialog = ref(false);
const  approvedata =ref()
const  rejectdata =ref()

const approvepermitform = (id: any) => {
  approvedata.value = id;
  approve_dialog.value = true;
};

const rejectpermitform = (id: any) => {
  rejectdata.value = id;
  reject_dialog.value = true;
};



const getApproveRequest = ()=>{
  axios.get('/api/auth/approveRequestbfp')


.then(response=>{
  approveData.value=response.data.approverequestlist
  console.log('js',approveData.value)
})
}

const hanndleRefresh=()=>{
  getApproveRequest()
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
            <th>Contact</th>
            <th>Email Address</th>
            <th>Address</th>
            <th>BuCu</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <tr v-for="approveDatas in approveData" :key="approveDatas.id">
            <td>{{approveDatas.client.firstname}} {{approveDatas.client.middlename}} {{approveDatas.client.lastname}}</td>
            <td>{{approveDatas.client.contact}}</td>
            <td>{{approveDatas.client.email}}</td>
            <td>{{approveDatas.client.address}}</td>
            
          <td v-if="approveDatas.request_status_id == '2'">
            <VChip color="warning">Pending</VChip>
          </td>

          
            
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <!-- <VListItem title="View" :to="'/admin/clientview/' + approveDatas.id"/> -->
                    <VListItem title="Approve"  @click="approvepermitform(approveDatas.id)"/>
                    <VListItem title="Reject"  @click="rejectpermitform(approveDatas.id)"/>

                    
                  </VList>
                </VMenu>
              </VBtn>
             </td>
          </tr>

        </tbody>
      </VTable>
    </VCard>

    <VDialog v-model="approve_dialog" scrollable max-width="400">
      <approvepermit
        @approvePermit = "hanndleRefresh"
        :approvedata="approvedata"
        @close="approve_dialog = false"
      
      />
    </VDialog>

    <VDialog v-model="reject_dialog" scrollable max-width="400">
      <rejectpermit
        @rejectPermitbfp = "hanndleRefresh"
        :rejectdata="rejectdata"
        @close="reject_dialog = false"
      
      />
    </VDialog>



  </section>
</template>
