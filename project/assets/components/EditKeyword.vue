<template>
  <div>
      <div class="row">
          <h1 class="col-12">{{store.data.state.activeDomain.name}}</h1>
      </div>
      <hr>
      <div class="row">
          <h2 class="col-12">Edit keyword groups</h2>
      </div>
      <div class="row">
          <button class="btn btn-outline-secondary"  v-for="keywordGroup in keywordGroups" :key="keywordGroup['@id']">{{keywordGroup.name}}</button>
      </div>

  </div>
</template>

<script>
import api from "../lib/api";
export default {
  name: "EditKeyword",
  props: ["store"],
  data() {
    return {
      keyword: null,
      keywordGroups: null,
    };
  },
  async mounted() {
    this.keyword = await api.apiGetKeyword(this.$route.params.keyword);
    this.keywordGroups = await api.apiGetKeywordGroupsForDomain(
      this.store.data.state.activeDomain.id
    );
    console.log(api.apiLockKeyword(this.keyword.id));
  },
};
</script>