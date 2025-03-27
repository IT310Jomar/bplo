<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
import generate_permit from "./Dialog-GeneratePermit/generate_permit.vue";

const generatePermitData = ref();
const generated_permit_dialog = ref(false);
const generated_permit = ref();



const generatepermitform = (id: any) => {
  generated_permit.value = id;
  generated_permit_dialog.value = true;
  console.log(generated_permit.value,'generated_permit')
};


const getApproveRequest = () => {
  axios
    .get("/api/auth/generateapproveList")

    .then((response) => {
      generatePermitData.value = response.data.approverequestlist;
      // console.log(generatePermitData.value);
    });
};

onMounted(() => {
  getApproveRequest();
});

const hanndleRefresh=()=>{
  getApproveRequest()
}
</script>

<template>
  <section>
    <VCard title="Generate Permit">
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Contact</th>
            <th>Email Address</th>
            <th>Address</th>
            <th>BuCu</th>
            <th>Health</th>
            <th>CleanRo</th>
            <th>BFP</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="approveDatas in generatePermitData" :key="approveDatas.id">
            <td>
              {{ approveDatas.client.firstname }}
              {{ approveDatas.client.middlename }}
              {{ approveDatas.client.lastname }}
            </td>
            <td>{{ approveDatas.client.contact }}</td>
            <td>{{ approveDatas.client.email }}</td>
            <td>{{ approveDatas.client.address }}</td>

            

            <td v-if="approveDatas.buco_status == 'Approved'">
              <VChip color="success">Approved</VChip>
            </td>

            <td v-if="approveDatas.health_status == 'Approved'">
              <VChip color="success">Approved</VChip>
            </td>

            <td v-if="approveDatas.cleanro_status == 'Approved'">
              <VChip color="success">Approved</VChip>
            </td>

            <td v-if="approveDatas.bfp_status == 'Approved'">
              <VChip color="success">Approved</VChip>
            </td>
            <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />

                <VMenu activator="parent">
                  <VList>
                    <!-- <VListItem title="View" :to="'/admin/clientview/' + approveDatas.id"/> -->
                    <VListItem title="Generate Permit"  @click="generatepermitform(approveDatas.id)"/>

                    
                  </VList>
                </VMenu>
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>
    </VCard>
    <VDialog v-model="generated_permit_dialog" scrollable max-width="400">
      <generate_permit
        @generatePermit = "hanndleRefresh"
        :generated_permit="generated_permit"
        @close="generated_permit_dialog = false"
      
      />
    </VDialog>
  </section>
</template>
