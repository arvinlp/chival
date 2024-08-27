<template>
  <section class="page">
    <div class="row">
      <CardProgress
        class="col-3 offset-6"
        :url="newUrl"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن پرسنل جدید</h5>
        </template>
      </CardProgress>
      <CardProgress
        class="col-3"
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
      <!-- -->
      <div class="col-3 offset-6">
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
          <template v-slot:cell(fullname)="data">{{ data.item.fname }} {{ data.item.lname }}</template>
          <template v-slot:cell(user_role)="data">{{ data.item.role }}</template>
          <template
            v-slot:cell(work_time)="data"
          >{{ data.item.work_time.start }} {{ data.item.work_time.end }}</template>
          <template v-slot:cell(status)="data">{{data.value}}</template>
          <template v-slot:cell(actions)="data">
            <router-link :to="`${baseUrl}/logs/${data.item.id}`" title="تاریخچه فعالیت">
              <i class="fas fa-eye"></i>
            </router-link>
            <router-link :to="`${baseUrl}/edit/${data.item.id}`" title="ویرایش">
              <i class="fas fa-pencil-alt"></i>
            </router-link>
            <a
              href="#"
              v-on:click="deleteItem(data.item.id,(data.item.fname+' '+data.item.lname))"
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
        { key: "fullname", label: "مشخصات پرسنل", sortable: true },
        { key: "user_role", label: "نوع کاربری", sortable: false },
        { key: "work_time", label: "شیف کاری", sortable: false },
        {
          key: "status",
          formatter: "statusType",
          label: "وضعیت اتصال",
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
      baseUrl: null,
      newUrl: null,
      backUrl: null,
      api: null,

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
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.backUrl = "/portal/companies"
      this.baseUrl = "users";
      this.newUrl = "/portal/companies/" + this.$route.params.id + "/users/new";
      this.api = "api/v1/portal/companies/" + this.$route.params.id + "/users";
    } else {
      this.$router.push(this.$route.query.redirect || "/portal/companies");
    }
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
          console.error("Delete User Error : " + error)
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
      if (ctx.sortBy == "user_role") {
        sortBy = "role";
      }
      if (ctx.sortBy == "fullname") {
        sortBy = "lname";
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
          "&personal_name=" +
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
          const items = [];
          this.totalRows = 0;
          this.perPage = 0;
          return [];
        })
        .finally(() => (this.loading = false));
    },
    statusType(value) {
      switch (parseInt(value)) {
        case 0:
          return "قطع";
        case 1:
          return "متصل";
        case 2:
          return "مسدود شده";
        default:
          return "---";
      }
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    removeCurrentUser(arr, value) {
      return arr.filter(function(ele) {
        return ele != value;
      });
    }
  }
};
</script>

