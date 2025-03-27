<script setup lang="ts">
import ApexChartExpenseRatio from "@/views/charts/apex-chart/ApexChartExpenseRatio.vue";
import ApexChartStatistics from "@/views/charts/apex-chart/ApexChartStatistics.vue";

const userRole = JSON.parse(localStorage.getItem("userDepartment") || "{}");

// 👉 List
const userListMeta = [
  {
    icon: "tabler-user",
    color: "primary",
    title: "Session",
    stats: "21,459",
    percentage: +29,
    subtitle: "Total Users",
  },
  {
    icon: "tabler-user-plus",
    color: "error",
    title: "Paid Users",
    stats: "4,567",
    percentage: +18,
    subtitle: "Last week analytics",
  },
  {
    icon: "tabler-user-check",
    color: "success",
    title: "Active Users",
    stats: "19,860",
    percentage: -14,
    subtitle: "Last week analytics",
  },
  {
    icon: "tabler-user-exclamation",
    color: "warning",
    title: "Pending Users",
    stats: "237",
    percentage: +42,
    subtitle: "Last week analytics",
  },
];

const BUCO_Meta = [
  {
    icon: "tabler-user",
    color: "primary",
    title: "Session",
    stats: "21,459",
    percentage: +29,
    subtitle: "Total Users",
  },
  {
    icon: "tabler-user-plus",
    color: "error",
    title: "Paid Users",
    stats: "4,567",
    percentage: +18,
    subtitle: "Last week analytics",
  },
];
</script>

