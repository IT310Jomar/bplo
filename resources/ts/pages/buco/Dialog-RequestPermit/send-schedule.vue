<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
import { emailValidator, requiredValidator } from "@validators";

const emit = defineEmits(["close", "senddata"]);
const props = defineProps(["approveID","DataList"]);
const cancel = () => {
  emit("close");
};

const schedule_date = ref();
const data = ref()
const SendSchedule = () => {
  axios
    .post(`/api/auth/send_schedule/buco/` + props.approveID, {
      requirements: schedule_date.value,
      fullname: props.DataList[0].client.lastname,
    })
    .then((response) => {
      // console.log(response.data.success);
      emit("senddata", response.data);
      emit("close");
    });
};

onMounted(()=> {
  // console.log(props.DataList[0].client.firstname)
})

</script>

<template>
  <section>
    <VCard height="200">
      <VCol>
        <VCardText>
          <VForm>
            <div style="text-align: center">
              <h1>Choose a Date to Survey!</h1>
              <VTextField
                :rules="[requiredValidator]"
                type="date"
                v-model="schedule_date"
                label="Schedule"
              ></VTextField>
            </div>
          </VForm>
        </VCardText>
        <div class="float-right">
          <VBtn @click="SendSchedule" color="primary">Are you Sure? Yes!</VBtn
          >&nbsp;
          <VBtn @click="cancel" variant="tonal" color="error">Cancel</VBtn>
        </div>
      </VCol>
    </VCard>
  </section>
</template>
