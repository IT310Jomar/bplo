<script setup lang="ts">
import axios from "axios";
import { onMounted,ref } from "vue";

const emit = defineEmits(['close','generatePermit'])
const props = defineProps(["generated_permit"]);
const cancel =() =>  {
  emit("close");
}

const generatePermit =() =>  {
  axios.post(`/api/auth/generated_history/`+ props.generated_permit)
  .then((response) => {
    console.log(response.data.success,'generated Permit');
    emit('generatePermit', response.data)
    emit('close')
  }
  )
}

onMounted(()=>{
  console.log(props.generated_permit,'IDDDDDDD')
 
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
            <VBtn @click="generatePermit" color="primary">Yes!</VBtn>&nbsp;
            <VBtn @click="cancel" variant="tonal" color="error">Cancel</VBtn>
          </div>
      </VCol>
    </VCard>
  </section>
</template>
