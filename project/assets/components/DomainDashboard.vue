<template>
  <div>
    <div class="row">
      <div class="col-12">
        <h1>{{ domain.name }}</h1>
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
                domain.amountUnsortedKeywords > 0
                  ? 'bg-warning'
                  : 'bg-success bg-opacity-50',
              ]"
            >
              Unsorted Keywords: {{ domain.amountUnsortedKeywords }}
            </li>
            <li class="list-group-item">
              Keywords: {{ domain.amountKeywords }}
            </li>
          </ul>
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
            <div v-if="keywordGroups === null">
              <p>No keyword sets created. Add some!</p>
            </div>
            <div class="v-else">
              <ul class="list-group list-group-flush">
                <li v-for="keywordGroup in keywordGroups" :key="keywordGroup['@id']" class="list-group-item">
                  {{keywordGroup.name}}
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
import axios from "axios";

export default {
  name: "DomainDashboard",
  data() {
    return {
      domain: localStorage.getObject("activeDomain") ?? null,
      keywordGroups:
        localStorage.getObject("activeDomainKeywordGroups") ?? null,
    };
  },
  methods: {
    addNewKeywordGroup: function () {
      addNewKeywordGroup();

      /*
      let keywordGroupName = alert('Enter name');
      if(keywordGroupName.length >= 1 && keywordGroupName.length <= 255) {
        keywordGroup = {'name': keywordGroupName, 'domain': localStorage.getObject("activeDomain")["@id"]}
        axios.post('/api/keyword_groups', keywordGroup);
      } else {
        alert('Invalid length');
      }*/
    },
  },
};
</script>