<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3"
        :dynomic="{ name: 'client-driver-new' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن راننده جدید</h5>
        </template>
      </CardProgress>
      <CardProgress
        class="col-3 offset-6"
        :dynomic="{ name: 'client-partnear-drivers' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">رانندگان شرکت همکاران</h5>
        </template>
      </CardProgress>
      <div class="col-3">
        <b-form-input
          v-model="filter.code"
          type="text"
          class="search-in-table"
          id="filterCode"
          placeholder="جستجو براساس کد"
        ></b-form-input>
      </div>
      <div class="col-3">
        <b-form-input
          v-model="filter.nationCode"
          type="text"
          class="search-in-table"
          id="filterCode"
          placeholder="جستجو براساس کد ملی"
        ></b-form-input>
      </div>
      <div class="col-3">
        <b-form-input
          v-model="filter.mobile"
          type="search"
          class="search-in-table"
          id="filterMobile"
          placeholder="جستجو براساس موبایل"
        ></b-form-input>
      </div>
      <div class="col-3">
        <b-form-input
          v-model="filter.name"
          type="search"
          class="search-in-table"
          id="filterName"
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
          <template v-slot:cell(personal_name)="data"
            >{{ data.item.fname }} {{ data.item.lname }}</template
          >
          <template v-slot:cell(status)="data">{{ data.value }}</template>
          <template v-slot:cell(actions)="data">
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'book-times'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="دفترچه ثبت ساعت"
            >
              <i class="fas fa-sticky-note"></i>
            </a>
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'contracts'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="قراردادها"
            >
              <i class="fas fa-book"></i>
            </a>
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'destenations'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="مقاصد"
            >
              <i class="fas fa-history"></i>
            </a>
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'vehicles'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="وسایل نقلیه"
            >
              <i class="fas fa-car"></i>
            </a>
            <a
              href="#"
              v-on:click="
                printInfo(data.item.id, `${data.item.fname} ${data.item.lname}`)
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="پرینت اطلاعات"
            >
              <i class="fas fa-print"></i>
            </a>
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'records'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="گزارشات"
            >
              <i class="fas fa-notes-medical"></i>
            </a>
            <a
              href="#"
              v-on:click="
                tableShow(
                  data.item.id,
                  `${data.item.fname} ${data.item.lname}`,
                  'license'
                )
              "
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="مجوز"
            >
              <i class="fas fa-user-nurse"></i>
            </a>
            <router-link
              :to="{ name: 'client-driver-edit', params: { id: data.item.id } }"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="ویرایش"
            >
              <i class="fas fa-user-edit"></i>
            </router-link>
            <a
              href="#disable"
              v-b-tooltip.hover="{ variant: 'primary' }"
              v-on:click="
                deleteItem(
                  data.item.id,
                  `${data.item.plate_series} | ${data.item.plate_series_1} ${data.item.plate_series_2} ${data.item.plate_series_3} به کد ${data.item.car_code}`
                )
              "
              title="حذف"
            >
              <i class="fas fa-user-slash"></i>
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

    <!-- -->
    <b-modal :id="modalDriverHandler.id" v-model="modalDriverHandler.show" centered size="xl" hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalDriverHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <ModalHandler
          :modalID="modalDriverHandler.id"
          :modalType="modalDriverHandler.type"
          :modalApi="modalDriverHandler.api"
          :modalFields="modalDriverHandler.fields"
          :parentID="modalDriverHandler.itemID"
          :modalSortBy="modalDriverHandler.sortBy"
          :modalSortType="modalDriverHandler.sortType"
          :modalFormHandler="modalDriverHandler.formShow"
          :modalTableHandler="modalDriverHandler.tableShow"
        />
      </template>
    </b-modal>

    <!-- -->
    <b-modal v-model="modalPrintHandler.show" centered size="xl" hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalPrintHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <PrintDriverInfo :itemID="modalPrintHandler.itemID"/>
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
import PrintDriverInfo from "../../../components/PrintDriverInfo";
import ModalHandler from "../../../components/modal-forms/driver/BaseModalHandler";

