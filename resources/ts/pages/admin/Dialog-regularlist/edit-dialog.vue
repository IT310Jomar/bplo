<script setup lang="ts">
import { emailValidator, requiredValidator } from "@validators";
import { VForm } from "vuetify/components";
import { ref, onMounted } from "vue";
import axios from "axios";
import { IconChevronsDownLeft } from "@tabler/icons";

const props = defineProps(["editdata"]);

const refsubmit = ref<VForm>();
const first_name = ref();
const last_name = ref();
const middle_name = ref();
const email = ref();
const position = ref();
const contact_number = ref();
const age = ref();
const address = ref();
const image = ref();
const images = ref();
const fileInput = ref<HTMLInputElement | null>(null);
const previosimage = ref<string | null>(null);
const user_id= ref();

const handleFileChange = () => {
  if (
    fileInput.value &&
    fileInput.value.files &&
    fileInput.value.files.length > 0
  ) {
    const file = fileInput.value.files[0];
    const reader = new FileReader();

    reader.onload = (e) => {
      if (e.target && typeof e.target.result === "string") {
        previosimage.value = e.target.result;
      }
    };

    reader.readAsDataURL(file);
  }
};

const gender = [
  { title: "Male", value: "Male" },
  { title: "Female", value: "Female" },
];
const gen = ref();
const department = ref([{ item: "Select Item", value: null }]);
const dept = ref();
const isSnackbarSuccess = ref();
const isSnackbarErorr = ref();
const emit = defineEmits(["close", "editOfficer"]);
const dataofficer = ref();

const onsubmit = () => {
  refsubmit.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      isSnackbarSuccess.value = true;
      editofficer();
    } else {
      isSnackbarErorr.value = true;
    }
  });
};


const getdepartment = () => {
  axios.get("/api/auth/getdepartment").then((response) => {
    // department.value = response.data.department
    if (response.data.success) {
      if (response.data.department) {
        const data = [];
        for (var x = 1; x < response.data.department.length; x++) {
          const depart = {
            item: response.data.department[x].name,
            value: response.data.department[x].id,
          };
          data.push(depart);
        }
        department.value = data;
      }
    }
  });
};





const viewofficer = ref();
const id = ref();
const r = ref();
const viewofficerdata = () => {
  axios
    .get(`/api/auth/viewofficer/` + props.editdata)

    .then((response) => {
      // viewofficer.value = response.data.viewofficer[0];
      // console.log(viewofficer.value);
      const data = [];
      const d = {
        id: (id.value = response.data.viewofficer[0].id),
        user_id: (user_id.value = response.data.viewofficer[0].user_id),
        first_name: (first_name.value = response.data.viewofficer[0].firstname),
        last_name: (last_name.value = response.data.viewofficer[0].lastname),
        middlename: (middle_name.value =
          response.data.viewofficer[0].middlename),
        email: (email.value = response.data.viewofficer[0].users.email),
        dept: (dept.value = response.data.viewofficer[0].users.departments.id),
        position: (position.value = response.data.viewofficer[0].position),
        contact_number: (contact_number.value =
          response.data.viewofficer[0].contact),
        gen: (gen.value = response.data.viewofficer[0].gender),
        age: (age.value = response.data.viewofficer[0].age),
        address: (address.value = response.data.viewofficer[0].address),
        image: (image.value =
          "/storage/images/" + response.data.viewofficer[0].image),
      };
      data.push(d);

      dataofficer.value = data;
    });
};

const editofficer = () => {

  const formData = new FormData();
  formData.append("id", id.value);
  formData.append("user_id", user_id.value);
  formData.append("first_name", first_name.value);
  formData.append("last_name", last_name.value);
  formData.append("middle_name", middle_name.value);
  formData.append("age", age.value);
  formData.append("contact_number", contact_number.value);
  formData.append("email", email.value);
  formData.append("dept", dept.value);
  formData.append("position", position.value);
  formData.append("gender", gen.value);
  formData.append("address", address.value);

  if (fileInput.value?.files && fileInput.value.files.length > 0) {
    const file = fileInput.value.files[0];
    formData.append("image", file);
  }

  axios
    .post(`/api/auth/editofficer/${props.editdata}`, formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }})
    .then((response) => {
      if (response.data.success) {
        emit("editOfficer", response.data);

        close();
      }
    });
};

const close = () => {
  emit("close");
};
onMounted(() => {
  getdepartment();
  viewofficerdata();
  

});
</script>

<template>
  <section>
    <DialogCloseBtn @click="close" />
    <VCard>
      <v-card-title> Edit Officer </v-card-title>
      <v-divider />
      <VCardText>
        <VForm ref="refsubmit" @submit.prevent="onsubmit">
          <VRow>
            <VCol cols="4" sm="3" md="4">
              <v-text-field v-model="id" style="display: none"></v-text-field>
              <v-text-field v-model="user_id" style="display: none"></v-text-field>

              <v-text-field
                :rules="[requiredValidator]"
                v-model="first_name"
                label="First Name"
              />
            </VCol>

            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                v-model="last_name"
                label="Last Name"
              />
            </VCol>
            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                v-model="middle_name"
                label="Middle Name"
              />
            </VCol>
          </VRow>

          <VRow>
            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator, emailValidator]"
                v-model="email"
                label="Email"
              />
            </VCol>

            <VCol cols="4" sm="3" md="4">
              <VSelect
                :rules="[requiredValidator]"
                v-model="dept"
                label="Department"
                :items="department"
                item-title="item"
                item-value="value"
              />
            </VCol>

            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                v-model="position"
                label="Position"
              />
            </VCol>
            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                v-model="contact_number"
                label="Contact Number"
              />
            </VCol>
            <VCol cols="4" sm="3" md="4">
              <VSelect
                :rules="[requiredValidator]"
                v-model="gen"
                label="Gender"
                :items="gender"
                item-title="title"
                item-value="value"
              />
            </VCol>
            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                type="number"
                v-model="age"
                label="Age"
              />
            </VCol>
            <VCol cols="4" sm="3" md="4">
              <v-text-field
                :rules="[requiredValidator]"
                v-model="address"
                label="Address"
              />
            </VCol>

            <VCol>
              
              <v-file-input ref="fileInput" @change="handleFileChange" v-model="images" label="Image"
                  accept=".jpg,.jpeg,.png,.doc,.docx,.pdf"/>
              <div class="circle-container" >
                <VImg v-if="previosimage"
                  :src="previosimage"
                  alt="Uploaded Image"
                  class="circle-image"
                ></VImg>
                <VImg v-else
                  :src="image"
                  alt="Uploaded Image"
                  class="circle-image"
                ></VImg>
              </div>
            </VCol>
          </VRow>

          <VCol class="mt-5">
            <VBtn type="submit" size="large"> Save </VBtn>
          </VCol>
        </VForm>
      </VCardText>
    </VCard>

    <!-- SnackBar -->
    <VSnackbar v-model="isSnackbarSuccess" :timeout="4000" color="success">
      Successfully Edit
    </VSnackbar>
    <VSnackbar v-model="isSnackbarErorr" :timeout="4000" color="error">
      Erorr! Please Check Your Field
    </VSnackbar>
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
