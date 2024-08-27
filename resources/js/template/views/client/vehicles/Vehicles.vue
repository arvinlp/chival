<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3"
        :dynomic="{ name: 'client-vehicle-new' }"
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
        class="col-3 offset-6"
        :dynomic="{ name: 'client-partnear-vehicles' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">وسایل نقلیه همکاران</h5>
        </template>
      </CardProgress>
      <div class="col-3">
        <b-form-input
          v-model="filter.code"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو با کد"
        ></b-form-input>
      </div>
      <div class="col-3">
        <b-form-input
          v-model="filter.carCardNo"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو با کارت هوشمند"
        ></b-form-input>
      </div>
      <div class="col-3">
        <b-form-input
          v-model="filter.plateSeries1"
          type="search"
          class="search-in-table"
          id="filterInput"
          placeholder="جستجو با بخش سوم پلاک"
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
          <template v-slot:cell(plate)="data"
            >ایران {{ data.item.plate_series }} | {{ data.item.plate_series_1 }}
            {{ data.item.plate_series_2 }} {{ data.item.plate_series_3 }}</template
          >
          <template v-slot:cell(status)="data">{{ data.value }}</template>
          <template v-slot:cell(actions)="data">
            <a
              href="#third-insurances"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'insurance3')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="بیمه شخص ثالث"
            >
              <i class="fas fa-car-crash"></i>
            </a>
            <a
              href="#body-insurances"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'insurance1')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="بیمه بدنه"
            >
              <i class="fas fa-car-side"></i>
            </a>
            <a
              href="#technical-diagnoses"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'technical')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="معاینه فنی"
            >
              <i class="fas fa-car-battery"></i>
            </a>
            <a
              href="#destenations"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'destenations')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="مقاصد مجاز"
            >
              <i class="fas fa-history"></i>
            </a>
            <a
              href="#routes"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'routes')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="خط سیرهای مجاز"
            >
              <i class="fas fa-route"></i>
            </a>
            <a
              href="#travels"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'travels')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="تاریخچه سفرها"
            >
              <i class="fas fa-hotel"></i>
            </a>
            <a
              href="#owener"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'owners')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="مالکین"
            >
              <i class="fas fa-user-times"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'records')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="گزارشات"
            >
              <i class="fas fa-notes-medical"></i>
            </a>
            <a
              href="#"
              v-on:click="tableShow(data.item.id, data.item.car_card_no, 'license')"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="مجوز"
            >
              <i class="fas fa-certificate"></i>
            </a>
            <router-link
              :to="{ name: 'client-vehicle-edit', params: { id: data.item.id } }"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="ویرایش"
            >
              <i class="fas fa-car"></i>
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
    <!-- -->
    <b-modal :id="modalVehicleHandler.id" v-model="modalVehicleHandler.show" centered size="xl" hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalVehicleHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <ModalHandler
          :modalID="modalVehicleHandler.id"
          :modalType="modalVehicleHandler.type"
          :modalApi="modalVehicleHandler.api"
          :modalFields="modalVehicleHandler.fields"
          :parentID="modalVehicleHandler.itemID"
          :modalSortBy="modalVehicleHandler.sortBy"
          :modalSortType="modalVehicleHandler.sortType"
          :modalFormHandler="modalVehicleHandler.formShow"
          :modalTableHandler="modalVehicleHandler.tableShow"
        />
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import ModalHandler from "../../../components/modal-forms/vehicle/BaseModalHandler";

