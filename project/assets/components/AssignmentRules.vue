<template>
  <div>
    <div class="row">
      <h1>Assignment Rules</h1>
    </div>
    <hr />
    <div class="row">
      <div class="accordion" v-if="keywordGroups.length > 0">
        <div
          v-for="keywordGroup in keywordGroups"
          :key="keywordGroup['@id']"
          class="accordion-item col-12"
        >
          <h2 class="accordion-header">
            <button
              class="accordion-button d-flex justify-content-between collapsed"
              type="button"
              data-bs-toggle="collapse"
              :data-bs-target="'#collapse' + keywordGroup.id"
            >
              <span class="flex-grow-1">{{ keywordGroup.name }}</span>
              <button
                class="btn btn-secondary mx-4"
                @click="addNewRule(keywordGroup)"
              >
                Add new
              </button>
            </button>
          </h2>
          <div
            :id="'collapse' + keywordGroup.id"
            class="accordion-collapse collapse"
          >
            <div class="accordion-body">
              <div v-if="keywordGroup.assignmentRules.length > 0">
                <ul class="list-group">
                  <li
                    v-for="rule in keywordGroup.assignmentRules"
                    :key="rule['@id']"
                    class="list-group-item d-flex justify-content-between"
                  >
                    <span class="flex-grow-1">{{ rule.regexPattern }}</span>
                    <i @click="deleteRule(rule)" class="bi bi-trash-fill"></i>
                  </li>
                </ul>
              </div>
              <div v-else>
                <span>No rule yet.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <h2 v-else>Add some keyword groups in the Dashboard first!</h2>
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
    this.loadKeywordGroups();
  },
  methods: {
    /**
     * Show dialog to enter new assignment rule and post to API
     */
    addNewRule: function (keywordGroup) {
      let regexPattern = prompt("Enter new rule (any valid PHP regex)");

      //cancel event
      if (regexPattern === null) {
        return;
      }

      if (regexPattern.length >= 1 && regexPattern.length <= 500) {
        //create object for post
        let assignmentRule = {
          regexPattern: regexPattern,
          keywordGroup: keywordGroup["@id"],
        };
        //post object
        api
          .apiPostRule(assignmentRule)
          .then(this.loadKeywordGroups())
          .catch((error) => {
            if (error.response) {
              alert(
                "Could not create rule. Invalid regex? (see console log for details)"
              );
              console.log(error);
            }
          });
      } else {
        alert("Invalid length");
      }
    },
    deleteRule: function (rule) {
      if (confirm("Are you sure you want to delete this rule?")) {
        api.apiDeleteRule(rule.id).then(() => this.loadKeywordGroups());
      }
    },
    loadKeywordGroups: async function () {
      this.keywordGroups = await api.apiGetKeywordGroupsForDomain(
        this.store.data.state.activeDomain.id
      );
    },
  },
};
</script>