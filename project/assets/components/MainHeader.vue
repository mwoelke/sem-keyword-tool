<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2">
    <div class="container-fluid">
      <h1 class="navbar-brand m-0">
        <template
          v-if="
            store.state.activeDomain !== null &&
            store.state.activeDomain.name !== null
          "
        >
          {{ store.state.activeDomain.name }}
        </template>
        <template v-else>SEM Keyword Tool</template>
      </h1>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <template v-if="store.state.activeDomain !== null">
            <li class="nav-item">
              <router-link
                class="nav-link"
                :class="[$route.path == '/dashboard' ? 'active' : '']"
                to="/dashboard"
                >Dashboard</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link"
                :class="[$route.path == '/keywords' ? 'active' : '']"
                to="/keywords"
                >Keywords</router-link
              >
            </li>
            <li class="nav-item">
              <router-link
                class="nav-link"
                :class="[$route.path == '/rules' ? 'active' : '']"
                to="/rules"
                >Rules</router-link
              >
            </li>
          </template>
          <li class="nav-item">
            <router-link
              class="nav-link"
              :class="[$route.path == '/domains' ? 'active' : '']"
              to="/domains"
              >Switch Domain</router-link
            >
          </li>
          <li class="nav-item">
            <router-link
              class="nav-link"
              :class="[$route.path == '/import' ? 'active' : '']"
              to="/import"
              >Import Keywords</router-link
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/logout">Logout</a>
          </li>
        </ul>
      </div>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0"></ul>
    </div>
  </nav>
</template>

<script>
import Store from "../lib/store";
export default {
  name: "MainHeader",
  data() {
    return {
      store: Store.data,
      name: Store.data.state.activeDomain?.name ?? 1,
    };
  },
};
</script>