export default {
  data() {
    return {
      fields: [
        {
          key: "car_code",
          label: "کد وسیله نقلیه",
          class: "align-middle",
          sortable: true,
        },
        {
          key: "car_card_no",
          label: "شماره کارت هوشمند",
          class: "align-middle",
          sortable: true,
        },
        {
          key: "plate",
          label: "پلاک وسیله نقلیه",
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
      items: null,
      isBusy: false,
      sortBy: "id",
      sortDesc: true,
      sortDirection: "asc",
      filter: {
        code: null,
        carCardNo: null,
        plateSeries1: null,
      },
      filterOn: [],
      totalRows: 0,
      currentPage: 1,
      perPage: 1,
      api: null,

      modalDelete: {
        show: false,
        title: "حذف آیتم",
        content: "آیا حذف این آیتم مطمین هستید ؟",
        btnOK: "بلی",
        btnCancel: "خیر",
        itemID: null,
      },

      modalVehicleHandler: {
        id: "vehicle-base",
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
        formShow:true,
        tableShow:true
      },
    };
  },

  components: {
    Body,
    CardProgress,
    ModalHandler,
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
  mounted() {
    this.api = "api/v1/client/vehicles";
  },
  methods: {
    tableShow(itemID, itemTitle, type) {
      this.modalMinApi = this.api + "/" + itemID + "/";
      this.modalVehicleHandler.formShow = true;
      this.modalVehicleHandler.tableShow = true;
      switch (type) {
        case "records":
          this.modalVehicleHandler.api = this.modalMinApi + "records";
          this.modalVehicleHandler.title = "گزارشات مربوط به " + itemTitle;
          this.modalVehicleHandler.sortBy = "id";
          this.modalVehicleHandler.sortType = true;
          this.modalVehicleHandler.fields = [
            {
              key: "note",
              label: "توضیحات",
            },
            { key: "created_at", label: "تاریخ", class: "w-10" },
          ];
          this.modalVehicleHandler.type = "records";
          this.modalVehicleHandler.show = true;
          break;
        case "insurance1":
          this.modalVehicleHandler.api = this.modalMinApi + "body-insurances";
          this.modalVehicleHandler.title =
            "بیمه نامه های بدنه وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalVehicleHandler.fields = [
            {
              key: "company.name",
              label: "شرکت بیمه",
              class: "text-right w-25",
            },
            { key: "code", label: "شماره بیمه نامه", class: "text-center" },
            { key: "expire_date", label: "انقضا", class: "w-10" },
          ];
          this.modalVehicleHandler.type = "insurance-body";
          this.modalVehicleHandler.show = true;
          break;
        case "insurance3":
          this.modalVehicleHandler.type = "insurance-third";
          this.modalVehicleHandler.api = this.modalMinApi + "insurances";
          this.modalVehicleHandler.title =
            "بیمه نامه های شخص ثالث وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalVehicleHandler.fields = [
            {
              key: "company.name",
              label: "شرکت بیمه",
              class: "text-right w-25",
            },
            { key: "code", label: "شماره بیمه نامه", class: "text-center" },
            { key: "expire_date", label: "انقضا", class: "w-10" },
          ];
          this.modalVehicleHandler.itemID = itemID;
          this.modalVehicleHandler.show = true;
          break;
        case "technical":
          this.modalVehicleHandler.type = "technical-diagnoses";
          this.modalVehicleHandler.api = this.modalMinApi + "technical-diagnoses";
          this.modalVehicleHandler.title =
            "معاینه فنی های وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalVehicleHandler.fields = [
            { key: "code", label: "شماره معاینه فنی", class: "text-right" },
            { key: "expire_date", label: "انقضا", class: "w-10" },
          ];
          this.modalVehicleHandler.itemID = itemID;
          this.modalVehicleHandler.show = true;
          break;
        case "owners":
          this.modalVehicleHandler.type = "owners";
          this.modalVehicleHandler.api = this.modalMinApi + "owners";
          this.modalVehicleHandler.title =
            "مالکین وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          this.modalVehicleHandler.fields = [
            { key: "owners.name", label: "نام و نام خانوادگی", class: "text-right" },
            { key: "owners.tel", label: "تلفن", class: "text-right" },
            { key: "owners.mobile", label: "موبایل", class: "text-right" },
          ];
          this.modalVehicleHandler.itemID = itemID;
          this.modalVehicleHandler.tableShow = false;
          this.modalVehicleHandler.formShow = false;
          this.modalVehicleHandler.show = true;
          break;
        case "destenations":
          // this.modalVehicleHandler.type = "destenations";
          // this.modalVehicleHandler.api = this.modalMinApi + "destenations";
          // this.modalVehicleHandler.title =
          //   "مقاصد مجاز وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          // this.modalVehicleHandler.fields = [
          //   { key: "company.name", label: "شرکت مقصد", class: "text-right" },
          //   {
          //     key: "company.location",
          //     label: "استان، شهر، شهرستان",
          //     class: "w-20",
          //   },
          // ];
          // this.modalVehicleHandler.itemID = itemID;
          // this.modalVehicleHandler.show = true;
            this.modalDelete.show = true;
            this.modalDelete.title = "مقاصد";
            this.modalDelete.content =
              "این امکان در حاضر غیرفعال می باشد. جهت فعالسازی با پشتیبانی تماس حاصل فرمایید";
            this.modalDelete.itemID = itemID;
          break;
        case "routes":
          // this.modalVehicleHandler.type = "routes";
          // this.modalVehicleHandler.api = this.modalMinApi + "routes";
          // this.modalVehicleHandler.title =
          //   "خط سیر مجاز وسیله نقلیه به شماره کارت هوشمند : " + itemTitle;
          // this.modalVehicleHandler.fields = [
          //   { key: "route.name", label: "نام خط سیر", class: "text-right" },
          //   {
          //     key: "route.route_code",
          //     label: "کد خط",
          //     class: "w-20 text-center",
          //   },
          //   { key: "route.distance", label: "مسافت", class: "w-10 text-center" },
          // ];
          // this.modalVehicleHandler.itemID = itemID;
          // this.modalVehicleHandler.show = true;
            this.modalDelete.show = true;
            this.modalDelete.title = "خط سیرها";
            this.modalDelete.content =
              "این امکان در حاضر غیرفعال می باشد. جهت فعالسازی با پشتیبانی تماس حاصل فرمایید";
            this.modalDelete.itemID = itemID;
          break;
        case "travels":
          this.modalVehicleHandler.api = this.modalMinApi + "travels";
          this.modalVehicleHandler.title =
            "تاریخچه سفرهای وسیله نقلیه به شماره هوشمند : " + itemTitle;
          this.modalVehicleHandler.fields = [
            {
              key: "chival_code",
              label: "کدسفر",
              sortable: true,
            },
            {
              key: "driver_info",
              formatter: "flname",
              label: "نام راننده",
            },
            {
              key: "starting_company.name",
              label: "مبدا",
            },
            {
              key: "destanation_city.name",
              label: "شهر مقصد",
            },
            {
              key: "move_time",
              label: "ساعت حرکت",
              sortable: true,
              class:"w-15 text-center",
            },
            {
              key: "move_date",
              label: "تاریخ حرکت",
              sortable: true,
              class:"w-15 text-center"
            },
          ];
          this.modalVehicleHandler.type = "travels";
          this.modalVehicleHandler.formShow = false;
          this.modalVehicleHandler.show = true;
          break;
        case "license":
          this.modalVehicleHandler.api = this.modalMinApi + "license";
          this.modalVehicleHandler.title =
            "مجوز تردد وسیله نقلیه به شماره هوشمند : " + itemTitle;
          this.modalVehicleHandler.type = "license";
          this.modalVehicleHandler.formShow = false;
          this.modalVehicleHandler.tableShow = false;
          this.modalVehicleHandler.show = true;
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
      let params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;

      if (ctx.filter) {
        if (ctx.filter.code) params += "&car_code=" + ctx.filter.code;
        if (ctx.filter.carCardNo) params += "&car_card_number=" + ctx.filter.carCardNo;
        if (ctx.filter.plateSeries1) params += "&plate_series_1=" + ctx.filter.plateSeries1;
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
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
};
</script>
