<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-6 col-lg-3 offset-lg-6"
        :url="newUrl"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن وسیله نقلیه جدید</h5>
        </template>
      </CardProgress>
      <CardProgress
        class="col-6 col-lg-3"
        v-if="backUrl"
        :url="backUrl"
        type="default"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">بازگشت به لیست شرکت ها</h5>
        </template>
      </CardProgress>
      <div class="col-6 col-lg-3 offset-lg-6">
        <b-form-input
          v-model="filter"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو در لیست"
        ></b-form-input>
      </div>
      <div class="col-6 col-lg-3">
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
            v-slot:cell(plate)="data"
          >ایران {{data.item.plate_series}} | {{data.item.plate_series_1}} {{data.item.plate_series_2}} {{data.item.plate_series_3}}</template>
          <template v-slot:cell(status)="data">{{data.value}}</template>
          <template v-slot:cell(actions)="data">
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'insurance3')"
              title="بیمه شخص ثالث"
            >
              <i class="fas fa-car-crash"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'insurance1')"
              title="بیمه بدنه"
            >
              <i class="fas fa-car-side"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'technical')"
              title="معاینه فنی"
            >
              <i class="fas fa-car-battery"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'travels')"
              title="تاریخچه سفرها"
            >
              <i class="fas fa-history"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'owners')"
              title="مالکین"
            >
              <i class="fas fa-user-times"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id,data.item.car_card_no,'licence')"
              title="مجوز"
            >
              <i class="fas fa-certificate"></i>
            </a>
            <router-link :to="`${actionUrl}/edit/${data.item.id}`" title="ویرایش">
              <i class="fas fa-car"></i>
            </router-link>
            <a
              href="#"
              v-on:click="deleteItem(data.item.id,`${data.item.plate_series} | ${data.item.plate_series_1} ${data.item.plate_series_2} ${data.item.plate_series_3} به کد ${data.item.car_code}`)"
              title="حذف"
            >
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
    <!-- -->
    <b-modal v-model="modalTable.show" centered size="xl" hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{modalTable.title}}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <div class="page">
          <b-table
            id="table-two"
            :busy.sync="modalIsBusy"
            :items="modalProvider"
            :fields="modalFields"
            :sort-by.sync="modalSortBy"
            :sort-desc.sync="modalSortDesc"
            :filter="modalFilter"
            :filterIncludedFields="modalFilterOn"
            :current-page="modalCurrentPage"
            :per-page="modalPerPage"
            responsive="sm"
          >
            <template v-slot:table-busy>
              <div class="text-center text-danger my-2">
                <b-spinner class="align-middle"></b-spinner>
                <strong>دریافت اطلاعات</strong>
              </div>
            </template>
          </b-table>
        </div>
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../../components/portal/Body";
import CardProgress from "../../../../components/CardProgress";

