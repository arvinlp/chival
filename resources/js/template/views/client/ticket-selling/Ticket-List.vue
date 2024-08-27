<template>
  <section class="page">
    <b-alert
      :show="alert.show"
      fade
      :variant="alert.type"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div>{{ alert.content }}</div>
    </b-alert>
    <div class="row">
      <div class="col-12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>لیست فروش بیلط</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <b-button class="btn-icon" v-on:click="fetchTurnList">
                  <i class="fas fa-sync"></i>
                </b-button>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">انتخاب مسیر :</label>
                <div class="col-9">
                  <multiselect
                    v-model="route"
                    :customLabel="routeLabel"
                    track-by="id"
                    placeholder="خط سیر را انتخاب کنید."
                    open-direction="bottom"
                    :options="routeList"
                    :multiple="false"
                    :searchable="true"
                    :allow-empty="false"
                    selectLabel
                    selectedLabel
                    deselectLabel
                    @select="onSelectRoute"
                    @change="onSelectRoute"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">حداکثر تعداد اعزام خودکار :</label>
                <div class="col-8">
                  <multiselect
                    v-model="route_number"
                    :customLabel="routeNumberLabel"
                    placeholder="تعداد را انتخاب کنید."
                    open-direction="bottom"
                    :options="routeNumbers"
                    :multiple="false"
                    :searchable="true"
                    :allow-empty="false"
                    selectLabel
                    selectedLabel
                    deselectLabel
                    @select="onSelectNumber"
                    @change="onSelectNumber"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body ticket-list" v-if="items">
            <SellingCell
              v-for="item in items"
              :key="item.id"
              :item="item"
              :url="{ name: 'client-ticket-selling', params: { id: item.travel_id } }"
              :api="api"
              @btnCancel="cancelTravel"
              @btnRoute="changeRoute"
            ></SellingCell>
            <div :class="loading"></div>
          </b-row>
          <b-row class="inner-body" v-else-if="route == null">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <div class="col-12 text-center">
                  خط مورد نظر برای نمایش لیست را انتخاب کنید.
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body" v-else>
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <div class="col-12 text-center text-danger">
                  راننده و وسیله نقلیه(ای) در لیست نوبت جهت نمایش وجود ندارد.
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <!-- -->
    <b-modal id="modal-selling" v-model="ItemHandler.show" centered size="lg" hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>{{ ItemHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <BaseModalHandler
          :modalApi="ItemHandler.modalApi"
          :modalType="ItemHandler.modalType"
          modalID="modal-selling"
          />
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import SellingCell from "../../../components/SellingCell";
import BaseModalHandler from "../../../components/modal-forms/selling/BaseModalHandler";

export default {
  data() {
    return {
      form: {},
      loading: true,
      items: null,
      route_number: 3,
      route_id: null,
      route: null,
      routeList: [],
      routeNumbers: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
      timer: "",
      counter: 0,
      loading: "overlay d-block",
      loadingFlag: true,

      api: "api/v1/client/travels/selling-list",
      api_route: "api/v1/client/routes/list",

      alert: {
        show: false,
        content: null,
        type: "success",
        sec: 5,
      },

      ItemHandler: {
        show: false,
        title: "عنوان آیتم",
        btnCancel: "خیر",
        modalApi: null,
        modalType:null,
        item: null,
        placeholder: null,
      },
    };
  },

  components: {
    Body,
    CardProgress,
    SellingCell,
    BaseModalHandler
  },

  computed: {
    isType: function () {
      return this.$store.getters.isType;
    },
    pushToSelling: function () {
      return parseInt(this.$store.getters.getPushToSelling);
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    runFetchAndTimer: function () {
      clearInterval(this.timer);

      this.fetchTurnList();
      this.timer = setInterval(this.fetchTurnList, 5 * 1000); //Milisec
    },
  },
  created() {
    this.getAllRoutes();
    this.route_number = this.pushToSelling;
  },
  mounted() {},
  methods: {
    getRecord(travel_id, item) {
      var promise = this.$http.post(this.$api(this.api + "/" + travel_id), { status: 3 });

      promise
        .then((response) => {
          this.$notify({
            group: "error",
            title: "درخواست صورت وضعیت",
            text: "درخواست صورت وضعیت برای وسیله نقلیه ثبت شد.",
            duration: 10000,
          });
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
          console.error("Error : " + error);
        });
    },
    cancelTravel(value) {
      console.error("Cancel Turn List Item By ID : " + value);
    },
    changeRoute(value) {
      this.ItemHandler.show = true;
      this.ItemHandler.title = "تغییر مقصد این سفر";
      this.ItemHandler.modalType = "changeRoute";
      this.ItemHandler.modalApi = this.api+'/change/'+value;
    },
    /** */
    onSelectRoute(value) {
      this.route = value;

      clearInterval(this.timer);

      this.fetchTurnList();
      this.timer = setInterval(this.fetchTurnList, 5 * 1000); //Milisec
    },
    onSelectNumber(value) {
      this.route_number = value;
    },
    modalHandler(item, type) {
      this.ItemHandler.show = true;
      this.alert.show = 0;
      switch (type) {
        case "reject":
          this.ItemHandler.title =
            "« " +
            item.driver_info.fname +
            " " +
            item.driver_info.lname +
            " » به انتهای لیست منتقل شود.";
          this.ItemHandler.placeholder = "متن گزارش را وارد کنید.";
          if (item.note != null) this.form.note = item.note;
          this.form.status = 50;
          this.ItemHandler.type = "reject";
          this.ItemHandler.endPoint = "reject/" + item.id;
          this.alert.content = this.ItemHandler.title;
          break;
      }
      this.ItemHandler.item = item;
    },
    ItemHandlerBtn(type) {
      let promise = this.$http.post(
        this.$api(this.api + this.ItemHandler.endPoint),
        this.form
      );

      return promise
        .then((response) => {
          this.ItemHandler.show = false;
          this.alert.show = 5;
          this.fetchTurnList();
        })
        .catch((error) => {
          console.error("Delete User Error : " + error);
          return [];
        })
        .finally(() => (this.loading = "overlay"));
    },
    fetchTurnList() {
      var promise = null;
      if (this.route) {
        promise = this.$http.get(
          this.$api(
            this.api +
              "?selling_number=" +
              this.route_number +
              "&route_id=" +
              this.route.id
          )
        );

        if (this.loadingFlag) this.loading = true;

        return promise
          .then((response) => {
            const items = response.data;
            this.items = items;
            return items.data;
          })
          .catch((error) => {
            this.items = null;
            return [];
          })
          .finally(() => {
            this.loading = "overlay";
            this.loadingFlag = false;
          });
      } else {
        this.alert.show = 5;
        this.alert.content = "خط سیر انتخاب نشده است.";
        this.alert.type = "danger";
      }
    },
    countDownChangedAlert(dismissCountDown) {
      this.alert.show = dismissCountDown;
    },
    getAllRoutes() {
      let promise = this.$http.get(this.$api(this.api_route));
      this.loading = true;

      clearInterval(this.timer);

      return promise
        .then((response) => {
          this.routeList = response.data;
          this.route = this.routeList[0];
          this.runFetchAndTimer;
        })
        .catch((error) => {
          console.error("Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    routeLabel(value) {
      return value.name + " - " + value.route_code;
    },
    routeNumberLabel(value) {
      return value;
    },
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>
