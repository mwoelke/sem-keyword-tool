<template>
  <div>
      8=============D
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
    };
  },
  async mounted() {
    this.keyword = await api.apiGetKeyword(this.$route.params.keyword);
    api.apiLockKeyword(this.keyword.id);
  }
};
</script>