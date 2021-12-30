<template>
  <div>
    <div class="row">
      <h1>Assignment Rules</h1>
    </div>
    <hr />
    <div class="row">
      <div class="accordion">
        <div
          v-for="keywordGroup in keywordGroups"
          :key="keywordGroup['@id']"
          class="accordion-item col-12"
        >
          <h2 class="accordion-header">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              :data-bs-target="'#collapse' + keywordGroup.id"
            >
              {{ keywordGroup.name }}
            </button>
          </h2>
          <div
            :id="'collapse' + keywordGroup.id"
            class="accordion-collapse collapse"
          >
            <div class="accordion-body">
              <div class="row">
                <div class="col-10">
                  <div v-if="keywordGroup.assignmentRules.length > 0"></div>
                  <div v-else>
                    <span>No rule yet.</span>
                  </div>
                </div>
                <div class="col-2 align-self-end">
                  <button @click="addNewRule" class="btn btn-secondary float-end">Add new</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../lib/api";

export default {
  name: "AssignmentRules",
  props: ["store"],
  data() {
    return {
      keywordGroups: null,
    };
  },
  async mounted() {
    this.keywordGroups = await api.apiGetKeywordGroupsForDomain(
      this.store.data.state.activeDomain.id
    );
  },
  methods: {
      addNewRule: function() {
          
      }
  },
};
</script>