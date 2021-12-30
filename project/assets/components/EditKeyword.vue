<template>
  <div>
    <div class="row">
      <h1 class="col-12">"{{ keyword === null ? "" : keyword.name }}"</h1>
    </div>
    <hr />
    <div class="row">
      <h2 class="col-12">Edit keyword groups</h2>
    </div>
    <div class="row justify-content-center">
      <button
        class="btn col-md-auto m-1"
        v-for="keywordGroup in keywordGroups"
        :key="keywordGroup['@id']"
        @click="toggleGroupActive(keywordGroup)"
        :class="[
          keywordGroup.active == 1 ? 'btn-secondary' : 'btn-outline-secondary',
        ]"
      >
        {{ keywordGroup.name }}
      </button>
    </div>
    <div class="row mt-5">
      <button class="btn btn-primary" @click="sortNextKeyword">Next</button>
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
  methods: {
    //add or remove to/from clicked keywordGroup
    toggleGroupActive(keywordGroup) {
      //better check for 0 and 1 in case it's undefined for some reason
      if (keywordGroup.active === 0) {
        //append keywordGroup to array
        this.keyword.keywordGroups.push(keywordGroup["@id"]);
      } else if (keywordGroup.active === 1) {
        //remove keywordGroup from array
        this.keyword.keywordGroups = this.keyword.keywordGroups.filter(
          (el) => el !== keywordGroup["@id"]
        );
      }

      let update = { keywordGroups: [] };
      this.keyword.keywordGroups.forEach((el) => {
        update.keywordGroups.push(el);
      });
      api.apiPutKeyword(this.keyword.id, update).then(() => {
        this.keywordGroups.forEach((el) => {
          if (el.id === keywordGroup.id) {
            el.active = el.active === 1 ? 0 : 1;
          }
        });
      });
    },
    //switch to next keyword on button click
    sortNextKeyword: async function () {
      let keywordId = await api.apiGetFirstUnsortedKeywordForDomain(
        this.store.data.state.activeDomain.id
      );
      this.loadKeyword(keywordId);
      //don't attempt to change route if unchanged (avoids debug error)
      if (this.$route.path != "/keyword/" + keywordId) {
        this.$router.push("/keyword/" + keywordId);
      }
    },
    //load a new keyword in
    loadKeyword: async function (keywordId) {
      //array with both promises in them
      let promises = [];
      let keyword = await api.apiGetKeyword(keywordId);
      promises.push(keyword);
      let keywordGroups = await api.apiGetKeywordGroupsForDomain(
        this.store.data.state.activeDomain.id
      );
      promises.push(keywordGroups);
      this.keyword = keyword;
      this.keywordGroups = keywordGroups;
      //add 'active' to all groups after promises are resolved
      Promise.all(promises).then(() => {
        this.keywordGroups.forEach((group) => {
          let id = group["@id"];
          // this.$set is required for making the new property reactive;
          // simply doing 'group.active = 0' won't do it.
          // Took me forever to figure out....
          this.$set(group, "active", 0);
          this.keyword.keywordGroups.forEach((keyword) => {
            if (keyword === id) {
              group.active = 1;
            }
          });
        });
        //lock keyword for 60 seconds
        api.apiLockKeyword(this.keyword.id)
      });
    },
  },

  //load domain from route
  async mounted() {
    this.loadKeyword(this.$route.params.keyword);
  },
};
</script>