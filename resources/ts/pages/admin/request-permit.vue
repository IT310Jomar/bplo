<script lang="ts" setup>
import axios from "axios";
import { ref } from "vue";
import { debounce } from "lodash";

import approvepermit from "./Dialog-RequestPermit/approve-dialog.vue";
import rejectpermit from "./Dialog-RequestPermit/reject-dialog.vue";
import viewpermit from "./Dialog-RequestPermit/view-dialog.vue";
import { environment } from "@/environments/environment";

const nbi = ref();
const sss = ref();
const approvedata = ref();
const viewdata = ref();
const rejectdata = ref();
const approve_dialog = ref(false);
const reject_dialog = ref(false);
const view_dialog = ref(false);
const viewrequirments = ref();

const currentTab = ref("Pending");
const searchQuery = ref(null);
const searchQueryapprove = ref(null);
const searchQueryreject = ref(null);
const currentPage = ref(1);
const currentPageRejected = ref(1);
const currentPageApproved = ref(1);
const perPages = [5, 10, 20, 50, 100, 500];
const perPagesApproved = [5, 10, 20, 50, 100, 500];
const perPagesRejected = [5, 10, 20, 50, 100, 500];
const itemsPerPage = ref(perPages[0]);
const itemsPerApproved = ref(perPagesApproved[0]);
const itemsPerRejected = ref(perPagesRejected[0]);
const selectedPerPage = ref(itemsPerPage.value);
const selectedPerPageApproved = ref(itemsPerApproved.value);
const selectedPerPageRejected = ref(itemsPerRejected.value);
const paginationPendingPage = ref(currentPage);
const paginationApprovalPage = ref(currentPageApproved);
const paginationRejectPage = ref(currentPageRejected);

const selected = ref(itemsPerPage);
const selectedapproval = ref(itemsPerPage);
const selectedreject = ref(itemsPerPage);

const pendingrequestpermits = ref("");
const approvalrequestpermits = ref("");
const rejectrequestpermits = ref("");

const pending_category = ref();
const approved_category = ref();
const rejected_category = ref();

const permit_category = ref([{ item: "--Select Category--", value: null }]);

//pending category
const getcategory = () => {
  axios.get("/api/auth/getcategory").then((response) => {
    if (response.data.success) {
      if (response.data.categoryPermit) {
        const data = [];
        for (var x = 0; x < response.data.categoryPermit.length; x++) {
          const pending_category = {
            item: response.data.categoryPermit[x].name,
            value: response.data.categoryPermit[x].id,
          };
          data.push(pending_category);
        }
        permit_category.value = data;
      }
    }
  });
};

//Search for pending request
const searchrequestPending = () => {
  axios
    .get(environment.API_URL + "auth/requestlist/search", {
      params: {
        query: searchQuery.value,
        category: pending_category.value,
      },
    })
    .then((response) => {
      if (response.data.success) {
        pendingrequestpermits.value = response.data.searchPending;
      }
    })
    .catch((error) => {
      console.log("Error");
    });
};

//Search for approve request
const searchRequestApprove = () => {
  axios
    .get(environment.API_URL + "auth/requestapprove/search", {
      params: {
        query: searchQueryapprove.value,
        category: approved_category.value,
      },
    })
    .then((response) => {
      if (response.data.success) {
        approvalrequestpermits.value = response.data.searchApproved;
      }
    })
    .catch((error) => {
      console.log("Error");
    });
};

//Search for reject request
const searchRequestReject = () => {
  axios
    .get(environment.API_URL + "auth/requestreject/search", {
      params: {
        query: searchQueryreject.value,
        category: rejected_category.value,
      },
    })
    .then((response) => {
      if (response.data.success) {
        rejectrequestpermits.value = response.data.searchReject;
      }
    })
    .catch((error) => {
      console.log("Error");
    });
};

//Pending Pagination
const paginatedDataPending = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return pendingrequestpermits.value.slice(startIndex, endIndex);
});

//Approval Pagination
const paginatedDataApproval = computed(() => {
  const startIndex = (currentPageApproved.value - 1) * itemsPerApproved.value;
  const endIndex = startIndex + itemsPerApproved.value;
  return approvalrequestpermits.value.slice(startIndex, endIndex);
});

//Reject Pagination
const paginatedDataReject = computed(() => {
  const startIndex = (currentPageRejected.value - 1) * itemsPerRejected.value;
  const endIndex = startIndex + itemsPerRejected.value;
  return rejectrequestpermits.value.slice(startIndex, endIndex);
});

let totalPages = computed(() => {
  if (pendingrequestpermits.value.length > 0) {
    return Math.ceil(pendingrequestpermits.value.length / itemsPerPage.value);
  } else {
    return 0;
  }
});