<template>
  <section>
    <VRow v-if="userRole == 'Admin'">
      <VCol
        v-for="meta in userListMeta"
        :key="meta.title"
        cols="12"
        sm="6"
        lg="3"
      >
        <VCard>
          <VCardText class="d-flex justify-space-between">
            <div>
              <span>{{ meta.title }}</span>
              <div class="d-flex align-center gap-2 my-1">
                <h6 class="text-h6">
                  {{ meta.stats }}
                </h6>
                <span
                  :class="meta.percentage > 0 ? 'text-success' : 'text-error'"
                  >({{ meta.percentage }}%)</span
                >
              </div>
              <span>{{ meta.subtitle }}</span>
            </div>

            <VAvatar
              rounded
              variant="tonal"
              :color="meta.color"
              :icon="meta.icon"
            />
          </VCardText>
        </VCard>
      </VCol>

      <VRow>
        <VCol>
          <VCard class="mb-6" flat>
            <VCardText>
              <VRow>
                <VCol
                  style="
                    background-image: url('build/assets/img/bplo_logo.png');
                    background-size: 420px 400px;
                    background-position: center;
                  "
                >
                  <h1
                    style="
                      text-align: center;
                      font-size: 30px;
                      font-weight: bolder;
                    "
                  >
                    Mission
                  </h1>
                  <br />
                  <p
                    style="
                      text-align: center;
                      font-size: 20px;
                      font-weight: bolder;
                    "
                  >
                    &bull; To be an effective, efficient, and business-friendly
                    Business Permit and Licensing Office.
                  </p>
                  <p
                    style="
                      text-align: center;
                      font-size: 20px;
                      font-weight: bolder;
                    "
                  >
                    &bull; To stimulate business growth and ensure legal
                    operations.
                  </p>
                  <p
                    style="
                      text-align: center;
                      font-size: 20px;
                      font-weight: bolder;
                    "
                  >
                    &bull; To ensure public safety by ensuring compliance of
                    business establishments <br />with government-mandated
                    regulations and laws.
                  </p>
                  <h1
                    style="
                      text-align: center;
                      font-size: 30px;
                      font-weight: bolder;
                    "
                  >
                    Vision
                  </h1>
                  <br />
                  <p
                    style="
                      text-align: center;
                      font-size: 20px;
                      font-weight: bolder;
                    "
                  >
                    &bull; To provide a business-friendly streamlined process,
                    delivering professionalized <br />services in line with
                    global technology and competitiveness.
                  </p>
                </VCol>
                <!-- 
                  <VCol cols="12" sm="5" class="centered-image-container">
                    <VImg
                      class="centered-image"
                      style="border-radius: 10px"
                      :src="logo"
                      cover
                    />
                  </VCol>
                  -->
              </VRow>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>

      <VCol cols="12" md="6">
        <VCard title="Statistics">
          <VCardText>
            <ApexChartStatistics />
          </VCardText>
        </VCard>
      </VCol>

      <VCol cols="12" md="6">
        <VCard title="Expense Ratio">
          <VCardText>
            <ApexChartExpenseRatio />
          </VCardText>
        </VCard>
      </VCol>
    </VRow>

    <VCard v-if="userRole == 'Bureau of Collection'" class="mb-6">
      <VCardText>
        <VRow>
          <VCol
            v-for="meta in BUCO_Meta"
            :key="meta.title"
            cols="12"
            sm="16"
            lg="6"
          >
            <VCard>
              <VCardText class="d-flex justify-space-between">
                <div>
                  <span>{{ meta.title }}</span>
                  <div class="d-flex align-center gap-2 my-1">
                    <h6 class="text-h6">
                      {{ meta.stats }}
                    </h6>
                    <span
                      :class="
                        meta.percentage > 0 ? 'text-success' : 'text-error'
                      "
                      >({{ meta.percentage }}%)</span
                    >
                  </div>
                  <span>{{ meta.subtitle }}</span>
                </div>

                <VAvatar
                  rounded
                  variant="tonal"
                  :color="meta.color"
                  :icon="meta.icon"
                />
              </VCardText>
            </VCard>
          </VCol>
        </VRow>

        <VRow>
          <VCol>
            <VCard class="mb-6" flat>
              <VCardText
                style="
                  background-image: url('build/assets/img/buco.png');
                  background-size: 850px 500px;
                  background-position: center;
                "
              >
                <VRow>
                  <VCol>
                    <v-spacer></v-spacer>
                    <h1
                      style="
                        text-align: center;
                        font-size: 30px;
                        font-weight: bolder;
                      "
                    >
                     Vision/Mission
                    </h1>
                    <br />
                    <br>
                    <br>

                    <p
                      style="
                        text-align: center;
                        font-size: 20px;
                        font-weight: bolder;
                      "
                    >
                      &bull; To Edition also incorporates the latest laws ,
                    </p>
                    <p
                      style="
                        text-align: center;
                        font-size: 20px;
                        font-weight: bolder;
                      "
                    >
                      &bull; jurisprudence and issuances of local budgeting
                    </p>
                    <p
                      style="
                        text-align: center;
                        font-size: 20px;
                        font-weight: bolder;
                      "
                    >
                      &bull; As the most comprehensive an definitive guide on
                      local budget.
                    </p>
                    <br>
                    <br>
                    <br>
                  </VCol>
                </VRow>
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <VCard v-if="userRole == 'CleanRo'" class="mb-6" title="CleanRo Dashboard">
      <VCardText>
        <VRow>
          <VCol
            v-for="meta in BUCO_Meta"
            :key="meta.title"
            cols="15"
            sm="10"
            lg="6"
          >
            <VCard>
              <VCardText class="d-flex justify-space-between">
                <div>
                  <span>{{ meta.title }}</span>
                  <div class="d-flex align-center gap-2 my-1">
                    <h6 class="text-h6">
                      {{ meta.stats }}
                    </h6>
                    <span
                      :class="
                        meta.percentage > 0 ? 'text-success' : 'text-error'
                      "
                      >({{ meta.percentage }}%)</span
                    >
                  </div>
                  <span>{{ meta.subtitle }}</span>
                </div>

                <VAvatar
                  rounded
                  variant="tonal"
                  :color="meta.color"
                  :icon="meta.icon"
                />
              </VCardText>
            </VCard>
          </VCol>
        </VRow>
      </VCardText>
    </VCard>

    <VCard v-if="userRole == 'Health'" class="mb-6" title="Health Dashboard">
      <VCardText>Health</VCardText>
      <VCardText>
        Please make sure to read our
        <a
          href="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/documentation/"
          target="_blank"
          rel="noopener noreferrer"
          class="text-decoration-none"
        >
          Template Documentation
        </a>
        to understand where to go from here and how to use our template.
      </VCardText>
    </VCard>

    <VCard
      v-if="userRole == 'Bureau of Fire Protection'"
      class="mb-6"
      title="Bureau of Fire Protection Dashboard"
    >
      <VCardText>Bureau of Fire Protection</VCardText>
      <VCardText>
        Please make sure to read our
        <a
          href="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/documentation/"
          target="_blank"
          rel="noopener noreferrer"
          class="text-decoration-none"
        >
          Template Documentation
        </a>
        to understand where to go from here and how to use our template.
      </VCardText>
    </VCard>
  </section>
</template>

<style lang="scss">
.content {
  position: relative;
  background-image: url("build/assets/img/bplo_logo.png");
  background-size: cover;
  block-size: 100vh;
  inline-size: 100%;
  border-radius: 10px;
  opacity: 0.7;
}

.image-logo {
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  opacity: 0.5; /* Adjust opacity as needed */
}
</style>
