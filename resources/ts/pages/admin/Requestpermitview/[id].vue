<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const emit = defineEmits(['close','addOfficer'])
const first_name = ref();
const last_name = ref();
const middle_name = ref();
const email = ref();
const contact = ref();
const gender = ref();
const image = ref();
const address = ref();
const viewclient = ref();
const route = useRoute();



const viewclientdata =()=>{
  axios
    .get(`/api/auth/viewclient/`+route.params.id)

    .then((response) => {
      viewclient.value = response.data.viewclient[0];
      console.log(viewclient.value);
    });

}


onMounted(() => {
  viewclientdata();
});

</script>

<template>

  <section>
    
    <VCard>
      <v-card-title> View Officer Profile </v-card-title>
      <v-divider />
      <VCardText v-if="viewclient">

        <v-btn link to="/admin/clientlist">
          Back
        </v-btn>

        <VRow>
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly v-model="viewclient.firstname" label="First Name" />
          </VCol>

          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewclient.lastname" label="Last Name" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewclient.middlename" label="Middle Name" />
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="4" sm="3" md="4">
            <v-text-field  readonly  v-model="viewclient.email" label="Email" />
          </VCol>

    
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewclient.contact" label="Contact Number" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field 
            readonly 
              v-model="viewclient.gender"
              label="Gender"
             
              
            />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field  readonly v-model="viewclient.address" label="Address" />
          </VCol>

          <VCol>
            <v-file-input v-model="image" label="Image" />
          </VCol>
        </VRow>
      </VCardText>
    </VCard>
     
 
  </section>
</template>
