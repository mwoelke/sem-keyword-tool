<template>
  <div>
    <div v-if="success !== null" class="row">
      <div class="col-12">
        <div class="alert alert-info">
          Added {{success}} new keywords, error on {{failure}} keywords
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <h1>Import CSV</h1>
      </div>
    </div>
    <hr />
    <vue-csv-import
      :map-fields="{ domain: 'Domain', keyword: 'Keyword' }"
      :autoMatchFields="true"
      :autoMatchIgnoreCase="true"
      v-model="csv"
    >
      <template slot="thead">
        <tr>
          <th>Field</th>
          <th>Column</th>
        </tr>
      </template>

      <template slot="next" slot-scope="{ load }">
        <button class="btn btn-primary mt-2" @click.prevent="load">Load</button>
      </template>
    </vue-csv-import>
    <template v-if="csv !== null">
      <button class="btn btn-primary" @click="submitCsv">Send</button>
    </template>
  </div>
</template>

<script>
import { VueCsvImport } from "vue-csv-import";
import api from "../lib/api";

export default {
  name: "Import",
  components: { VueCsvImport },
  props: ["store"],
  data() {
    return {
      csv: null,
      success: null,
      failure: null
    };
  },
  methods: {
    submitCsv: function () {
      let success = 0;
      let failure = 0;
      if (this.csv === null) {
        alert("Please import file first");
        return;
      }
      let promises = [];
      this.csv.forEach((element) => {
        let id = null;
        this.store.data.domains.forEach((domain) => {
          if (domain.name == element.domain) {
            id = domain["@id"];
          }
        });
        if (id !== undefined && id !== null) {
          promises.push(
            api
              .apiPostKeyword({
                name: element.keyword,
                domain: id,
              })
              .then(() => success++)
              .catch((error) => {
                if (error.response) {
                  failure++;
                  console.log(error);
                }
              })
          );
        }
      });
      //reload domains after all promises are solvedsch
      Promise.all(promises).then(() => {
        this.store.data.loadDomains();
        this.success = success;
        this.failure = failure;
      });
    },
  },
};
</script>