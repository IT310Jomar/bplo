<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
import moment from "moment";

const get_generated_history =ref();

const getGenerated_history = ()=>{
  axios.get('/api/auth/get_generated_history')

.then(response=>{
  get_generated_history.value=response.data.get_generated_history
  // console.log(get_generated_history.value,'GENERATED HISTORY')
})
}

onMounted(()=>{
  getGenerated_history();
})

</script>

<template>
  <section>
    <VCard title="List of Genetated History ">
      <VTable>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Contact</th>
            <th>Address</th>
            <th>Type of Permit</th>
            <th>New or Renewal</th>
            <th>Release Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="generated_history in get_generated_history" :key="generated_history.id">
            <td>{{generated_history.requestlist.client.firstname}} {{generated_history.requestlist.client.middlename}} {{generated_history.requestlist.client.lastname}}</td>
            <td>{{generated_history.requestlist.client.contact}}</td>
            <td>{{generated_history.requestlist.client.address}}</td>
            <td>{{generated_history.requestlist.permit.name}}</td>
            <td>{{generated_history.requestlist.category.name}}</td>
            <td>{{moment(generated_history.created_at).format('MMMM DD YYYY h:mma')}}</td>
             <td>
              <VBtn icon size="x-small" variant="text">
                <VIcon icon="tabler-settings" size="22" />
                <VMenu activator="parent">
                  <VList>
                    <VListItem title="View" :to="'/admin/clientview/' + generated_history.id"/>
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

