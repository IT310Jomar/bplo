<script setup lang="ts">
import axios from "axios";
import { ref } from "vue";
const emit = defineEmits(['close','activeOfficer'])
const props = defineProps(["activedata"]);
const cancel =() =>  {
  emit("close");
}

const active =() =>  {
  axios.put(`/api/auth/activeofficer/`+ props.activedata)
  .then((response) => {
    console.log(response.data.success);
    emit('activeOfficer', response.data)
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
            <VBtn  @click="active" color="primary">Yes!</VBtn>&nbsp;
            <VBtn @click="cancel" variant="tonal" color="error">Cancel</VBtn>
          </div>
      </VCol>
    </VCard>
  </section>
</template>
