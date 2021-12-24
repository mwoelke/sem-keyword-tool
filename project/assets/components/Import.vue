<template>
  <div>
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
import helper from "../lib/helper";
import api from "../lib/api";

export default {
  name: "Import",
  components: { VueCsvImport },
  props: ["store"],
  data() {
    return {
      csv: null,
    };
  },
  methods: {
    submitCsv: function () {
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
          promises.push(api.apiPostKeyword({
            name: element.keyword,
            domain: id
          }).catch(() => {console.log()}));
        }
      });
      console.log(promises);
      //reload domains after all promises are solved
      Promise.all(promises).then(() => {this.store.data.loadDomains()});
    },
  },
};
</script>