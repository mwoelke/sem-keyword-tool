<template>
  <div>
    <div class="row">
      <h1 v-if="$route.params.keyword_group === undefined">
        All keywords for domain
      </h1>
      <h1 v-else>All keywords in group</h1>
    </div>
    <hr />
    <div class="row">
      <table class="table table-striped table-hover">
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
            class="pointer"
          >
            <td>{{ keyword.name }}</td>
            <td>{{ keyword.amountKeywordGroups }}</td>
          </tr>
        </tbody>
      </table>
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
    if (this.$route.params.keyword_group !== undefined) {
      this.keywords = await api.apiGetAllKeywordsForKeywordGroup(
        this.$route.params.keyword_group
      );
    } else {
      this.keywords = await api.apiGetAllKeywordsForDomain(
        this.store.data.state.activeDomain.id
      );
    }
  },
  methods: {
    editKeyword(keyword) {
      this.$router.push("/keyword/" + keyword.id);
    },
  },
};
</script>