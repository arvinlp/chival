<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3 offset-9"
        :dynomic="{ name: 'client-exclusive-new' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">سفر دربستی جدید</h5>
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
          <template v-slot:cell(status)="data">{{ data.value }}</template>
          <template v-slot:cell(actions)="data">
            <router-link
              :to="{ name: 'client-vehicle-edit', params: { id: data.item.id } }"
              v-b-tooltip.hover="{ variant: 'primary' }"
              title="ویرایش"
            >
              <i class="fas fa-car"></i>
            </router-link>
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
          key: "chival_code",
          label: "کد سفر",
          class: "align-middle",
          sortable: true,
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
    this.api = "api/v1/client/travels/exclusives";
  },
  methods: {
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
