<script setup lang="ts">
import logo from "@images/bplo_logo.png";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";



const viewofficer = ref();
const route = useRoute();
const image = ref();
const first_name = ref();
const last_name = ref();
const middle_name = ref();
const email = ref();
const contact = ref();
const address = ref();
const age = ref();
const gender = ref();

const viewofficerdata =()=>{
  axios
    .get(`/api/auth/viewofficer/`+route.params.id)

    .then((response) => {
      viewofficer.value = response.data.viewofficer[0];
      console.log(viewofficer.value);
    });

}

// const getImage = () => {
//   axios.get('/api/auth/getImage')
//   .then((response) => {
//     // Make sure to access the correct property from the response
//     const imageData = response.data; // Assuming 'image' is the correct property

//     console.log(imageData.value)
//     if (Array.isArray(imageData) && imageData.length > 0) {
//       // Check if imageData is an array and contains at least one element
//       image.value = imageData;
//     } else {
//       image.value = null; // Set images.value to null if no image data is available
//     }
//   });
// };


onMounted(() => {
  viewofficerdata();

  // getImage()
});

</script>

<template>
  <section>

    <!-- <DialogCloseBtn @click.prevent="closeDialog" /> -->
    <VCard class="mb-4" title="View Officer Profile">
      <v-btn
        link
        to="/admin/regular-list"
        class="d-flex float-right mr-5"
        style="margin-top: -5%"
        >Back</v-btn
      >
      <VDivider class="mt-4" />
      <VCardText v-if="viewofficer">
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
                        <VImg :src="'/storage/images/'+ viewofficer.image" 
                        />
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
                          ><b>{{ viewofficer.firstname }} {{ viewofficer.middlename }} {{ viewofficer.lastname }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td width="300px"><strong>Position</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewofficer.position }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Contact</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewofficer.contact }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Address</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewofficer.address }}</b></VChip
                        >
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Age</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewofficer.age }}</b></VChip
                        >
                      </td>
                     
                    </tr>
                    <tr>
                      <td><strong>Gender</strong></td>
                      <td>
                        <VChip color="success"
                          ><b>{{ viewofficer.gender }}</b></VChip
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
            
    <!-- <VForm>
              <VRow>
    
    <VCard>
      <v-card-title> View Officer Profile </v-card-title>
      <v-divider />
      <VCardText v-if="viewofficer">

        <div class="text-right"> 
          <v-btn link to="/admin/regular-list" class="mr-2">Back</v-btn> 
        </div>

        <VRow>
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly v-model="viewofficer.firstname" label="First Name" />
          </VCol>

          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewofficer.lastname" label="Last Name" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewofficer.middlename" label="Middle Name" />
          </VCol>
        </VRow>

        <VRow>
          <VCol cols="4" sm="3" md="4">
            <v-text-field  readonly  v-model="viewofficer.users.email" label="Email" />
          </VCol>

          <VCol cols="4" sm="3" md="4">
            <VSelect
           
              v-model="viewofficer.users.departments.name"
              label="Department"
              
            />
          </VCol> 

          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewofficer.position" label="Position" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field readonly  v-model="viewofficer.contact" label="Contact Number" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field 
            readonly 
              v-model="viewofficer.gender"
              label="Gender"
             
              
            />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field  type="number" readonly v-model="viewofficer.age" label="Age" />
          </VCol>
          <VCol cols="4" sm="3" md="4">
            <v-text-field  readonly v-model="viewofficer.address" label="Address" />
          </VCol>

          <VCol>
            <div class="circle-container">
                  <VImg
                    :src="'/storage/images/'+ viewofficer.image"
                    alt="Uploaded Image"
                    class="circle-image"
                  ></VImg>
                </div>
          </VCol>
        </VRow>

      </VCardText>
    </VCard> 
    </VRow>
    </VForm> -->
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
