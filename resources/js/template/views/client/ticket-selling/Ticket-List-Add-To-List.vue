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
      <CardProgress
        class="col-3 offset-9"
        v-b-toggle="'collapse-1'"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">افزودن راننده به لیست</h5>
        </template>
      </CardProgress>
      <div class="col-12">
        <b-collapse id="collapse-1">
          <div class="inner-main">
            <div class="inner-header">
              <b-row>
                <b-col cols="12">
                  <span>افزودن راننده جدید به لیست نوبت</span>
                </b-col>
              </b-row>
            </div>
            <b-form @submit="onSubmitAddDriver" @reset="onResetAddDriver">
              <b-row class="inner-body row-eq-height">
                <b-col cols="6">
                  <div class="form-group row align-items-center">
                    <label class="col-2 col-form-label">راننده</label>
                    <div class="col-10">
                      <multiselect
                        v-model="driver"
                        :customLabel="driverLabel"
                        placeholder="نوع نمایش را مشخص کنید."
                        open-direction="bottom"
                        :options="drivers"
                        :multiple="false"
                        :searchable="true"
                        selectLabel
                        selectedLabel="انتخاب شده"
                        deselectLabel="لغو انتخاب"
                        @select="onSelectDriver"
                        @change="onSelectDriver"
                      >
                        <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                      </multiselect>
                    </div>
                  </div>
                </b-col>
                <b-col cols="6">
                  <div class="form-group row align-items-center" v-if="driver != null">
                    <div class="col-10 text-center">
                      <p>
                        <span v-if="driver.status == 0">
                          وسیله نقلیه قادر به دریافت سرویس نمی باشد.
                        </span>
                        <br />
                        <span> تاریخ دفترچه ثبت ساعت : {{ driver.book }} </span>
                        <br />
                        <span>
                          تاریخ کارت هوشمند :
                          {{ driver.license_expire_date_persian }}
                        </span>
                        <br />
                        <span>
                          تاریخ صحت سلامت : {{ driver.health_expire_date_persian }}
                        </span>
                        <br />
                        <span v-if="driver.status == 0">
                          توضیحات : {{ driver.driver_note }}
                        </span>
                      </p>
                    </div>
                  </div>
                </b-col>
              </b-row>
              <b-row class="inner-body row-eq-height">
                <b-col cols="6">
                  <div class="form-group row align-items-center">
                    <label class="col-2 col-form-label">وسیله نقلیه</label>
                    <div class="col-10">
                      <multiselect
                        v-model="car"
                        :customLabel="carLabel"
                        placeholder="نوع نمایش را مشخص کنید."
                        open-direction="bottom"
                        :options="cars"
                        :multiple="false"
                        :searchable="true"
                        selectLabel
                        selectedLabel="انتخاب شده"
                        deselectLabel="لغو انتخاب"
                        @select="onSelectCar"
                        @change="onSelectCar"
                      >
                        <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                      </multiselect>
                    </div>
                  </div>
                </b-col>
                <b-col cols="6">
                  <div class="form-group row align-items-center" v-if="car != null">
                    <div class="col-10 text-center">
                      <p>
                        <span v-if="car.status == 0">
                          وسیله نقلیه قادر به دریافت سرویس نمی باشد.
                        </span>
                        <br />
                        <span> تاریخ بیمه شخص ثالث : {{ car.insurance_third }} </span>
                        <br />
                        <span> تاریخ معاینه فنی : {{ car.td_expire }} </span>
                        <br />
                        <span v-if="car.status == 0">
                          توضیحات : {{ car.status_note }}
                        </span>
                      </p>
                    </div>
                  </div>
                </b-col>
              </b-row>
              <b-row class="inner-body row-eq-height">
                <b-col cols="6">
                  <div class="form-group row align-items-center">
                    <label class="col-2 col-form-label">مسیر</label>
                    <div class="col-10">
                      <multiselect
                        v-model="routeDriver"
                        :customLabel="routeLabel"
                        placeholder="نوع نمایش را مشخص کنید."
                        open-direction="bottom"
                        :options="routes"
                        :multiple="false"
                        :searchable="true"
                        selectLabel
                        selectedLabel="انتخاب شده"
                        deselectLabel="لغو انتخاب"
                        @select="onSelectRouteAdd"
                        @change="onSelectRouteAdd"
                      >
                        <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                      </multiselect>
                    </div>
                  </div>
                </b-col>
                <b-col cols="6">
                  <div class="form-group row align-items-center">
                    <div class="col-10"></div>
                  </div>
                </b-col>
              </b-row>
              <b-row class="inner-body row-eq-height">
                <b-col cols="12">
                  <div class="form-group row align-items-center">
                    <label class="col col-form-label">استفاده از مسیر فعلی</label>
                    <b-col cols="10" class="form-checkbox-datamis text-right">
                      <input
                        id="UseSameRoute"
                        type="checkbox"
                        v-model="sameRoute"
                        class="form-checkbox-input"
                      />
                      <label class="form-checkbox-label" for="UseSameRoute">
                        <span></span>
                        استفاده از مسیر
                        <b v-if="route">({{ route.name }})</b>
                        <b v-else>(فعلی)</b>
                      </label>
                    </b-col>
                  </div>
                </b-col>
              </b-row>
              <b-row class="inner-body row-eq-height">
                <b-col cols="6" class="text-right">
                  <button type="reset" class="btn btn-reset w-50">پاک کرد فرم</button>
                </b-col>
                <b-col cols="6">
                  <button type="submit" class="btn btn-success w-50">ثبت</button>
                </b-col>
              </b-row>
            </b-form>
          </div>
        </b-collapse>
      </div>
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
              @btnRecord="onSelectRecord"
              @btnCancel="onSelectCancel"
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
    <b-modal v-model="ItemHandler.show" centered>
      <template v-slot:modal-header="{ close }">
        <h5>{{ ItemHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <p v-if="ItemHandler.content" v-html="ItemHandler.content"></p>
        <textarea
          v-if="ItemHandler.placeholder"
          v-model="form.note"
          :placeholder="ItemHandler.placeholder"
          class="form-control"
        />
      </template>

      <template v-slot:modal-footer="{ cancel }">
        <div>
          <div class="text-right">
            <b-button
              size="sm"
              variant="success"
              @click="ItemHandlerBtn(ItemHandler.type)"
              >{{ ItemHandler.btnOK }}</b-button
            >
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="cancel()">{{
              ItemHandler.btnCancel
            }}</b-button>
          </div>
        </div>
      </template>
    </b-modal>
    <b-modal v-model="modalVerify.show" size="lg" centered>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalVerify.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <p v-html="modalVerify.content"></p>
      </template>

      <template v-slot:modal-footer="{ cancel }">
        <div class="text-center">
          <b-button size="md" class="mx-auto" variant="danger" @click="cancel()">
            {{ modalVerify.btnCancel }}
          </b-button>
        </div>
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import SellingCell from "../../../components/SellingCell";

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
      //
      sameRoute: false,
      formVisible: false,
      drivers: [],
      driver: null,
      cars: [],
      car: null,
      routes: [],
      routeDriver: [],
      baseApi: "api/v1/client/travels/",
      //
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
        content: null,
        btnOK: "بلی",
        btnCancel: "خیر",
        type: null,
        endPoint: null,
        item: null,
        placeholder: null,
      },
      modalVerify: {
        show: false,
        title: "خطا آیتم",
        content: "آیا از ااین آیتم مطمین هستید ؟",
        btnOK: "بلی",
        btnCancel: "متوجه شدم، بستن پیغام.",
        evt: null,
      },
    };
  },

  components: {
    Body,
    CardProgress,
    SellingCell,
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
    this.getDrivers();
    this.getCars();
    this.getRoutes();
  },
  mounted() {},
  methods: {
    onSelectRecord(travel_id, item) {
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
    onSelectCancel(value) {
      console.error("Cancel Turn List Item By ID : " + value);
    },
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
    //
    onSelectDriver(value) {
      this.driver = value;
      this.form.driver_id = parseInt(value.id);
      this.form.car_id = parseInt(value.car_id);
      this.car = this.cars.find((item) => item.id === value.car_id);
      this.onSelectCar(this.car);
    },
    onSelectCar(value) {
      this.car = value;
      this.form.car_id = parseInt(value.id);
      this.routeDriver = this.routes.find((item) => item.id === parseInt(value.route_id));
      this.onSelectRouteAdd(this.routeDriver);
    },
    onSelectRouteAdd(value) {
      this.routeDriver = value;
      this.form.route_id = parseInt(value.id);
    },
    getDrivers() {
      let promise = this.$http.get(this.$api(this.baseApi + "drivers"));
      return promise
        .then((response) => {
          this.drivers = response.data;
          return response.data;
        })
        .catch((error) => {
          this.drivers = [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    getCars() {
      let promise = this.$http.get(this.$api(this.baseApi + "cars"));
      return promise
        .then((response) => {
          this.cars = response.data;
          return response.data;
        })
        .catch((error) => {
          this.cars = [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    getRoutes() {
      let promise = this.$http.get(this.$api(this.baseApi + "routes"));
      return promise
        .then((response) => {
          this.routes = response.data;
          return response.data;
        })
        .catch((error) => {
          this.routes = [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    onSubmitAddDriver(evt) {
      evt.preventDefault();
      if (this.form.car_id == undefined) {
        this.$notify({
          group: "error",
          text: "راننده و وسلیه نقلیه به درستی انتخاب نشده اند.",
          type: "error",

          duration: 10000,
        });
      } else {
        if (this.driver.status == 0 || this.car.status == 0) {
          if (this.driver.status == 0 && this.car.status == 0) {
            this.modalVerify.show = true;
            this.modalVerify.title =
              "خطا ثبت نوبت برای راننده و وسیله نقلیه با اطلاعات ناقص";
            this.modalVerify.content =
              "متاسفانه آقا/خانم " +
              this.driver.fname +
              " " +
              this.driver.lname +
              " قادر به دریافت سرویس تا زمان رفع نواقص زیر نمی باشد :" +
              "<br>";
            this.modalVerify.content +=
              "- تاریخ دفترچه ثبت ساعت : " + this.driver.book + "<br>";
            this.modalVerify.content +=
              "- تاریخ کارت هوشمند : " + this.driver.license_expire_date_persian + "<br>";
            this.modalVerify.content +=
              "- تاریخ صحت و سلامت : " + this.driver.health_expire_date_persian + "<br>";
            this.modalVerify.content +=
              "- توضیحات ثبت شده : " + this.driver.driver_note + "<br>";
            this.modalVerify.content += "<hr>";
            this.modalVerify.content +=
              "متاسفانه وسیله نقلیه به پلاک " +
              this.car.plate_series +
              " ایران | " +
              this.car.plate_series_3 +
              " " +
              this.car.plate_series_2 +
              " " +
              this.car.plate_series_1 +
              " قادر به دریافت سرویس تا زمان رفع نواقص زیر نمی باشد :" +
              "<br>";
            this.modalVerify.content +=
              "- تاریخ بیمه شخص ثالث : " + this.car.insurance_third + "<br>";
            this.modalVerify.content +=
              "- تاریخ معاینه فنی : " + this.car.td_expire + "<br>";
            this.modalVerify.content += "- توضیحات ثبت شده : " + this.car.status_note;
          } else if (this.driver.status == 0) {
            this.modalVerify.show = true;
            this.modalVerify.title = "خطا ثبت نوبت برای راننده با اطلاعات ناقص";
            this.modalVerify.content =
              "متاسفانه آقا/خانم " +
              this.driver.fname +
              " " +
              this.driver.lname +
              " قادر به دریافت سرویس تا زمان رفع نواقص زیر نمی باشد :" +
              "<br>";
            this.modalVerify.content +=
              "- تاریخ دفترچه ثبت ساعت : " + this.driver.book + "<br>";
            this.modalVerify.content +=
              "- تاریخ کارت هوشمند : " + this.driver.license_expire_date_persian + "<br>";
            this.modalVerify.content +=
              "- تاریخ صحت و سلامت : " + this.driver.health_expire_date_persian + "<br>";
            this.modalVerify.content += "- توضیحات ثبت شده : " + this.driver.driver_note;
          } else if (this.car.status == 0) {
            this.modalVerify.show = true;
            this.modalVerify.title = "خطا ثبت نوبت برای وسیله نقلیه با اطلاعات ناقص ";
            this.modalVerify.content =
              "متاسفانه وسیله نقلیه به پلاک " +
              this.car.plate_series +
              " ایران | " +
              this.car.plate_series_3 +
              " " +
              this.car.plate_series_2 +
              " " +
              this.car.plate_series_1 +
              " قادر به دریافت سرویس تا زمان رفع نواقص زیر نمی باشد :" +
              "<br>";
            this.modalVerify.content +=
              "- تاریخ بیمه شخص ثالث : " + this.car.insurance_third + "<br>";
            this.modalVerify.content +=
              "- تاریخ معاینه فنی : " + this.car.td_expire + "<br>";
            this.modalVerify.content += "- توضیحات ثبت شده : " + this.car.status_note;
          }
        } else {
          this.form.status = 90;
          if (this.sameRoute) this.form.route_id = this.route.id;
          else this.form.route_id = this.routeDriver.id;
          let promise = this.$http.post(
            this.$api(this.baseApi + "turn-list/login-selling"),
            this.form
          );
          promise
            .then(() => {
              this.fetchTurnList();
              this.car = null;
              this.driver = null;
              this.routeDriver = null;
              this.form.driver_id = null;
              this.form.car_id = null;
              this.form.route_id = null;
              this.form.note = null;
              this.form.status = null;

              this.$root.$emit("bv::toggle::collapse", "collapse-1");
            })
            .catch((error) => {
              this.isAlert = this.dismissSecs;
              let e = error.response;
              if (e.status === 422) {
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
              if (e.status === 409) {
                let er = e.data;
                if (er) {
                  this.$notify({
                    group: "error",
                    text: er["message"],
                    type: "error",

                    duration: 10000,
                  });
                }
              }
            });
        }
      }
    },
    onResetAddDriver(evt) {
      evt.preventDefault();
      this.car = null;
      this.driver = null;
      this.routeDriver = null;
      this.form.driver_id = null;
      this.form.car_id = null;
      this.form.route_id = null;
      this.form.note = null;
      this.form.status = null;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    driverLabel(value) {
      return value.driver_code + " - " + value.fname + " " + value.lname;
    },
    carLabel(value) {
      return (
        value.car_code +
        " - « " +
        value.plate_series +
        " | " +
        value.plate_series_1 +
        " " +
        value.plate_series_2 +
        " " +
        value.plate_series_3 +
        " »"
      );
    },
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>
