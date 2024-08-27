<template>
  <div class="modal-base">
    <b-form @submit="onSubmit" @reset="onReset" class="row">
      <b-col v-if="modalType == 'changeRoute'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>خط سیر جدید</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-2 col-form-label">انتخاب خط</label>
                <div class="col-10">
                  <multiselect
                    v-model="route"
                    :customLabel="routeLabel"
                    track-by="id"
                    placeholder="خط را انتخاب کنید."
                    open-direction="bottom"
                    :options="routes"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectRoute"
                    @change="onSelectRoute"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="6" class="text-center">
        <button type="submit" class="btn btn-success w-100">
          مسیر این سفر را تغییر میدهم.
        </button>
      </b-col>
      <b-col cols="6" class="text-center">
        <button type="reset" class="btn btn-danger w-100">انصراف</button>
      </b-col>
    </b-form>
  </div>
</template>

<script>
export default {
  props: {
    modalApi: {
      type: String,
      description: "Modal Api Link",
    },
    modalType: {
      type: String,
      description: "Modal Type",
    },
    modalID: {
      type: String,
      description: "modal-handler",
    },
  },
  data() {
    return {
      form: {},
      modalFilterOn: [],
      modalFilter: [],
      modalMinApi: null,
      modalItems: null,
      modalTotalRows: 0,
      modalCurrentPage: 1,
      modalPerPage: 1,
      modalIsBusy: false,
      isLoading: false,

      route_id: null,
      routes: [],
      route: [],
      api_route: "api/v1/client/routes/list",
    };
  },
  computed: {
    modalSortOptions() {
      // Create an options list from our fields
      return this.modalFields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    modalSortDirection: function () {
      return modalSortType ? "desc" : "asc";
    },
    getUserData: function () {
      return this.$store.getters.user;
    },
  },
  mounted() {
    switch (this.modalType) {
      case "changeRoute":
        this.getAllRoutes();
        break;
    }
  },
  methods: {
    onSelectRoute(value) {
      this.form.route_id = value.id;
      this.route_id = value.id;
    },
    getAllRoutes() {
      let promise = this.$http.get(this.$api(this.api_route));
      this.loading = true;

      return promise
        .then((response) => {
          this.routes = response.data;
        })
        .catch((error) => {
          let e = error.response;
          if (e.status === 422 || e.status === 409) {
            let er = e.data;
            if (er) {
              for (var i = 0; i < Object.keys(er).length; i++) {
                this.$notify({
                  group: "error",
                  text: er[Object.keys(er)[i]][0],
                  type: "error",

                  duration: 10000 + i * 1000,
                });
              }
            }
          }
          return [];
        })
        .finally(() => (this.loading = false));
    },
    onSubmit(evt) {
      evt.preventDefault();
      let promise = this.$http.post(this.$api(this.modalApi), this.form);
      promise
        .then((response) => {
          this.form = [];
          this.$root.$emit("fetchTurnList");
          this.$root.$emit("bv::hide::modal", this.modalID);
        })
        .catch((error) => {
          let e = error.response;
          if (e.status === 422 || e.status === 409) {
            let er = e.data;
            if (er) {
              for (var i = 0; i < Object.keys(er).length; i++) {
                this.$notify({
                  group: "error",
                  text: er[Object.keys(er)[i]][0],
                  type: "error",

                  duration: 10000 + i * 1000,
                });
              }
            }
          }
        });
    },
    onReset() {
      this.$root.$emit("bv::hide::modal", this.modalID);
    },
    routeLabel(value) {
      return value.name + " - " + value.route_code;
    },
  },
};
</script>
