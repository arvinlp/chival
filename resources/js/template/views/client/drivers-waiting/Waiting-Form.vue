<template>
  <section class="page">
    <b-alert :show="isAlert" fade variant="danger" @dismiss-count-down="countDownChangedAlert">
      <div v-if="isEdit">خطای در ویرایش رخ داد مجددا سعی نمایید.</div>
      <div v-else>خطای در افزودن رخ داد مجددا سعی نمایید.</div>
    </b-alert>
    <b-alert
      :show="isEdited"
      fade
      variant="success"
      @dismiss-count-down="countDownChangedEdited"
    >اطلاعات با موفقیت بروزرسانی شد.</b-alert>

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>ورود راننده به لیست نوبت</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
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
              <div class="form-group row align-items-center">
                <div class="col-10"></div>
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
              <div class="form-group row align-items-center">
                <div class="col-10"></div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مسیر</label>
                <div class="col-10">
                  <multiselect
                    v-model="route"
                    :customLabel="routeLabel"
                    placeholder="نوع نمایش را مشخص کنید."
                    open-direction="bottom"
                    :options="routes"
                    :multiple="false"
                    :searchable="true"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="لغو انتخاب"
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
                <div class="col-10"></div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="6" class="text-right">
        <button type="reset" class="btn btn-reset w-50">پاک کرد فرم</button>
      </b-col>
      <b-col cols="6">
        <button type="submit" class="btn btn-success w-50">ثبت</button>
      </b-col>
    </b-form>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import Modal from "../../../components/Modal";
import AvatarCropper from "vue-avatar-cropper";

export default {
  data() {
    return {
      form: {},
      showModal: false,
      isEdit: false,
      isLoading: false,

      drivers: [],
      driver: [],
      cars: [],
      car: [],
      routes: [],
      route: [],

      baseUrl: { name: "client-drivers-waiting-list" },
      baseApi: "api/v1/client/travels/",

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0
    };
  },
  components: {
    Body,
    CardProgress
  },
  computed: {
    getUserData: function() {
      return this.$store.getters.user;
    },
    setToPage: function(value) {
      this.form.to = this.form.pages + this.form.of;
    }
  },
  mounted() {
    this.getDrivers();
    this.getCars();
    this.getRoutes();
  },
  methods: {
    onSelectDriver(value) {
      this.driver = value;
      this.form.driver_id = value.driver_id;
      this.form.car_id = value.car_id;
      this.car = this.cars.find(item => item.car_id === value.car_id);
      this.onSelectCar(this.car)
    },
    onSelectCar(value) {
      this.car = value;
      this.form.car_id = value.car_id;
      this.route = this.routes.find(item => item.id === parseInt(value.route_id));
      this.onSelectRoute(this.route)
    },
    onSelectRoute(value) {
      this.route = value;
      this.form.route_id = value.id;
    },
    getDrivers() {
      let promise = this.$http.get(this.$api(this.baseApi + "drivers"));
      return promise
        .then(response => {
          this.drivers = response.data;
          return response.data;
        })
        .catch(error => {
          this.drivers = [
            { id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }
          ];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    getCars() {
      let promise = this.$http.get(this.$api(this.baseApi + "cars"));
      return promise
        .then(response => {
          this.cars = response.data;
          return response.data;
        })
        .catch(error => {
          this.cars = [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    getRoutes() {
      let promise = this.$http.get(this.$api(this.baseApi + "routes"));
      return promise
        .then(response => {
          this.routes = response.data;
          return response.data;
        })
        .catch(error => {
          this.routes = [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
          return [{ id: 0, fname: "خطا اطلاعات دریافت نشد", lname: "" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      let promise = this.$http.post(
        this.$api(this.baseApi + "turn-list"),
        this.form
      );
      promise
        .then(response => {
          console.error(response);
          this.$router.push(this.$route.query.redirect || this.baseUrl);
        })
        .catch(error => {
          this.isAlert = this.dismissSecs;
          console.error("Dashboard Error : " + error);
        });
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.travel_type_id = null;
      this.form.code = null;
      this.form.pages = 100;
      this.form.of = null;
      this.form.to = null;
      this.form.status = 1;
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
    routeLabel(value) {
      return value.route_code + " - " + value.name;
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedEdited(dismissCountDown) {
      this.isEdited = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    }
  }
};
</script>