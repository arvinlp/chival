<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3 offset-9"
        url="/portal/work-times/new"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن شیفت کاری جدید</h5>
        </template>
      </CardProgress>
      <!-- -->
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
        <div class="row">
          <div class="col-7">
            <Dropdown
              :options="companies"
              v-on:selected="validateSelection"
              v-on:filter="getDropdownValues"
              v-model="filter"
              placeholder="فیلتر براساس شرکت"
            ></Dropdown>
          </div>
          <div class="col-5 mt-2" v-if="selectedCompany > 0">
            <b-button variant="primary" class="w-100" @click="onClickBtn">نمایش اطلاعات عمومی</b-button>
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
          <template v-slot:cell(week)="data">{{ data.value }}</template>
          <template v-slot:cell(status)="data">{{data.value}}</template>
          <template v-slot:cell(actions)="data">
            <router-link :to="{name: 'portal-work-times-edit', params: { id: data.item.id }}">
              <i class="fas fa-pencil-alt"></i>
            </router-link>
            <a href="#" v-on:click="deleteItem(data.item.id,data.item.name)">
              <i class="fas fa-trash-alt"></i>
            </a>
          </template>
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
    <!-- -->
    <b-modal v-model="modalDelete.show" centered>
      <template v-slot:modal-header="{ close }">
        <h5>{{modalDelete.title}}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <p v-html="modalDelete.content"></p>
      </template>

      <template v-slot:modal-footer="{ cancel }">
        <div>
          <div class="text-right">
            <b-button size="sm" variant="success" @click="deleteItemOK()">{{modalDelete.btnOK}}</b-button>
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="cancel()">{{modalDelete.btnCancel}}</b-button>
          </div>
        </div>
      </template>
    </b-modal>
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
        { key: "week", formatter: "day", label: "روز", sortable: true },
        { key: "start", label: "ساعت شروع", sortable: true },
        { key: "end", label: "ساعت پایان", sortable: true },
        { key: "type", label: "نوع کاربری", sortable: true },
        {
          key: "status",
          formatter: "statusType",
          label: "وضعیت استفاده",
          sortable: true
        },
        { key: "actions", label: "اقدامات", sortable: false }
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
      companies: [],
      selectedCompany: 0,

      modalDelete: {
        show: false,
        title: "حذف آیتم",
        content: "آیا حذف این آیتم مطمین هستید ؟",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null
      }
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
    this.getCompanies(null);
  },
  methods: {
    deleteItem(itemID, itemTitle) {
      this.modalDelete.show = true;
      this.modalDelete.title = "« " + itemTitle + " »";
      this.modalDelete.content =
        "آیا از حذف « " + itemTitle + " » مطمین هستید ؟";
      this.modalDelete.itemID = itemID;
    },
    deleteItemOK() {
      let promise = this.$http.delete(
        this.$api("api/v1/portal/worktimes/" + this.modalDelete.itemID)
      );

      this.currentPage = 1;
      this.totalRows = this.totalRows - 1;

      return promise
        .then(response => {
          this.modalDelete.show = false;
          this.$root.$emit("bv::refresh::table", "table-one");
        })
        .catch(error => {
          console.error("Delete WT Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    onClickBtn() {
      this.selectedCompany = 0;
      this.$root.$emit("bv::refresh::table", "table-one");
    },
    validateSelection(selection) {
      this.selectedCompany = selection.id;
      this.$root.$emit("bv::refresh::table", "table-one");
    },
    getDropdownValues(keyword) {
      this.getCompanies(keyword);
    },
    getCompanies(serach) {
      let params = "";
      if (serach) params = "?name=" + serach;
      let promise = this.$http.get(
        this.$api("api/v1/portal/companies/list" + params)
      );

      return promise
        .then(response => {
          const companies = response.data;
          this.companies = companies;
          return companies;
        })
        .catch(error => {
          return [{ id: "0", name: "شرکتی یافت نشد" }];
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
      if (ctx.sortBy == "status") {
        sortBy = "status";
      }
      if (ctx.sortBy == "name") {
        sortBy = "name";
      }
      if (ctx.sortBy == "start") {
        sortBy = "start";
      }
      if (ctx.sortBy == "end") {
        sortBy = "end";
      }
      if (ctx.sortBy == "week") {
        sortBy = "week";
      }
      if (ctx.sortBy == "type") {
        sortBy = "type";
      }
      let compnay_id = "";
      if (this.selectedCompany > 0) {
        compnay_id = "&company_id=" + this.selectedCompany;
      }
      let params =
        "?page=" +
        ctx.currentPage +
        "&order_by=" +
        sortBy +
        "&order=" +
        sort +
        compnay_id;
      if (ctx.filter) {
        params =
          "?page=" +
          ctx.currentPage +
          "&order_by=" +
          sortBy +
          "&order=" +
          sort +
          compnay_id +
          "&name=" +
          ctx.filter;
      }

      let promise = this.$http.get(
        this.$api("api/v1/portal/worktimes" + params)
      );

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
    statusType(value) {
      switch (parseInt(value)) {
        case 0:
          return "خارج از دسترس";
        case 1:
          return "در دسترس";
        case 2:
          return "مسدود شده";
        default:
          return "---";
      }
    },
    day(value) {
      switch (parseInt(value)) {
        case 1:
          return "شنبه";
        case 2:
          return "یکشنبه";
        case 3:
          return "دوشنبه";
        case 4:
          return "سه شنبه";
        case 5:
          return "چهارشنبه";
        case 6:
          return "پنجشنبه";
        case 7:
          return "جمعه";
        default:
          return "---";
      }
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    }
  }
};
</script>

