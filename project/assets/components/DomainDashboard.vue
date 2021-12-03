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
          <div class="card-body">
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
            </li>
            <li class="list-group-item">
              Keywords: {{ store.data.state.activeDomain.amountKeywords }}
            </li>
          </ul>
          <div class="row">
            <div class="col-6">
              <button class="btn btn-primary">Sort keywords</button>
            </div>
            <div class="col-6 justify-content-end">
              <button class="btn btn-secondary">Show all keywords</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="col-md-12 card">
          <div class="card-body">
            <div class="row">
              <div class="col-8">
                <h2 class="card-title">Keyword groups</h2>
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
            <div v-if="store.data.state.keywordGroups === null">
              <p>No keyword sets created. Add some!</p>
            </div>
            <div class="v-else">
              <ul class="list-group list-group-flush">
                <li
                  v-for="keywordGroup in store.data.state.keywordGroups"
                  :key="keywordGroup['@id']"
                  class="list-group-item"
                >
                  {{ keywordGroup.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import helper from "../lib/helper";

export default {
  name: "DomainDashboard",
  props: ["store"],
  async mounted() {
    await this.store.data.loadKeywordGroups();
  },
  methods: {
    addNewKeywordGroup: function () {
      helper.addNewKeywordGroup(this.store.data);
    },
  },
};
</script>