let totalPagesApproval = computed(() => {
  if (approvalrequestpermits.value.length > 0) {
    return Math.ceil(
      approvalrequestpermits.value.length / itemsPerApproved.value
    );
  } else {
    return 0;
  }
});

let totalPagesReject = computed(() => {
  if (rejectrequestpermits.value.length > 0) {
    return Math.ceil(
      rejectrequestpermits.value.length / itemsPerRejected.value
    );
  } else {
    return 0;
  }
});

function itemPerPagePending(selectedPerPageValue: number) {
  itemsPerPage.value = selectedPerPageValue;

  if (itemsPerPage.value == 5) {
    const index = 0;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 10) {
    const index = 1;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 20) {
    const index = 2;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 50) {
    const index = 3;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 100) {
    const index = 4;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 500) {
    const index = 5;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else {
    console.log("Error");
  }
} //end of function

function itemPerPageApproval(selectedPerPageValue: number) {
  itemsPerPage.value = selectedPerPageValue;

  if (itemsPerPage.value == 5) {
    const index = 0;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 10) {
    const index = 1;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 20) {
    const index = 2;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 50) {
    const index = 3;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 100) {
    const index = 4;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 500) {
    const index = 5;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else {
    console.log("Error");
  }
} //end of function

function itemPerPageReject(selectedPerPageValue: number) {
  itemsPerPage.value = selectedPerPageValue;

  if (itemsPerPage.value == 5) {
    const index = 0;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 10) {
    const index = 1;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 20) {
    const index = 2;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 50) {
    const index = 3;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 100) {
    const index = 4;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else if (itemsPerPage.value == 500) {
    const index = 5;
    itemsPerPage.value = perPages[index];
    currentPage.value = 1;
    console.log(index);
  } else {
    console.log("Error");
  }
} //end of function

//handle the pagination in pending request that will emitted to the parent component
function updatePage(newPage: number) {
  paginationPendingPage.value = newPage;
  // console.log(paginationPendingPage.value);
}

function updatePending() {
  searchrequestPending();
}

function updatePageApproval(newPage: number) {
  paginationPendingPage.value = newPage;
  // console.log(paginationPendingPage.value);
}

function updateApproval() {
  searchRequestApprove();
}

function updatePageReject(newPage: number) {
  paginationPendingPage.value = newPage;
  // console.log(paginationPendingPage.value);
}

function updateRejected() {
  searchRequestReject();
}

// watch the data input search by the user for pending request
watch(
  [searchQuery, pending_category],
  debounce(() => {
    if (searchQuery.value === "") {
      // Reset the data to the original values
      pendingrequest();
    } else if (pending_category.value === null) {
      pendingrequest();
    } else {
      searchrequestPending();
    }
  })
);

// watch the data input search by the user for approve request
watch(
  [searchQueryapprove, approved_category],
  debounce(() => {
    if (searchQueryapprove.value === "") {
      // Reset the data to the original values
      Approverequest();
    } else if (approved_category.value === null) {
      Approverequest();
    } else {
      searchRequestApprove();
    }
  })
);

// watch the data input search by the user for reject request
watch(
  [searchQueryreject, rejected_category],
  debounce(() => {
    if (searchQueryreject.value === "") {
      // Reset the data to the original values
      Rejectrequest();
    } else if (rejected_category.value === null) {
      Rejectrequest();
    } else {
      searchRequestReject();
    }
  })
);

// for changing the item per page for pending
// function onChangeSelectedPerPage(selectedValue: number) {
//     emit('selected-per-page-change', selectedValue);
// }

const approvepermitform = (id: any) => {
  approvedata.value = id;
  approve_dialog.value = true;
};

const rejectpermitform = (id: any) => {
  rejectdata.value = id;
  reject_dialog.value = true;
};

const viewpermitform = (id: any) => {
  viewdata.value = id;
  view_dialog.value = true;
};

const pendingrequest = () => {
  axios
    .get("/api/auth/getrequestlist")

    .then((response) => {
      pendingrequestpermits.value = response.data.getrequestlist;
      // console.log(pendingrequestpermits.value);
    });
};

const Approverequest = () => {
  axios
    .get("/api/auth/getapprovalrequestlist")

    .then((response) => {
      approvalrequestpermits.value = response.data.getapprovalrequestlist;
      // console.log(approvalrequestpermits.value);
    });
};

const Rejectrequest = () => {
  axios
    .get("/api/auth/getrejectrequestlist")

    .then((response) => {
      rejectrequestpermits.value = response.data.getrejectrequestlist;
      console.log(rejectrequestpermits.value);
    });
};

onMounted(() => {
  pendingrequest();
  Rejectrequest();
  Approverequest();
});
const handleApprove = () => {
  pendingrequest();
  Rejectrequest();
  Approverequest();
};

const handleReject = () => {
  pendingrequest();
  Rejectrequest();
  Approverequest();
};

const handleView = () => {
  pendingrequest();
  Rejectrequest();
  Approverequest();
};

const requestData = ref(null);

const getrequestlist = () => {
  axios
    .get("/api/auth/listData")
    .then((response) => {
      if (response.data.list && response.data.list.length > 0) {
        requestData.value = response.data.list[0].id;
        console.log("hdd", requestData.value);
      }
    })
    .catch((error) => {
      console.error("Error fetching request list:", error);
    });
};

const reqs = () => {
  if (requestData.value !== null) {
    axios
      .put(`/api/auth/requirements/${requestData.value}`, {
        NBI: nbi.value,
        SSS: sss.value,
      })
      .then((response) => {
        // console.log('Success:', response.data);
      })
      .catch((error) => {
        console.error("Error updating requirements:", error);
      });
  } else {
    console.warn("No request data available.");
  }
};

onMounted(() => {
  getrequestlist();
  getcategory();
});
</script>

<template>
  <section>
    <v-card-title>Request Permit List</v-card-title>
    <v-tabs v-model="currentTab" class="mt-5 mb-5">
      <VTab value="pending"> Pending</VTab>
      <VTab value="approved"> Approved</VTab>
      <VTab value="rejected">Rejected / Cancelled</VTab>
    </v-tabs>

    <v-window v-model="currentTab">
      <v-window-item value="pending">
        <VCard>
          <v-card-text class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3" style="width: 80px">
              <VSelect
                v-model="selected"
                :items="perPages"
                :item-value="itemsPerPage"
                :item-title="selectedPerPage"
                @update:modelValue="itemPerPagePending"
              />
            </div>
            <VSpacer />

            <div class="me-5" style="width: 12rem">
              <VSelect
                v-model="pending_category"
                label="New or Renewal"
                :items="permit_category"
                item-title="item"
                item-value="value"
                @update:modelValue="updatePending"
              />
            </div>

            <div
              class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
              style="width: 15rem"
            >
              <v-text-field
                v-model="searchQuery"
                label="Search"
                class="search-field"
                solo
                append-inner-icon="mdi-magnify"
                density="compact"
              >
              </v-text-field>
            </div>
          </v-card-text>
          <!-- 👉 table head -->
          <VTable>
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Email Address</th>
                <th>Request Permits</th>
                <th>New or Renewal</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="viewrequestpermit in paginatedDataPending"
                :key="viewrequestpermit.id"
              >
                <td>
                  {{ viewrequestpermit.client.firstname }}
                  {{ viewrequestpermit.client.middlename }}
                  {{ viewrequestpermit.client.lastname }}
                </td>
                <td>{{ viewrequestpermit.client.contact }}</td>
                <td>{{ viewrequestpermit.client.email }}</td>
                <td>{{ viewrequestpermit.permit.name }}</td>
                <td>{{ viewrequestpermit.category.name }}</td>
                <td v-if="viewrequestpermit.status.name == 'Approve'">
                  <VChip color="success">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Pending'">
                  <VChip color="warning">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Reject'">
                  <VChip color="error">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>

                <td>
                  <VBtn icon size="x-small" variant="text">
                    <VIcon icon="tabler-settings" size="22" />
                    <VMenu activator="parent">
                      <VList>
                        <VListItem
                          title="View"
                          @click="viewpermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Approve"
                          @click="approvepermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Reject"
                          @click="rejectpermitform(viewrequestpermit.id)"
                        />
                      </VList>
                    </VMenu>
                  </VBtn>
                </td>
              </tr>
            </tbody>
          </VTable>
          <VPagination
            :length="totalPages"
            v-model="paginationPendingPage"
            @update:model-value="updatePage"
          />
        </VCard>
      </v-window-item>
      <v-window-item value="approved">
        <VCard>
          <v-card-text class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3" style="width: 80px">
              <VSelect
                v-model="selectedapproval"
                :items="perPagesApproved"
                :item-value="itemsPerApproved"
                :item-title="selectedPerPageApproved"
                @update:modelValue="itemPerPageApproval"
              />
            </div>
            <VSpacer />

            <div class="me-5" style="width: 12rem">
              <VSelect
                v-model="approved_category"
                label="New or Renewal"
                :items="permit_category"
                item-title="item"
                item-value="value"
                @update:modelValue="updateApproval"
              />
            </div>

            <div
              class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
              style="width: 15rem"
            >
              <v-text-field
                v-model="searchQueryapprove"
                label="Search"
                class="search-field"
                solo
                append-inner-icon="mdi-magnify"
              >
              </v-text-field>
            </div>
          </v-card-text>
          <!-- 👉 table head -->
          <VTable>
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Email Address</th>
                <th>Request Permits</th>
                <th>New or Renewal</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="viewrequestpermit in paginatedDataApproval"
                :key="viewrequestpermit.id"
              >
                <td>
                  {{ viewrequestpermit.client.firstname }}
                  {{ viewrequestpermit.client.middlename }}
                  {{ viewrequestpermit.client.lastname }}
                </td>
                <td>{{ viewrequestpermit.client.contact }}</td>
                <td>{{ viewrequestpermit.client.email }}</td>
                <td>{{ viewrequestpermit.permit.name }}</td>
                <td>{{ viewrequestpermit.category.name }}</td>
                <td v-if="viewrequestpermit.status.name == 'Approve'">
                  <VChip color="success">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Pending'">
                  <VChip color="warning">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Reject'">
                  <VChip color="error">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>

                <td>
                  <VBtn icon size="x-small" variant="text">
                    <VIcon icon="tabler-settings" size="22" />
                    <VMenu activator="parent">
                      <VList>
                        <VListItem
                          title="View"
                          @click="viewpermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Approve"
                          @click="approvepermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Reject"
                          @click="rejectpermitform(viewrequestpermit.id)"
                        />
                      </VList>
                    </VMenu>
                  </VBtn>
                </td>
              </tr>
            </tbody>
          </VTable>
          <VPagination
            :length="totalPagesApproval"
            v-model="paginationApprovalPage"
            @update:model-value="updatePageApproval"
          />
        </VCard>
      </v-window-item>
      <v-window-item value="rejected">
        <VCard>
          <v-card-text class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3" style="width: 80px">
              <VSelect
                v-model="selectedreject"
                :items="perPagesRejected"
                :item-value="itemsPerRejected"
                :item-title="selectedPerPageRejected"
                @update:modelValue="itemPerPageReject"
              />
            </div>
            <VSpacer />

            <div class="me-5" style="width: 12rem">
              <VSelect
                v-model="rejected_category"
                label="New or Renewal"
                :items="permit_category"
                item-title="item"
                item-value="value"
                @update:model-value="updateRejected"
              />
            </div>
            <div
              class="app-user-search-filter d-flex align-center flex-wrap gap-4 justify-end"
              style="width: 15rem"
            >
              <v-text-field
                v-model="searchQueryreject"
                label="Search"
                class="search-field"
                solo
                append-inner-icon="mdi-magnify"
              >
              </v-text-field>
            </div>
          </v-card-text>
          <!-- 👉 table head -->
          <VTable>
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Contact</th>
                <th>Email Address</th>
                <th>Request Permits</th>
                <th>New or Renewal</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="viewrequestpermit in paginatedDataReject"
                :key="viewrequestpermit.id"
              >
                <td>
                  {{ viewrequestpermit.client.firstname }}
                  {{ viewrequestpermit.client.middlename }}
                  {{ viewrequestpermit.client.lastname }}
                </td>
                <td>{{ viewrequestpermit.client.contact }}</td>
                <td>{{ viewrequestpermit.client.email }}</td>
                <td>{{ viewrequestpermit.permit.name }}</td>
                <td>{{ viewrequestpermit.category.name }}</td>
                <td v-if="viewrequestpermit.status.name == 'Approve'">
                  <VChip color="success">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Pending'">
                  <VChip color="warning">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>
                <td v-if="viewrequestpermit.status.name == 'Reject'">
                  <VChip color="error">{{
                    viewrequestpermit.status.name
                  }}</VChip>
                </td>

                <td>
                  <VBtn icon size="x-small" variant="text">
                    <VIcon icon="tabler-settings" size="22" />
                    <VMenu activator="parent">
                      <VList>
                        <VListItem
                          title="View"
                          @click="viewpermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Approve"
                          @click="approvepermitform(viewrequestpermit.id)"
                        />
                        <VListItem
                          title="Reject"
                          @click="rejectpermitform(viewrequestpermit.id)"
                        />
                      </VList>
                    </VMenu>
                  </VBtn>
                </td>
              </tr>
            </tbody>
          </VTable>
          <VPagination
            :length="totalPagesReject"
            v-model="paginationRejectPage"
            @update:model-value="updatePageReject"
          />
        </VCard>
      </v-window-item>
    </v-window>

    <VDialog v-model="approve_dialog" scrollable max-width="400">
      <approvepermit
        :approvedata="approvedata"
        @close="approve_dialog = false"
        @approvePermit="handleApprove"
      />
    </VDialog>

    <VDialog v-model="reject_dialog" scrollable max-width="400">
      <rejectpermit
        :rejectdata="rejectdata"
        @close="reject_dialog = false"
        @rejectPermit="handleReject"
      />
    </VDialog>

    <VDialog v-model="view_dialog" scrollable max-width="500">
      <viewpermit
        :row="viewdata"
        @close="view_dialog = false"
        @viewPermit="handleView"
      />
    </VDialog>
  </section>
</template>
