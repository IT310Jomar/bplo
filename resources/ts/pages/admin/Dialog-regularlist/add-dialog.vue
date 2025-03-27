<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import { emailValidator, requiredValidator } from "@validators";
import { VForm } from "vuetify/components";
import logo from '@images/bplo_logo.png'


const isSnackbarSuccess = ref(false);
const isSnackbarErorr = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);
const imageUrl = ref<string | null>(null);
const refsubmit = ref<VForm>();
const first_name = ref();
const last_name = ref();
const middle_name = ref();
const email = ref();
const department = ref([{ item: "Select Item", value: null }]);
const dept = ref();
const position = ref();
const contact_number = ref();
const address = ref();
const age = ref();
const emit = defineEmits(["close", "addOfficer"]);
const gender = [
  { title: "Male", value: "Male" },
  { title: "Female", value: "Female" },
];
const gen = ref();

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
        imageUrl.value = e.target.result;
      }
    };

    reader.readAsDataURL(file);
  }
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

const onsubmit = () => {
  refsubmit.value?.validate().then(({ valid: isValid }) => {
    if (isValid) {
      isSnackbarSuccess.value = true;
      addofficerregulatory();
    } else {
      isSnackbarErorr.value = true;
    }
  });
};

const addofficerregulatory = () => {

  const formData = new FormData();
  formData.append("first_name", first_name.value);
  formData.append("last_name", last_name.value);
  formData.append("first_name", first_name.value);
  formData.append("middle_name", middle_name.value);
  formData.append("age", age.value);
  formData.append("contact_number", contact_number.value);
  formData.append("email", email.value);
  formData.append("dept", dept.value);
  formData.append("position", position.value);
  formData.append("gender", gen.value);
  formData.append("address", address.value);

  // Check if the file input has files and if the first file is selected
  if (fileInput.value?.files && fileInput.value.files.length > 0) {
    const file = fileInput.value.files[0];
    formData.append("image", file);
  }

  axios.post("/api/auth/addofficer", formData).then((response) => {
    if (response.data.success) {
      emit("addOfficer", response.data);

      close();
    }
  });
};

const close = () => {
  emit("close");
};

onMounted(() => {
  getdepartment();
});
</script>

<template>
  <section>
    <DialogCloseBtn @click="close" />
    <VCard height="500px" class="d-flex flex-column flex-grow-1 overflow-auto">
      <v-card-title> Add Officer </v-card-title>
      <v-divider />
      <VCardText>
        <VForm ref="refsubmit" @submit.prevent="onsubmit">
          <VRow>
            <VCol cols="4" sm="3" md="4">
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
              <div class="image-upload">
                <v-file-input
                  ref="fileInput"
                  @change="handleFileChange"
                  chips
                  label="Select File"
                  accept=".jpg,.jpeg,.png"
                />

                <small class="text-muted ml-10">
                  (5MB maximum file size, allowed file types: jpg, png, doc,
                  pdf)
                </small>

                <div v-if="imageUrl" class="circle-container">
                  <VImg
                    :src="imageUrl"
                    alt="Uploaded Image"
                    class="circle-image"
                  ></VImg>
                </div>
                <div v-else class="circle-container">
                  <VImg
                    :src="logo"
                    alt="Uploaded Image"
                    class="circle-image"
                  ></VImg>
                </div>
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
      Successfully Added
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
