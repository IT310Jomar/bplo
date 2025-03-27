<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import logo from "@images/bplo_logo.png";

const emit = defineEmits(["close", "addOfficer"]);
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

const viewclientdata = () => {
  axios
    .get(`/api/auth/viewclient/` + route.params.id)

    .then((response) => {
      viewclient.value = response.data.viewclient[0];
      console.log(viewclient.value);
    });
};

onMounted(() => {
  viewclientdata();
});
</script>

<template>
  <section>
    <!-- <DialogCloseBtn @click.prevent="closeDialog" /> -->
    <VCard class="mb-4" title="View Information">
      <v-btn
        link
        to="/admin/clientlist"
        class="d-flex float-right mr-5"
        style="margin-top: -5%"
        >Back</v-btn
      >
      <VDivider class="mt-4" />
      <VCardText v-if="viewclient">
        <v-row>
          <v-col cols="12" md="6" lg="4">
            <VCard class="d-flex flex-column mb-4 mt-3">
              <div>
                <div>
                  <div class="profile-card text-center mb-2">
                    <div class="profile-card-photo">
                      <VAvatar
                        class="cursor-pointer"
                        color="primary"
                        variant="tonal"
                        style="
                          width: 230px;
                          height: 230px;
                          margin-top: 10%;
                          margin-bottom: 3%;
                        "
                      >
                        <VImg v-if="viewclient" :src="logo" />
                        <Vimage v-else :src="'/storage/images/'+ viewclient.image"/>
                      </VAvatar>
                    </div>
                    <div style="font-weight: bold"></div>
                    <div style="font-weight: bold"></div>
                    <div class="mb-4"></div>
                  </div>
                </div>
              </div>
            </VCard>
            <VDivider />
            <VRow>
              <VCol style="text-align: center" class="mt-5"> </VCol>
            </VRow>
          </v-col>
          <v-card-text>
            <v-card
              class="headline mb-8"
              title="Personal Information"
              tabindex="-1"
            >
              <VDivider />
              <v-card-text>
                <v-table>
                  <tbody>
                    <tr>
                      <td width="300px"><strong>Full Name</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewclient.firstname }} {{ viewclient.middlename }} {{ viewclient.lastname }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td width="300px"><strong>Email</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewclient.email }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Email</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewclient.email }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Contact</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewclient.contact }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Address</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewclient.address }}</b></VChip
                        >
                      </td>
                    </tr>
                  </tbody>
                </v-table>
                <VDivider />
              </v-card-text>
            </v-card>
      
          </v-card-text>
        </v-row>
      </VCardText>
    </VCard>
  </section>
</template>

<style scoped>
.image-upload {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.circle-container {
  width: 230px;
  height: 230px;
  border-radius: 50%;
  overflow: hidden;
  margin-top: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: lightgray;
}

.circle-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
</style>
