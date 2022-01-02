<template>
  <div>
    <div class="row">
      <h1 v-if="$route.params.keyword_group === undefined">
        All keywords for domain
      </h1>
      <h1 v-else>All keywords in group</h1>
      <small>Click on a keyword to see/edit groups</small>
    </div>
    <hr />
    <div class="row">
      <table
        class="table table-striped table-hover"
        v-if="keywords !== null && keywords.length > 0"
      >
        <thead>
          <tr>
            <th>Keyword</th>
            <th>Amount assigned keyword groups</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="keyword in keywords"
            :key="keyword['@id']"
            @click="editKeyword(keyword)"
            :class="{ pointer: !keyword.locked }"
          >
            <td v-if="keyword.locked === false">{{ keyword.name }}</td>
            <td v-else>{{ keyword.name }} <em>(locked)</em></td>
            <td>{{ keyword.amountKeywordGroups }}</td>
          </tr>
        </tbody>
      </table>
      <h2 v-else>No keywords assigned... :(</h2>
    </div>
  </div>
</template>

<script>
import api from "../lib/api";
export default {
  name: "KeywordList",
  props: ["store"],
  data() {
    return {
      keywords: null,
    };
  },
  async mounted() {
    this.getKeywords();
  },
  methods: {
    editKeyword(keyword) {
      if (!keyword.locked) this.$router.push("/keyword/" + keyword.id);
    },
    /**
     * Update list every 10 seconds
     */
    async getKeywords() {
      if (this.$route.params.keyword_group !== undefined) {
        this.keywords = await api.apiGetAllKeywordsForKeywordGroup(
          this.$route.params.keyword_group
        );
      } else {
        this.keywords = await api.apiGetAllKeywordsForDomain(
          this.store.data.state.activeDomain.id
        );
      }
      setTimeout(this.getKeywords, 10000);
    },
  },
};
</script>