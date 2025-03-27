<script setup lang="ts">
import axios from "axios";
const emit = defineEmits(['close','rejectPermit'])
const props = defineProps(["rejectdata"]);
const cancel =() =>  {
  emit("close");
}

const Approve =() =>  {
  axios.put(`/api/auth/rejectpermit/`+ props.rejectdata)
  .then((response) => {
    console.log(response.data.success);
    emit('rejectPermit', response.data)
    emit('close')
  
  }
  )
}


</script>

<template>
  <section>
    <VCard height="200">
      <VCol>
        <VCardText>
          <div style="text-align: center;">
            <VIcon color="success" size="50" icon="ph:thumbs-down-fill"/>
            <h1>Are you sure?</h1>
          </div>
        </VCardText>
        <div class="float-right">
            <VBtn  @click="Approve" color="primary">Yes!</VBtn>&nbsp;
            <VBtn @click="cancel" variant="tonal" color="error">Cancel</VBtn>
          </div>
      </VCol>
    </VCard>
  </section>
</template>