export default {
  // name: "DashboardPortal",

  data() {
    return {
      fields: [
        {
          key: "car_code",
          label: "شماره وسیله نقلیه",
          class: "align-middle",
          sortable: true
        },
        {
          key: "car_card_no",
          label: "شماره کارت هوشمند",
          class: "align-middle",
          sortable: true
        },
        {
          key: "plate",
          label: "پلاک وسیله نقلیه",
          class: "align-middle",
          sortable: false
        },
        {
          key: "status",
          formatter: "statusType",
          label: "وضعیت اتصال",
          class: "align-middle",
          sortable: true
        },
        {
          key: "actions",
          class: "text-center align-middle w-18",
          label: "اقدامات",
          sortable: false
        }
      ],
      modalFields: null,
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
      actionUrl: null,
      newUrl: null,
      backUrl: null,
      api: null,

      modalSortBy: "id",
      modalSortDesc: false,
      modalSortDirection: "asc",
      modalFilterOn: [],
      modalFilter: null,
      modalItems: null,
      modalApi: null,
      modalMinApi: null,
      modalTotalRows: 0,
      modalCurrentPage: 1,
      modalPerPage: 1,
      modalIsBusy: false,

      modalDelete: {
        show: false,
        title: "حذف آیتم",
        content: "آیا حذف این آیتم مطمین هستید ؟",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null
      },

      modalTable: {
        show: false,
        title: "جدول",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null
      }
    };
  },

  components: {
    Body,
    CardProgress
  },

  computed: {
    isType: function() {
      return this.$store.getters.isType;
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key };
        });
    },
    modalSortOptions() {
      // Create an options list from our fields
      return this.modalFields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key };
        });
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.backUrl = "/portal/companies";
      this.actionUrl =
        "/portal/companies/" + this.$route.params.id + "/vehicles";
      this.newUrl =
        "/portal/companies/" + this.$route.params.id + "/vehicles/new";
      this.api =
        "api/v1/portal/companies/" + this.$route.params.id + "/vehicles";
    } else {
      this.actionUrl = "vehicles";
      this.newUrl = "/portal/vehicles/new";
      this.api = "api/v1/portal/companies/null/vehicles";
    }
  },
  methods: {
    tableShow(itemID, itemTitle, type) {
      this.modalMinApi = this.api + "/" + itemID + "/";
      switch (type) {
        case "insurance1":
          this.modalApi = this.modalMinApi + "body-insurances";
          this.modalTable.title =
            "بیمه نامه های بدنه وسیله نقلیه به شماره کارت هوشمند : " +
            itemTitle;
          this.modalTable.itemID = itemID;
          this.modalFields = [
            { key: 'company.name', label: "شرکت بیمه", class:"text-right w-25"  },
            { key: "code", label: "شماره بیمه نامه", class:"text-center"  },
            { key: "expire_date", label: "انقضا", class:"w-10" }
          ];
          this.modalTable.show = true;
          break;
        case "insurance3":
          this.modalApi = this.modalMinApi + "insurances";
          this.modalTable.show = true;
          this.modalTable.title =
            "بیمه نامه های شخص ثالث وسیله نقلیه به شماره کارت هوشمند : " +
            itemTitle;
          this.modalFields = [
            { key: 'company.name', label: "شرکت بیمه", class:"text-right w-25"  },
            { key: "code", label: "شماره بیمه نامه", class:"text-center"  },
            { key: "expire_date", label: "انقضا", class:"w-10" }
          ];
          this.modalTable.itemID = itemID;
          break;
        case "technical":
          this.modalApi = this.modalMinApi + "technical-diagnoses";
          this.modalTable.title =
            "معاینه فنی های وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalTable.itemID = itemID;
          this.modalFields = [
            { key: "code", label: "شماره معاینه فنی", class:"text-right"  },
            { key: "expire_date", label: "انقضا", class:"w-10" }
          ];
          this.modalTable.show = true;
          break;
        case "owners":
          this.modalApi = this.modalMinApi + "owners";
          this.modalTable.show = true;
          this.modalTable.title =
            "مالکین وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalTable.itemID = itemID;
          break;
        case "travels":
          this.modalApi = this.modalMinApi + "body-insurances";
          this.modalTable.show = true;
          this.modalTable.title =
            "سفرهای ثبت شده وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalTable.itemID = itemID;
          break;
        default:
          break;
      }
    },
    deleteItem(itemID, itemTitle) {
      this.modalDelete.show = true;
      this.modalDelete.title = "« " + itemTitle + " »";
      this.modalDelete.content =
        "آیا از حذف « " + itemTitle + " » مطمین هستید ؟";
      this.modalDelete.itemID = itemID;
    },
    deleteItemOK() {
      let promise = this.$http.delete(
        this.$api(this.api + "/" + this.modalDelete.itemID)
      );

      this.currentPage = 1;
      this.totalRows = this.totalRows - 1;

      return promise
        .then(response => {
          this.modalDelete.show = false;
          this.$root.$emit("bv::refresh::table", "table-one");
        })
        .catch(error => {
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
      let params =
        "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;
      if (ctx.filter) {
        params =
          "?page=" +
          ctx.currentPage +
          "&order_by=" +
          sortBy +
          "&order=" +
          sort +
          "&name=" +
          ctx.filter;
      }

      let promise = this.$http.get(this.$api(this.api + params));

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
    modalProvider(ctx) {
      let sort = "asc";
      if (ctx.sortDesc) {
        sort = "desc";
      }
      let sortBy = ctx.sortBy;
      if (ctx.sortBy == "name") {
        sortBy = "name";
      }
      let params =
        "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;
      if (ctx.filter) {
        params =
          "?page=" +
          ctx.currentPage +
          "&order_by=" +
          sortBy +
          "&order=" +
          sort +
          "&name=" +
          ctx.filter;
      }

      let promise = this.$http.get(this.$api(this.modalApi + params));

      return promise
        .then(response => {
          const modalItems = response.data;
          this.modalTotalRows = response.data.total;
          this.modalPerPage = response.data.per_page;
          return modalItems.data;
        })
        .catch(error => {
          console.error("Dashboard Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    statusType(value) {
      switch (parseInt(value)) {
        case 3:
          return "نامشخص";
        case 0:
          return "خارج از دسترس";
        case 1:
          return "در حال ارائه سرویس";
        case 2:
          return "در حال بررسی اطلاعات";
        default:
          return "---";
      }
    },
    modalStatusType(value) {
      switch (parseInt(value)) {
        case 3:
          return "نامشخص";
        case 0:
          return "خارج از دسترس";
        case 1:
          return "در حال ارائه سرویس";
        case 2:
          return "در حال بررسی اطلاعات";
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

