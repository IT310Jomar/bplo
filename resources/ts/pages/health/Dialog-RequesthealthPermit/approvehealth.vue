<script setup lang="ts">
import axios from "axios";
import { onMounted,ref } from "vue";

const emit = defineEmits(['close','approvePermit'])
const props = defineProps(["approvedata"]);
const cancel =() =>  {
  emit("close");
}

const Approve =() =>  {
  axios.put(`/api/auth/approvehealth/`+ props.approvedata)
  .then((response) => {
    console.log(response.data.success);
    emit('approvePermit', response.data)
    emit('close')
    
  
  }
  )
}

onMounted(()=>{

 
})


</script>

<template>
  <section>
    <VCard height="200">
      <VCol>
        <VCardText>
          <div style="text-align: center;">
            <VIcon color="success" size="50" icon="ph:thumbs-up-fill"/>
            <h1>Are you sure?</h1>
          </div>
        </VCardText>
        <div class="float-right">
            <VBtn @click="Approve" color="primary">Yes!</VBtn>&nbsp;
            <VBtn @click="cancel" variant="tonal" color="error">Cancel</VBtn>
          </div>
      </VCol>
    </VCard>
  </section>
</template>
