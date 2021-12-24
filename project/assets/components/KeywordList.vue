<template>
  <div>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th>Keyword</th>
            <th>In x keyword groups</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="keyword in keywords" :key="keyword['@id']">
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
        $route.parms.keyword_group,
        1
      );
    } else {
      this.keywords = await api.apiGetAllKeywordsForDomain(
        this.store.data.state.activeDomain.id,
        1
      );
    }
  },
  methods: {},
};
</script>