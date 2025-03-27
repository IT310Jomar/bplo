<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
const emit = defineEmits(["close", "viewPermit"]);
const props = defineProps(["row"]);
const cancel = () => {
  emit("close");
};

const viewrequestpermits = ref()

const viewreqs = ref()
const datas = ref()
const viewreqspermit = ref()

const viewreq =()=>{
  console.log(props.row)
  axios
    .get(`/api/auth/viewrequirments/`+ props.row)

    .then((response) => {
      viewreqs.value = response.data.viewrequirments;

      for(var data = 0 ; data < response.data.viewrequirments.length;data++){
         datas.value =  viewreqs.value[data]
      }
     console.log(datas.value)
    
    });

}


onMounted(()=>{
  

  viewreq()

  // if(viewrequestpermits != null){
  //   for(var data = 0; data < props.row.length;data++){
  //     viewreqspermit.value = props.row[data].id;

  //     // console.log(viewreqspermit.value)
  //   }
  // }
})

</script>
<template>
  <section>
    <DialogCloseBtn @click="cancel" />
    <VCard
      title="Requirments List"
      height="300px"
      class="d-flex flex-column flex-grow-1 overflow-auto"
    >
      <VTable>
        <thead>
          <tr>
            <th>Client Name</th>
            <th>Requested Permit</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="datas">
            <td>
             {{ datas.client.firstname }} {{ datas.client.middlename }} {{ datas.client.lastname }}

            </td>
            <td>
              {{ datas.permit.name }} 
            </td>
          </tr>
        </tbody>
      </VTable>
      <VCardText>
        <VCol>
        <div class="float-right mt-7">
          <VBtn @click="cancel" variant="tonal" color="error">Close</VBtn>
        </div>
      </VCol>
      </VCardText>
      
    </VCard>
  </section>
</template>