export default {
  // name: "DashboardPortal",

  data() {
    return {
      fields: [
        {
          key: "driver_code",
          label: "کد راننده",
          class: "align-middle",
          sortable: true,
        },
        {
          key: "personal_name",
          label: "نام و نام خانوادگی",
          class: "align-middle",
          sortable: true,
        },
        {
          key: "mobile",
          label: "موبایل",
          class: "align-middle",
          sortable: false,
        },
        {
          key: "status",
          formatter: "statusType",
          label: "وضعیت فعالیت",
          class: "align-middle",
          sortable: true,
        },
        {
          key: "actions",
          class: "text-center align-middle w-18",
          label: "اقدامات",
          sortable: false,
        },
      ],
      modalFields: null,
      items: null,
      isBusy: false,
      sortBy: "id",
      sortDesc: true,
      sortDirection: "asc",
      filter: {
        name: null,
        code: null,
        mobile: null,
        nationCode: null,
      },
      filterOn: [],
      totalRows: 0,
      currentPage: 1,
      perPage: 1,
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
        itemID: null,
      },

      modalTable: {
        show: false,
        title: "جدول",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null,
      },

      modalDriverHandler: {
        id: "driver-base",
        api: null,
        fields: null,
        type: null,
        show: false,
        title: "جدول",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null,
        sortBy: "id",
        sortType: false,
        formShow: true,
        tableShow:true,
      },

      modalPrintHandler: {
        show: false,
        title: "جدول",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null,
        item: [],
      },
    };
  },

  components: {
    Body,
    CardProgress,
    ModalHandler,
    PrintDriverInfo,
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
    modalSortOptions() {
      // Create an options list from our fields
      return this.modalFields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  mounted() {
    this.api = "api/v1/client/drivers";
  },
  methods: {
    printInfo(itemID,itemName) {
      this.modalPrintHandler.show = true;
      this.modalPrintHandler.itemID = itemID;
      this.modalPrintHandler.title = "پرینت اطلاعات "+itemName;
    },
    tableShow(itemID, itemTitle, type) {
      this.modalMinApi = this.api + "/" + itemID + "/";
      this.modalDriverHandler.itemID = itemID;
      this.modalDriverHandler.formShow = true;
      this.modalDriverHandler.tableShow = true;
      switch (type) {
        case "records":
          this.modalDriverHandler.api = this.modalMinApi + "records";
          this.modalDriverHandler.title = "گزارشات مربوط به " + itemTitle;
          this.modalDriverHandler.sortBy = "id";
          this.modalDriverHandler.sortType = true;
          this.modalDriverHandler.fields = [
            {
              key: "note",
              label: "توضیحات",
            },
            { key: "created_at", label: "تاریخ", class: "w-10" },
          ];
          this.modalDriverHandler.type = "records";
          this.modalDriverHandler.show = true;
          break;
        case "book-times":
          this.modalDriverHandler.api = this.modalMinApi + "book-times";
          this.modalDriverHandler.title = "دفترچه های ثبت ساعت مربوط به : " + itemTitle;
          this.modalDriverHandler.sortBy = "expire_date";
          this.modalDriverHandler.sortType = true;
          this.modalDriverHandler.fields = [
            {
              key: "code",
              label: "کد دفترچه",
            },
            { key: "expire_date_jalali", label: "انقضا", class: "w-10" },
          ];
          this.modalDriverHandler.type = "book-time";
          this.modalDriverHandler.show = true;
          break;
        case "contracts":
          this.modalDriverHandler.api = this.modalMinApi + "contracts";
          this.modalDriverHandler.title = "قراردادهای مربوط به : " + itemTitle;
          this.modalDriverHandler.sortBy = "expire_date";
          this.modalDriverHandler.sortType = true;
          this.modalDriverHandler.fields = [
            {
              key: "number",
              label: "شماره قرارداد",
            },
            { key: "expire_date_jalali", label: "انقضا", class: "w-10" },
          ];
          this.modalDriverHandler.type = "contract";
          this.modalDriverHandler.show = true;
          break;
        case "license":
          this.modalDriverHandler.api = this.modalMinApi + "license";
          this.modalDriverHandler.title = "مجوزهای مربوط به : " + itemTitle;
          this.modalDriverHandler.fields = [];
          this.modalDriverHandler.type = "license";
          this.modalDriverHandler.formShow = false;
          this.modalDriverHandler.tableShow = false;
          this.modalDriverHandler.show = true;
          break;
        case "vehicles":
          // this.modalDriverHandler.api = this.modalMinApi + "vehicles";
          // this.modalDriverHandler.title = "وسایل نقلیه مربوط به : " + itemTitle;
          // this.modalDriverHandler.fields = [
          //   {
          //     key: "car_code",
          //     label: "شماره خودرو",
          //   },
          //   {
          //     key: "vin",
          //     label: "VIN",
          //     class: "text-center"
          //   },
          //   {
          //     key: "plate_series",
          //     label: "پلاک استان",
          //     class: "text-center"
          //   },
          //   {
          //     key: "plate_series_1",
          //     label: "بخش اول پلاک",
          //     class: "text-center"
          //   },
          //   {
          //     key: "plate_series_2",
          //     label: "سری پلاک",
          //     class: "text-center"
          //   },
          //   {
          //     key: "plate_series_3",
          //     label: "بخش سوم پلاک",
          //     class: "text-center"
          //   },
          //   { key: "car_card_no", label: "شماره کارت" },
          // ];
          // this.modalDriverHandler.type = "vehicle";
          // this.modalDriverHandler.show = true;

            this.modalDelete.show = true;
            this.modalDelete.title = "وسایل نقلیه راننده";
            this.modalDelete.content =
              "این امکان در حاضر غیرفعال می باشد. جهت فعالسازی با پشتیبانی تماس حاصل فرمایید";
            this.modalDelete.itemID = itemID;
          break;
        case "destenations":
          // this.modalDriverHandler.type = "destenations";
          // this.modalDriverHandler.api = this.modalMinApi + "destenations";
          // this.modalDriverHandler.title =
          //   "مقاصد مجاز وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          // this.modalDriverHandler.fields = [
          //   { key: "company.name", label: "شرکت مقصد", class: "text-right" },
          //   {
          //     key: "company.location",
          //     label: "استان، شهر، شهرستان",
          //     class: "w-20",
          //   },
          // ];
          // this.modalDriverHandler.itemID = itemID;
          // this.modalDriverHandler.show = true;

            this.modalDelete.show = true;
            this.modalDelete.title = "مقاصد";
            this.modalDelete.content =
              "این امکان در حاضر غیرفعال می باشد. جهت فعالسازی با پشتیبانی تماس حاصل فرمایید";
            this.modalDelete.itemID = itemID;
          break;
        default:
          break;
      }
    },
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
      if (ctx.sortBy == "personal_name") {
        sortBy = "lname";
      }
      let params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;

      if (ctx.filter) {
        if (ctx.filter.name) params += "&personal_name=" + ctx.filter.name;
        if (ctx.filter.code) params += "&driver_code=" + ctx.filter.code;
        if (ctx.filter.mobile) params += "&mobile=" + ctx.filter.mobile;
        if (ctx.filter.nationCode) params += "&nation_code=" + ctx.filter.nationCode;
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
      let params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;
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
        .then((response) => {
          const modalItems = response.data;
          this.modalTotalRows = response.data.total;
          this.modalPerPage = response.data.per_page;
          return modalItems.data;
        })
        .catch((error) => {
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
          return "فعال";
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
          return "فعال";
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
    },
  },
};
</script>
