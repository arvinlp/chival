<template>
  <section class="page">
    <div class="row">
      <div class="col-3">
        <b-form-input
          v-model="filter"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو در لیست"
        ></b-form-input>
      </div>
      <div class="col-5 offset-1">
        <div v-if="!selectedUser" class="row">
          <div class="col-10">
            <multiselect
              v-model="selectedUser"
              :custom-label="selectCustomLabel"
              track-by="id"
              placeholder="با انتخاب کاربر لیست را فیلتر کنید."
              open-direction="bottom"
              :options="users"
              :multiple="false"
              :searchable="true"
              :loading="isLoading"
              selectLabel
              selectedLabel="انتخاب شده"
              deselectLabel="حذف انتخاب"
              @select="onSelectUser"
              @change="onSelectUser"
            >
              <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
            </multiselect>
          </div>
        </div>
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
          ><div v-if="data.item.chival_user_history">{{ data.item.chival_user_history.fname }} {{ data.item.chival_user_history.lname }}</div></template>
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
        { key: "name", label: "عنوان", sortable: true },
        { key: "content", label: "توضیحات", sortable: true },
        { key: "created_at", label: "ساعت و تاریخ", sortable: true }
      ],
      items: null,
      isBusy: false,
      sortBy: "id",
      sortDesc: true,
      sortDirection: "asc",
      filter: null,
      filterOn: [],
      totalRows: 0,
      currentPage: 1,
      perPage: 1,

      ctx: null,
      users: [],
      selectedUser: 0,
      isLoading: false
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
  mounted() {
    if (this.$route.params.id) {
      this.selectedUser = this.$route.params.id;
    } else {
      this.getUsers();
    }
  },
  methods: {
    onSelectUser(value) {
      if (value) this.selectedUser = value.id;
      else this.selectedUser = 0;
      this.$root.$emit("bv::refresh::table", "table-one");
    },
    getUsers() {
      let promise = this.$http.get(this.$api("api/v1/portal/users/list"));
      return promise
        .then(response => {
          this.users = response.data;
          return response.data;
        })
        .catch(error => {
          this.users = [{ id: 0, fname: "فیلنر براساس کاربر", lname: "" }];
          return [{ id: 0, fname: "فیلنر براساس کاربر", lname: "" }];
        });
    },
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
      if (ctx.sortBy == "content") {
        sortBy = "content";
      }
      if (ctx.sortBy == "name") {
        sortBy = "user_id";
      }
      let user_id = "";
      if (this.selectedUser > 0) {
        user_id = "&user_id=" + this.selectedUser;
      }
      if (this.selectedUser.id > 0) {
        user_id = "&user_id=" + this.selectedUser.id;
      }
      let params =
        "?user_type=admin&page=" +
        ctx.currentPage +
        "&order_by=" +
        sortBy +
        "&order=" +
        sort +
        user_id;
      if (ctx.filter) {
        params =
          "?user_type=admin&page=" +
          ctx.currentPage +
          "&order_by=" +
          sortBy +
          "&order=" +
          sort +
          user_id +
          "&personal_name=" +
          ctx.filter;
      }
      let promise = this.$http.get(
        this.$api("api/v1/portal/users/logs" + params)
      );
      console.error(this.$api("api/v1/portal/users/logs" + params));

      return promise
        .then(response => {
          const items = response.data;
          this.totalRows = response.data.total;
          this.perPage = response.data.per_page;
          return items.data;
        })
        .catch(error => {
          console.error("Dashboard Error : " + error);
          this.totalRows = 0;
          this.perPage = 0;
          return [];
        })
        .finally(() => (this.loading = false));
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    selectCustomLabel({ fname, lname }) {
      if (fname && lname) return `${fname} ${lname}`;
      return "فیلتر براساس پرسنل";
    }
  }
};
</script>

