<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
const emit = defineEmits(['close','disableOfficer'])
const props = defineProps(["disabledata"]);
const cancel =() =>  {
  emit("close");
}

const disable =() =>  {
  axios.put(`/api/auth/disableofficer/`+ props.disabledata)
  .then((response) => {
    console.log(response.data.success);
    emit('disableOfficer', response.data)
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
            <VIcon color="error" size="50" icon="tabler-info-octagon"/>
            <h1>Are you sure?</h1>
          </div>
        </VCardText>
        <div class="float-right">
            <VBtn  @click="disable" color="primary">Yes!</VBtn>&nbsp;
            <VBtn  @click="cancel" variant="tonal" color="error">Cancel</VBtn>
          </div>
      </VCol>
    </VCard>
  </section>
</template>
