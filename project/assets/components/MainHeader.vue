<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2">
    <h1 class="navbar-brand m-0">{{ activeDomainName }}</h1>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div v-if="activeDomainId !== undefined" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <router-link class="nav-link" to="/dashboard">Dashboard</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/keywords">Keywords</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/keywordgroups"
            >Keyword Groups</router-link
          >
        </li>
      </ul>
    </div>
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item"></li>
      <router-link class="nav-link" to="/domains">Switch Domain</router-link>
      <li class="nav-item">
        <a class="nav-link" href="/logout">Logout</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "MainHeader",
  data() {
    return {
      get activeDomainId() {
        return localStorage.activeDomainId !== null
          ? localStorage.activeDomainId
          : 0;
      },
      get activeDomainName() {
        return localStorage.activeDomainName !== null
          ? localStorage.activeDomainName
          : 0;
      },
    };
  },
  mounted() {
    //check if activeDomain is set in localStorage
    if (
      localStorage.activeDomain !== null &&
      localStorage.activeDomainName !== null
    ) {
      //set local vars to vars from localStorage
      this.activeDomainId = localStorage.activeDomainId;
      this.activeDomainName = localStorage.activeDomainName;
    }
  },
};
</script>