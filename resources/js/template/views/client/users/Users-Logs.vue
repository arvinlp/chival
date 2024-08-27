<template>
  <section class="page">
    <div class="row">
      <div class="col-3 offset-4">
        <b-form-input
          v-model="filter"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو در لیست"
        ></b-form-input>
      </div>

      <div class="col-3">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          :hide-goto-end-buttons="true"
          :limit="3"
          v-if="totalRows>perPage"
        ></b-pagination>
      </div>
      <b-col cols="2">
        <b-button :to="{name: 'client-users'}" variant="reset" class="mt-3">
          بازگشت به لیست پرسنل
        </b-button>
      </b-col>
      <div class="col-12">
        <b-table
          id="table-one"
          :busy.sync="isBusy"
          :items="myProvider"
          :fields="fields"
          :sort-by.sync="sortBy"
          :sort-desc.sync="sortDesc"
          :filter="filter"
          :filterIncludedFields="filterOn"
          :current-page="currentPage"
          :per-page="perPage"
          responsive="sm"
        >
          <template v-slot:table-busy>
            <div class="text-center text-danger my-2">
              <b-spinner class="align-middle"></b-spinner>
              <strong>دریافت اطلاعات</strong>
            </div>
          </template>
          <template
            v-slot:cell(name)="data"
          >{{ data.item.company_user_history.fname }} {{ data.item.company_user_history.lname }}</template>
        </b-table>
      </div>
      <div class="col-12" v-if="totalRows>perPage">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          style="direction:ltr"
          :hide-goto-end-buttons="true"
          :limit="20"
        ></b-pagination>
      </div>
    </div>
  </section>
</template>

<script>
import Body from "../../../components/portal/Body";
import CardProgress from "../../../components/CardProgress";

import Dropdown from "vue-simple-search-dropdown";
export default {
  // name: "DashboardPortal",

  data() {
    return {
      fields: [
        { key: "content", label: "توضیحات", sortable: false },
        { key: "created_at", label: "ساعت و تاریخ", sortable: true }
      ],
      items: null,
      isBusy: false,
      sortBy: "created_at",
      sortDesc: true,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      totalRows: 0,
      currentPage: 1,
      perPage: 1,

      ctx: null,
      isLoading: false,
      api:null,

    };
  },

  components: {
    Body,
    Dropdown,
    CardProgress
  },

  computed: {
    isType: function() {
      return this.$store.getters.isType;
    }
  },
  created() {
    this.api = "api/v1/client/users/"+this.$route.params.id+"/logs"
  },
  mounted() {
    if (!this.$route.params.id) {
      this.$router.push(this.$route.query.redirect || '/404');
    }
  },
  methods: {
    myProvider(ctx) {
      if (ctx != null) {
        this.ctx = ctx;
      }

      let sort = "asc";
      if (ctx.sortDesc) {
        sort = "desc";
      }
      let sortBy = ctx.sortBy;
      if (ctx.sortBy == "created_at") {
        sortBy = "created_at";
      }
      let params =
        "?page=" +
        ctx.currentPage +
        "&order_by=" +
        sortBy +
        "&order=" +
        sort ;
      if (ctx.filter) {
        params =
          "?page=" +
          ctx.currentPage +
          "&order_by=" +
          sortBy +
          "&order=" +
          sort +
          filtered +
          "&content=" +
          ctx.filter;
      }
      let promise = this.$http.get(this.$api(this.api + params));
      console.error(this.$api(this.api + params))
      return promise
        .then(response => {
          const items = response.data;
          this.totalRows = response.data.total;
          this.perPage = response.data.per_page;
          return items.data;
        })
        .catch(error => {
          console.error("Dashboard Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  }
};
</script>

