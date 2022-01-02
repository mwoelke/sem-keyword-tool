<template>
  <div>
    <div class="row">
      <div class="col-10">
        <h1>Domains</h1>
        <small>Choose a domain</small>
      </div>
      <div class="col-2 align-self-end">
        <button class="btn btn-secondary float-end m-t-2" @click="addNewDomain">
          Add new
        </button>
      </div>
    </div>
    <hr />
    <div class="row">
      <ul class="list-group" v-if="store.data.domains.length > 0">
        <li
          class="list-group-item p-3 fs-5 pointer"
          v-for="domain in store.data.domains"
          :key="domain['@id']"
          @click="setActiveDomain(domain)"
          :class="[activeDomainId == domain.id ? 'active' : '']"
        >
          <span>{{ domain.name }}</span>
        </li>
      </ul>
      <h2 v-else>Nothing here yet... Add a domain!</h2>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ListDomains",
  props: ["store"],
  data() {
    return {
      activeDomainId: this.store.data.state.activeDomain?.id
    };
  },
  //async mounted() {
    //get all domains and save result data in var 'domains'
  //  this.domains = await api.apiGetAllDomains();
  //},
  methods: {
    //set clicked domain to active domain
    setActiveDomain: function (domain) {
      this.store.data.setActiveDomain(domain);
      this.activeDomainId = domain.id
    },
    //add a new domain, on button click
    addNewDomain: function () {
      //enter domain
      let domainName = prompt("Enter Domain");
      //check if valid domain. Regex shamelessly ripped from
      //https://regexr.com/3au3g
      //Note: Subdomains are different domains on purpose!
      if (
        domainName !== undefined &&
        /^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/.test(
          domainName
        )
      ) {
        //post domain to api and refetch domains
        axios.post("/api/domains", { name: domainName }).then(() => {
          this.store.data.loadDomains()
        });
      } else {
        //show error
        alert("Invalid domain");
      }
    },
  },
};
</script>