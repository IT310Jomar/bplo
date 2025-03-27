<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
const clientdata =ref();
const getclient = ()=>{
  axios.get('/api/auth/getclient')

.then(response=>{
  clientdata.value=response.data.clientdatas
  console.log(clientdata.value)
})
}

onMounted(()=>{
  getclient();
})




</script>

<template>
  <section>
    <VCard title="Client List">
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Contact</th>
            <th>Email Address</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>



          <tr v-for="clientdatas in clientdata" :key="clientdatas.id">
            <td>{{clientdatas.firstname}} {{clientdatas.middlename}} {{clientdatas.lastname}}</td>
            <td>{{clientdatas.contact}}</td>
            <td>{{clientdatas.email}}</td>
            <td>{{clientdatas.address}}</td>
            <td>{{clientdatas.gender}}</td>
            
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + clientdatas.id"/>
                    
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
