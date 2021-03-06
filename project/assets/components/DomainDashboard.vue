<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h1>{{ store.data.state.activeDomain.name }}</h1>
      </div>
    </div>
    <hr />
    <div class="row">
      <div class="col-md-6">
        <div class="col-md-12 card">
          <div class="card-body border-bottom">
            <h2 class="card-title">Keywords</h2>
          </div>
          <ul class="list-group list-group-flush">
            <li
              class="list-group-item"
              :class="[
                store.data.state.activeDomain.amountUnsortedKeywords > 0
                  ? 'bg-warning'
                  : 'bg-success bg-opacity-50',
              ]"
            >
              Unsorted Keywords:
              {{ store.data.state.activeDomain.amountUnsortedKeywords }}
              <span
                v-if="store.data.state.activeDomain.amountLockedKeywords > 0"
              ><em>
                ({{
                  store.data.state.activeDomain.amountLockedKeywords
                }}
                locked)</em>
              </span>
            </li>
            <li class="list-group-item">
              Keywords: {{ store.data.state.activeDomain.amountKeywords }}
            </li>
          </ul>
          <div class="row p-2">
            <div class="col-6">
              <button
                class="btn btn-primary"
                :class="[
                  store.data.state.activeDomain.amountUnsortedKeywords == 0 ||
                  store.data.state.activeDomain.amountUnsortedKeywords ==
                    store.data.state.activeDomain.amountLockedKeywords
                    ? 'disabled'
                    : '',
                ]"
                @click="sortFirstKeyword"
              >
                Sort keywords
              </button>
            </div>
            <div class="col-6">
              <router-link
                class="btn btn-secondary float-end"
                :class="[
                  store.data.state.activeDomain.amountKeywords == 0
                    ? 'disabled'
                    : '',
                ]"
                to="/keywords"
                >Show all keywords</router-link
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="col-md-12 card">
          <div class="card-body border-bottom">
            <div class="row">
              <div class="col-8">
                <h2 class="card-title">Keyword groups</h2>
                <small>Click on a keyword group to see all keywords</small>
              </div>
              <div class="col-4 align-self-end">
                <button
                  class="btn btn-primary float-end"
                  @click="addNewKeywordGroup"
                >
                  Add new
                </button>
              </div>
            </div>
          </div>
          <div
            v-if="
              store.data.state.keywordGroups === null ||
              store.data.state.keywordGroups.length === 0
            "
          >
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                No keyword groups for this domain. Add some!
              </li>
            </ul>
          </div>
          <div v-else>
            <ul class="list-group list-group-flush">
              <li
                v-for="keywordGroup in store.data.state.keywordGroups"
                :key="keywordGroup['@id']"
                class="list-group-item"
              >
                <div class="row">
                  <div class="col-11">
                    <router-link
                      class="link-full"
                      :to="'/keywords/' + keywordGroup.id"
                    >
                      <div class="d-flex justify-content-between">
                        <span class="flex-grow-1">{{ keywordGroup.name }}</span>
                        <span class="badge bg-secondary">{{ keywordGroup.amountKeywords }} keywords</span>
                      </div>
                      
                    </router-link>
                  </div>
                  <div
                    class="col-1 pointer"
                    @click="downloadKeywordGroup(keywordGroup)"
                  >
                    <i
                      class="bi bi-download"
                      title="Download keyword group"
                    ></i>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../lib/api";

export default {
  name: "DomainDashboard",
  props: ["store"],
  async mounted() {
    await this.store.data.loadKeywordGroups();
    this.update();
  },
  methods: {
    /**
     * Update every 10 seconds 
     */
    update: async function() {
      await this.store.data.loadDomains();
      setTimeout(this.update, 10000);
    },

    /**
     * Show dialog to enter new keyword group and post to API
     */
    addNewKeywordGroup: function () {
      //ask for group name
      let keywordGroupName = prompt("Enter name");

      //cancel event
      if (keywordGroupName === null) {
        return;
      }

      //check if valid length
      if (keywordGroupName.length >= 1 && keywordGroupName.length <= 255) {
        //create object for post
        let keywordGroup = {
          name: keywordGroupName,
          domain: this.store.data.state.activeDomain["@id"],
        };
        //post object
        api
          .apiPostKeywordGroup(keywordGroup)
          .then(() => this.store.data.loadKeywordGroups());
      } else {
        alert("Invalid length");
      }
    },
    downloadKeywordGroup: function (keywordGroup) {
      let date = new Date();
      let formatedDate =
        date.getFullYear().toString() +
        date.getMonth().toString() +
        date.getDate().toString();
      let name =
        formatedDate + "_" + keywordGroup.name.replace(" ", "-") + ".csv";
      api.apiDownloadFile(keywordGroup["@id"] + ".csv", name);
    },
    sortFirstKeyword: async function () {
      let keywordId = await api.apiGetFirstUnsortedKeywordForDomain(
        this.store.data.state.activeDomain.id
      );
      this.$router.push("/keyword/" + keywordId);
    },
  },
};
</script>