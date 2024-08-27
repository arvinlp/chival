<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3 offset-9"
        :dynomic="{ name: 'client-route-new' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن خط سیر جدید</h5>
        </template>
      </CardProgress>
      <div class="col-3">
        <b-form-input
          v-model="filter.code"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو براساس کد"
        ></b-form-input>
      </div>
      <div class="col-3 offset-3">
        <b-form-input
          v-model="filter.name"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو براساس نام"
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
          v-if="totalRows > perPage"
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
          <template v-slot:cell(car_type)="data">{{ data.value.name }}</template>
          <template v-slot:cell(travel_type)="data">{{ data.value.name }}</template>
          <template v-slot:cell(status)="data">{{ data.value }}</template>
          <template v-slot:cell(actions)="data">
            <router-link
              :to="{ name: 'client-route-edit', params: { id: data.item.id } }"
              title="ویرایش"
            >
              <i class="fas fa-pencil-alt"></i>
            </router-link>
            <a href="#" v-on:click="deleteItem(data.item.id, data.item.name)" title="حذف">
              <i class="fas fa-trash-alt"></i>
            </a>
          </template>
        </b-table>
      </div>
      <div class="col-12" v-if="totalRows > perPage">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          style="direction: ltr"
          :hide-goto-end-buttons="true"
          :limit="20"
        ></b-pagination>
      </div>
    </div>
    <!-- -->
    <b-modal v-model="modalDelete.show" centered hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalDelete.title }}</h5>
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
            <b-button size="sm" variant="success" @click="deleteItemOK()">{{
              modalDelete.btnOK
            }}</b-button>
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="cancel()">{{
              modalDelete.btnCancel
            }}</b-button>
          </div>
        </div>
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";

export default {
  // name: "DashboardPortal",

  data() {
    return {
      fields: [
        { key: "route_code", label: "کد خط", sortable: true },
        { key: "name", label: "نام خط", sortable: true },
        { key: "car_type", label: "وسیله نقیله", sortable: true },
        { key: "travel_type", label: "سفر", sortable: true },
        { key: "destination.name", label: "مقصد", sortable: false },
        {
          key: "status",
          formatter: "statusType",
          label: "وضعیت استفاده",
          sortable: true,
        },
        {
          key: "actions",
          class: "text-center w-10",
          label: "اقدامات",
          sortable: false,
        },
      ],
      items: null,
      isBusy: false,
      sortBy: "id",
      sortDesc: true,
      sortDirection: "asc",
      filter: {
        name: null,
        code: null,
      },
      filterOn: [],
      totalRows: 0,
      currentPage: 1,
      perPage: 1,

      api: "api/v1/client/routes",

      modalDelete: {
        show: false,
        title: "حذف آیتم",
        content: "آیا حذف این آیتم مطمین هستید ؟",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null,
      },
    };
  },

  components: {
    Body,
    CardProgress,
  },

  computed: {
    isType: function () {
      return this.$store.getters.isType;
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  mounted() {},
  methods: {
    deleteItem(itemID, itemTitle) {
      this.modalDelete.show = true;
      this.modalDelete.title = "« " + itemTitle + " »";
      this.modalDelete.content = "آیا از حذف « " + itemTitle + " » مطمین هستید ؟";
      this.modalDelete.title = "حذف";
      this.modalDelete.content =
        "امکان حذف توسط این آیتم مقدور نمی باشد، جهت حذف با پشتیبانی تماس حاصل فرمایید";
      this.modalDelete.itemID = itemID;
    },
    deleteItemOK() {
      let promise = this.$http.delete(
        this.$api(this.api + "/" + this.modalDelete.itemID)
      );

      this.currentPage = 1;
      this.totalRows = this.totalRows - 1;

      return promise
        .then((response) => {
          this.modalDelete.show = false;
          this.$root.$emit("bv::refresh::table", "table-one");
        })
        .catch((error) => {
          console.error("Delete User Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    myProvider(ctx) {
      let sort = "asc";
      if (ctx.sortDesc) {
        sort = "desc";
      }
      let sortBy = ctx.sortBy;
      if (ctx.sortBy == "name") {
        sortBy = "name";
      }

      let params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;

      if (ctx.filter) {
        if (ctx.filter.name) params += "&name=" + ctx.filter.name;
        if (ctx.filter.code) params += "&route_code=" + ctx.filter.code;
      }

      let promise = this.$http.get(this.$api(this.api + params));

      return promise
        .then((response) => {
          const items = response.data;
          this.totalRows = response.data.total;
          this.perPage = response.data.per_page;
          return items.data;
        })
        .catch((error) => {
          return [];
        })
        .finally(() => (this.loading = false));
    },
    statusType(value) {
      switch (parseInt(value)) {
        case 0:
          return "غیرفعال";
        case 1:
          return "فعال";
        default:
          return "---";
      }
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
};
</script>
