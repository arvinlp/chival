<template>
  <b-overlay :show="showLoading" variant="transparent" rounded="sm">
    <section class="page" @before-leave="close()">
      <b-alert :show="alert.show" fade :variant="alert.type">
        <div>{{ alert.content }}</div>
      </b-alert>
      <b-form @submit="onSubmit" class="row mb-5" @reset="onReset">
        <b-col cols="12">
          <div class="inner-second">
            <b-row class="note" v-if="travel.turn_list.status >= 95">
              <p>
                - ۱ : وسیله نقلیه دارای مسافر می باشد، با کلیک بر روی صندلی های گرفته شده،
                مشخصات مسافر مربوط را وارد نمایید. - ۲ : در زمان تکمیل شدن تمامی صندلی ها
                تکمیل شوند سرویس به صورت خودکار به صفحه صورت وضعیت منتقل می گردد. - ۳ : در
                زمانی که سرویس دارای صندلی خالی باشد،‌ سرویس به صفحه بلیط فروشی منتقل و با
                رنگ سبز مشخص می گردد.
              </p>
            </b-row>
          </div>
          <b-col cols="12" class="text-left mb-3 p-0">
            <router-link :to="{ name: 'client-ticket' }" class="btn btn-danger w-25">
              بازگشت
            </router-link>
          </b-col>
        </b-col>
        <b-col cols="3">
          <b-row>
            <SellingShow
              :cell="12"
              :item="travel"
              :form="form.passengers"
              class="single-ticket"
              @selectSeat="selectSeat"
            />
          </b-row>
          <b-row>
            <b-col cols="12">
              <div class="inner-main">
                <div class="inner-header">
                  <b-row>
                    <b-col class="text-center">
                      <span>راهنما</span>
                    </b-col>
                  </b-row>
                </div>
                <b-row class="inner-body">
                  <b-col cols="12">
                    <p class="text-center">
                      رنگ قرمز : مسافر خانم<br />
                      رنگ آبی : مسافر آقا<br />
                      حاشیه زرد : کودک همراه
                    </p>
                  </b-col>
                </b-row>
              </div>
            </b-col>
          </b-row>
        </b-col>
        <b-col cols="9">
          <b-row>
            <b-col cols="12" v-for="seat in travel.chairs_number" v-bind:key="seat">
              <div class="inner-main" v-if="showSeat == seat">
                <div class="inner-header">
                  <b-row>
                    <b-col class="text-center">
                      <button
                        type="submit"
                        v-on:click="
                          (form.status = 1),
                            (print_status = true),
                            (print_number = seat - 1)
                        "
                        class="btn btn-reset w-100"
                      >
                        چاپ بیلط
                      </button>
                    </b-col>
                    <b-col class="text-center">
                      <span>صندلی شماره {{ seat }}</span>
                    </b-col>
                    <b-col class="text-center">
                      <button
                        type="submit"
                        class="btn btn-success w-100"
                        v-on:click="form.status = 1"
                      >
                        ذخیره صندلی
                      </button>
                    </b-col>
                  </b-row>
                </div>
                <b-row class="inner-body">
                  <b-col cols="12">
                    <div class="form-group row align-items-center">
                      <label class="col-1 col-form-label">کد ملی</label>
                      <div class="col">
                        <input
                          type="number"
                          v-model.trim="form.passengers[seat - 1].nation_code"
                          placeholder="کد ملی را وارد کنید"
                          class="form-control"
                          lang="fa"
                          v-on:click="seatPriceUpdate(seat - 1)"
                        />
                      </div>
                      <div class="col-3 d-none">
                        <b-button
                          variant="primary"
                          v-on:click="getPassengerInfo(seat - 1)"
                        >
                          بررسی
                        </b-button>
                      </div>
                    </div>
                  </b-col>
                </b-row>
                <b-row class="inner-body">
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col col-form-label">نام</label>
                      <div class="col-9">
                        <input
                          type="text"
                          v-model.trim="form.passengers[seat - 1].fname"
                          placeholder="مشخصات را به درستی وارد کنید."
                          class="form-control"
                          lang="fa"
                        />
                      </div>
                    </div>
                  </b-col>
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col col-form-label">نام خانوادگی</label>
                      <div class="col-9">
                        <input
                          type="text"
                          v-model.trim="form.passengers[seat - 1].lname"
                          placeholder="مشخصات را به درستی وارد کنید."
                          class="form-control"
                          lang="fa"
                        />
                      </div>
                    </div>
                  </b-col>
                </b-row>
                <b-row class="inner-body">
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col col-form-label">موبایل</label>
                      <div class="col-9">
                        <input
                          type="number"
                          v-model.trim="form.passengers[seat - 1].mobile"
                          placeholder="۰۹۰۰۰۰۰۰۰۰۰"
                          class="form-control"
                          lang="fa"
                        />
                      </div>
                    </div>
                  </b-col>
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col col-form-label">توشه اضافی/کرایه داخل شهر</label>
                      <div class="col-9">
                        <currency-input
                          v-model="form.passengers[seat - 1].package"
                          placeholder="مبلغ توشه اضافی را وارد نمایید."
                          class="form-control"
                          lang="fa"
                          v-on:change="changeTotalAmount(seat - 1)"
                        />
                      </div>
                    </div>
                  </b-col>
                </b-row>
                <b-row class="inner-body">
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col-4 col-form-label">جنسیت</label>
                      <b-col cols="4" class="form-radio-datamis">
                        <input
                          :id="`Male-${seat - 1}`"
                          type="radio"
                          v-model="form.passengers[seat - 1].sex"
                          :value="0"
                          class="form-radio-input"
                        />
                        <label class="form-radio-label" :for="`Male-${seat - 1}`">
                          <span></span>مرد
                        </label>
                      </b-col>
                      <b-col cols="4" class="form-radio-datamis">
                        <input
                          :id="`Female-${seat - 1}`"
                          type="radio"
                          v-model="form.passengers[seat - 1].sex"
                          :value="1"
                          class="form-radio-input"
                        />
                        <label class="form-radio-label" :for="`Female-${seat - 1}`">
                          <span></span>زن
                        </label>
                      </b-col>
                    </div>
                  </b-col>
                  <b-col cols="6">
                    <div class="form-group row align-items-center">
                      <label class="col-3 col-form-label">
                        کودک همراه {{ childNumber }}
                      </label>
                      <b-col cols="3" class="form-radio-datamis">
                        <input
                          :id="`HaveNotChild-${seat - 1}`"
                          type="radio"
                          v-model="form.passengers[seat - 1].child_number"
                          :value="0"
                          class="form-radio-input"
                          v-on:change="countChild(0, seat - 1)"
                        />
                        <label class="form-radio-label" :for="`HaveNotChild-${seat - 1}`">
                          <span></span>ندارد
                        </label>
                      </b-col>
                      <b-col cols="3" class="form-radio-datamis">
                        <input
                          :id="`HaveChild-${seat - 1}-1`"
                          type="radio"
                          v-model="form.passengers[seat - 1].child_number"
                          :value="1"
                          v-on:change="countChild(1, seat - 1)"
                          :disabled="childNumber > 2"
                          class="form-radio-input"
                        />
                        <label class="form-radio-label" :for="`HaveChild-${seat - 1}-1`">
                          <span></span>1
                        </label>
                      </b-col>
                      <!-- <b-col cols="3" class="form-radio-datamis">
                      <input
                        :id="`HaveChild-${seat - 1}-2`"
                        type="radio"
                        v-model="form.passengers[seat - 1].child_number"
                        :value="2"
                        v-on:change="countChild(2, seat - 1)"
                        class="form-radio-input"
                        :disabled="childNumber > 2"
                      />
                      <label class="form-radio-label" :for="`HaveChild-${seat - 1}-2`">
                        <span></span>2
                      </label>
                    </b-col> -->
                    </div>
                  </b-col>
                </b-row>
                <b-row
                  class="inner-body"
                  v-if="form.passengers[seat - 1].have_parent == 0"
                >
                  <b-col cols="12">
                    <div class="form-group row align-items-center">
                      <label class="col-2 col-form-label">صندلی همراه</label>
                      <template v-for="(seat_number, iindex) in travel.chairs_number">
                        <template v-if="form.passengers[iindex].other_seats.length == 0">
                          <b-col
                            v-bind:key="iindex"
                            cols="3"
                            class="form-checkbox-datamis text-right"
                            v-if="seat != seat_number"
                          >
                            <b-button
                              v-on:click="addSeatToOtherSeats(seat - 1, seat_number)"
                              :variant="
                                form.passengers[iindex].have_parent == 0
                                  ? `reset`
                                  : `success`
                              "
                            >
                              صندلی شماره ( {{ seat_number }} )
                            </b-button>
                          </b-col>
                        </template>
                      </template>
                    </div>
                  </b-col>
                </b-row>
                <b-row class="inner-body">
                  <b-col cols="12" class="text-center">
                    <p>
                      <span v-if="form.passengers[seat - 1].have_parent != 1">
                        مبلغ قابل پرداخت :
                        {{ form.passengers[seat - 1].total_amount }} ریال
                      </span>
                      <span v-else> پرداخت توسط مسافر اصلی می باشد. </span>
                    </p>
                  </b-col>
                </b-row>
              </div>
            </b-col>
            <b-col cols="12" v-if="form.passengers.length > 0">
              <div class="inner-main">
                <div class="inner-header">
                  <b-row>
                    <b-col class="text-center">
                      <span>لیست مسافران</span>
                    </b-col>
                  </b-row>
                </div>
                <b-row class="inner-body">
                  <b-col cols="12">
                    <div class="form-group row align-items-center">
                      <b-col cols="1" class="text-center">صندلی</b-col>
                      <b-col cols="2" class="text-center">نام</b-col>
                      <b-col cols="3" class="text-center">نام خانوادگی</b-col>
                      <b-col cols="2" class="text-center">موبایل</b-col>
                      <b-col cols="1" class="text-center">جنسیت</b-col>
                      <b-col cols="1" class="text-center">کودک</b-col>
                      <b-col cols="2" class="text-center">پرداخت</b-col>
                    </div>
                  </b-col>
                </b-row>
                <b-row
                  class="inner-body"
                  v-for="(passenger, index) in form.passengers"
                  v-bind:key="index"
                >
                  <b-col v-if="passenger.lname != null" cols="12">
                    <div class="form-group row align-items-center">
                      <b-col cols="1" class="text-center">
                        {{ passenger.seat_number }}
                      </b-col>
                      <b-col cols="2" v-if="passenger.fname != null" class="text-center">
                        {{ passenger.fname }}
                      </b-col>
                      <b-col cols="2" v-else class="text-center">-</b-col>
                      <b-col cols="3" v-if="passenger.lname != null" class="text-center">
                        {{ passenger.lname }}
                      </b-col>
                      <b-col cols="3" v-else class="text-center">-</b-col>
                      <b-col cols="2" v-if="passenger.mobile != null" class="text-center">
                        <a :href="`tel:` + passenger.mobile">{{ passenger.mobile }}</a>
                      </b-col>
                      <b-col cols="2" v-else class="text-center">-</b-col>
                      <b-col cols="1" v-if="passenger.sex == 0" class="text-center">
                        مرد
                      </b-col>
                      <b-col cols="1" v-else-if="passenger.sex == 1" class="text-center"
                        >زن
                      </b-col>
                      <b-col cols="1" v-else class="text-center">-</b-col>
                      <b-col
                        cols="1"
                        v-if="passenger.child_number > 0"
                        class="text-center"
                      >
                        {{ passenger.child_number }}
                      </b-col>
                      <b-col cols="1" v-else class="text-center">-</b-col>
                      <b-col
                        cols="2"
                        class="text-center"
                        v-if="passenger.id != undefined"
                      >
                        <PaymentModal
                          v-if="passenger.have_parent == 0"
                          :modalID="`passengerPay` + index"
                          :passenger="passenger"
                          :travel="travel"
                        />
                        <small v-else>مسافر همراه</small>
                      </b-col>
                      <b-col cols="2" class="text-center" v-else>
                        <small> اطلاعات را ذخیره کنید </small>
                      </b-col>
                    </div>
                  </b-col>
                </b-row>
              </div>
            </b-col>
          </b-row>
        </b-col>
      </b-form>
      <PrintModal :travel="travel" :seat="seat" :ItemHandler="PrintHandlerItem.base" />
    </section>
    <template #overlay>
      <div class="loading">
        <b-icon :icon="loading.icon" font-scale="3" animation="cylon"></b-icon>
        <p id="cancel-label" class="label">
          {{ loading.label }}<span animation="cylon"> ... </span>
        </p>
      </div>
    </template>
  </b-overlay>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import SellingShow from "../../../components/SellingShow";
import PrintModal from "../../../components/modal-forms/selling/PrintModal";
import PaymentModal from "../../../components/modal-forms/selling/Payment";

export default {
  data() {
    return {
      form: {
        passengers: [],
        status: 0,
      },
      showLoading: true,
      travel_id: null,
      set_travel_status: {
        type: "selling",
        flag: false,
      },
      travel: {
        driver_info: {
          fname: null,
          lname: null,
          mobile: null,
        },
        car_info: {
          plate_series: null,
          plate_series_1: null,
          plate_series_2: null,
          plate_series_3: null,
        },
        turn_list: {
          status: 0,
        },
      },
      other_seats: {},
      showSeat: null,
      type: 0,
      childNumber: 0,
      baseUrl: { name: "client-ticket" },
      api_passenger: "api/v1/client/travels/check-passenger/",
      api: "api/v1/client/travels/selling-list/",

      alert: {
        show: false,
        content: null,
        type: "success",
        sec: 5,
      },
      seat: {},
      PrintHandlerItem: {
        base: {
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
      },
      loading: {
        label: "در حال دریافت اطلاعات",
        icon: "stopwatch",
      },
    };
  },

  components: {
    Body,
    CardProgress,
    SellingShow,
    PrintModal,
    PaymentModal,
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
    getUserData: function () {
      return this.$store.getters.user;
    },
  },
  created() {
    this.travel_id = this.$route.params.id;
    this.setTravelStatus();
    this.getSeats();
    window.beforeunload = this.handler;
  },
  beforeDestroy() {
    window.beforeunload = this.handler;
    this.setTravelStatus();
    clearInterval(this.timer);
  },
  mounted() {},
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    addSeatToOtherSeats(parent, seat_number) {
      var elParent = this.form.passengers[parent];
      if (elParent.lname == null) {
        this.$notify({
          group: "warning",
          text: "ابتدا اطلاعات مسافر اصلی را وارد نمایید",
          type: "error",
          duration: 10000,
        });
        return null;
      }
      var seatItem = elParent.other_seats.find((item) => item === seat_number);
      var elChild = this.form.passengers.find(
        (item) => item.seat_number === parseInt(seat_number)
      );

      if (seatItem == undefined) {
        elParent.other_seats.push(seat_number);

        elChild.fname = elParent.fname;
        elChild.have_parent = 1;
        elChild.lname = elParent.lname;
        elChild.mobile = elParent.mobile;
        elChild.sex = elParent.sex;
        elChild.nation_code = elParent.nation_code;
      } else {
        let index = elParent.other_seats.indexOf(seatItem);
        if (index > -1) {
          elParent.other_seats.splice(index, 1);
        }

        elChild.have_parent = 0;
        elChild.fname = null;
        elChild.lname = null;
        elChild.mobile = null;
        elChild.sex = null;
        elChild.nation_code = null;
      }
      this.changeTotalAmount(parent, true);
    },
    changeTotalAmount(seat_number = -1, selected = false, showNotify = true) {
      if (seat_number < 0) {
        this.$notify({
          group: "error",
          text: "صندلی به درستی انتخاب نشده است",
          type: "error",
          duration: 10000,
        });
      }
      var seatPrice = parseInt(this.travel.seat_prices[seat_number].passenger);
      var packagePrice = parseInt(this.form.passengers[seat_number].package);

      var extraPrice = parseInt(this.travel.static_price);
      this.form.passengers[seat_number].amount = seatPrice;
      var totalAmount = seatPrice + extraPrice + packagePrice;

      if (selected) {
        var el = this.form.passengers[seat_number];
        if (el.other_seats.length > 0) {
          for (var i = 0; i < el.other_seats.length; i++) {
            if (el.other_seats[i] != undefined) {
              var ab = this.form.passengers.find(
                (item) => item.seat_number === parseInt(el.other_seats[i])
              );

              if (ab.total_amount > ab.amount) {
                ab.total_amount = ab.amount;
              }
              totalAmount += parseInt(ab.total_amount);
            }
          }
        }
      }

      this.form.passengers[seat_number].total_amount = totalAmount;
      if (showNotify) {
        this.$notify({
          group: "warning",
          text: "مبلغ قابل پرداخت : " + totalAmount,
          type: "success",
          duration: 5000,
        });
      }
    },
    modalHandler() {
      this.PrintHandlerItem.base.title = "پیش نمایش چاپ بیلط مسافر صندلی ";
      this.PrintHandlerItem.base.show = true;
    },
    selectSeat(evt) {
      if (this.seat != this.form.passengers[evt.seat_number - 1]) {
        this.seat = this.form.passengers[evt.seat_number - 1];
        this.showSeat = evt.seat_number;
        this.form.passengers.forEach((element) => {
          element.selected = 0;
          if (element.lname == null) {
            this.childNumber -= element.child_number;
            element.child_number = 0;
            element.sex = -1;
          }
        });
        if (this.form.passengers[evt.seat_number - 1].selected != 1) {
          this.form.passengers[evt.seat_number - 1].selected = 1;
          if (this.form.passengers[evt.seat_number - 1].have_parent == 0) {
            this.changeTotalAmount(evt.seat_number - 1, true, false);
          } else {
            this.changeTotalAmount(evt.seat_number - 1, false, false);
          }
        }
      } else {
        this.seat = undefined;
        this.showSeat = undefined;
        if (this.form.passengers[evt.seat_number - 1].selected == 1) {
          this.form.passengers[evt.seat_number - 1].selected = 0;
        }
      }
    },
    countChild(value, seat_number) {
      if (value === 1) {
        this.childNumber += 1;
      } else if (value === 2) {
        this.childNumber += 2;
      } else if (value === 0) {
        if (this.childNumber > 0)
          this.childNumber -= this.form.passengers[seat_number].child_number;
      }
      if (this.childNumber > 2) {
        this.$notify({
          group: "error",
          text: "خطا در هر وسیله نقیله فقط امکان حضور دو کودک مجاز می باشد!",
          type: "error",
          duration: 10000,
        });
        this.childNumber -= value;
        this.form.passengers[seat_number].child_number = 0;
        return 0;
      } else {
        this.form.passengers[seat_number].child_number = value;
        return value;
      }
    },
    getPassengerInfo(seat_number) {
      if (!this.form.passengers[seat_number].nation_code) return null;

      let promise = this.$http.get(
        this.$api(this.api_passenger + this.form.passengers[seat_number].nation_code)
      );
      this.showLoading = true;

      return promise
        .then((response) => {
          this.form.passengers[seat_number].nation_code = response.data.nation_code;
          this.form.passengers[seat_number].fname = response.data.fname;
          this.form.passengers[seat_number].lname = response.data.lname;
          this.form.passengers[seat_number].mobile = response.data.mobile;
          this.form.passengers[seat_number].sex = response.data.sex;
          this.form.passengers[seat_number].parent_id = response.data.parent_id;
          this.form.passengers[seat_number].have_parent = 0;
          if (response.data.parent_id != null)
            if (response.data.parent_id > 0)
              this.form.passengers[seat_number].have_parent = 1;
          this.form.passengers[seat_number].selected = 0;
          this.form.passengers[seat_number].other_seats_status = [];
          this.form.passengers[seat_number].other_seats = [];
        })
        .catch((error) => {
          console.error("Error : " + error);
          return [];
        })
        .finally(() => (this.showLoading = false));
    },
    getSeats() {
      let promise = this.$http.get(this.$api(this.api + this.travel_id));
      this.showLoading = true;

      return promise
        .then((response) => {
          this.travel = response.data;
          this.travel.chairs_number = parseInt(response.data.chairs_number);
          this.childNumber = response.data.child_number;
          this.form.passengers = [];
          var travel_passengers_number = response.data.travel_passengers.length;

          for (var i = 0; i < response.data.chairs_number; i++) {
            // var insurance_body_for_passenger =
            //   parseInt(response.data.insurance_body) /
            //   response.data.chairs_number;
            if (response.data.seat_prices[i] != undefined) {
              var tax = parseInt(response.data.seat_prices[i].tax);
              var commission = parseInt(response.data.seat_prices[i].commission);
              var price = parseInt(response.data.seat_prices[i].price);
              var seatPrice = parseInt(response.data.seat_prices[i].passenger); // +
              // parseInt(response.data.seat_prices[i].tax) +
              // parseInt(response.data.seat_prices[i].commission) +
              // parseInt(response.data.seat_prices[i].price) +
              // parseInt(response.data.insurance_third) +
              // parseInt(insurance_body_for_passenger);
            } else {
              var tax = parseInt(response.data.seat_prices[1].tax);
              var commission = parseInt(response.data.seat_prices[1].commission);
              var price = parseInt(response.data.seat_prices[1].price);
              var seatPrice = parseInt(response.data.seat_prices[1].passenger); // +
            }
            this.form.passengers.push({
              id: null,
              fname: null,
              lname: null,
              mobile: null,
              sex: null,
              nation_code: null,
              child_number: 0,
              seat_number: i + 1,
              tax: tax,
              commission: commission,
              price: price,
              amount: seatPrice,
              total_amount: seatPrice,
              discont: null,
              package_number: 0,
              package: 0,
              selected: 0,
              other_seats: [],
              other_seats_status: [],
              parent_id: 0,
              have_parent: 0,
              extra_price: this.travel.static_price,
            });
          }
          if (travel_passengers_number > 0) {
            for (var i = 0; i < travel_passengers_number; i++) {
              for (var j = i; j < response.data.chairs_number; j++) {
                if (response.data.travel_passengers[i]) {
                  if (
                    parseInt(response.data.travel_passengers[i].seat_number) ===
                    j + 1
                  ) {
                    this.form.passengers[j].id = parseInt(
                      response.data.travel_passengers[i].id
                    );
                    this.form.passengers[j].fname =
                      response.data.travel_passengers[i].fname;
                    this.form.passengers[j].lname =
                      response.data.travel_passengers[i].lname;
                    this.form.passengers[j].mobile =
                      response.data.travel_passengers[i].mobile;
                    this.form.passengers[j].sex = response.data.travel_passengers[i].sex;
                    this.form.passengers[j].nation_code =
                      response.data.travel_passengers[i].nation_code;
                    this.form.passengers[j].child_number = parseInt(
                      response.data.travel_passengers[i].child_number
                    );
                    this.form.passengers[j].seat_number = parseInt(
                      response.data.travel_passengers[i].seat_number
                    );
                    this.form.passengers[j].amount = parseInt(
                      response.data.travel_passengers[i].amount
                    );
                    this.form.passengers[j].total_amount = parseInt(
                      response.data.travel_passengers[i].total_amount
                    );
                    this.form.passengers[j].discont =
                      response.data.travel_passengers[i].discont;
                    this.form.passengers[j].package = parseInt(
                      response.data.travel_passengers[i].package
                    );
                    this.form.passengers[j].package_number = parseInt(
                      response.data.travel_passengers[i].package_number
                    );
                    this.form.passengers[j].other_seats =
                      response.data.travel_passengers[i].other_seats;
                    this.form.passengers[j].parent_id = parseInt(
                      response.data.travel_passengers[i].parent_id
                    );
                    this.form.passengers[j].have_parent = 0;
                    if (this.form.passengers[j].parent_id > 0) {
                      this.form.passengers[j].have_parent = 1;
                    }
                  }
                }
              }
            }
          }
          for (var ii = 0; ii < this.form.passengers.length; ii++) {
            this.changeTotalAmount(ii, true, false);
          }
        })
        .catch((error) => {
          let e = error.response;
          if (e.status != undefined)
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
        })
        .finally(() => (this.showLoading = false));
    },
    setTravelStatus() {
      if (this.set_travel_status.flag) {
        this.set_travel_status.type = "waiting";
      }
      this.set_travel_status.flag = true;
      let promise = this.$http.post(
        this.$api(this.api + "selling/" + this.travel_id),
        this.set_travel_status
      );

      promise
        .then((response) => {
          console.error(response);
        })
        .catch((error) => {
          console.error("Error : " + error);
        });
    },
    seatPriceUpdate(seat_number) {
      var j = 0;
      var insurance_body_for_passenger = 0;
      for (var i = 0; i < this.form.passengers.length; i++) {
        if (this.form.passengers[i].nation_code) {
          j++;
        }
      }
      if (j > 0) {
        insurance_body_for_passenger = parseInt(this.travel.insurance_body) / j;
      }
      var tax = parseInt(this.travel.seat_prices[seat_number].tax);
      var commission = parseInt(this.travel.seat_prices[seat_number].commission);
      var price = parseInt(this.travel.seat_prices[seat_number].price);
      var seatPrice = parseInt(this.travel.seat_prices[seat_number].passenger); // +
      // parseInt(this.travel.seat_prices[seat_number].tax) +
      // parseInt(this.travel.seat_prices[seat_number].commission) +
      // parseInt(this.travel.seat_prices[seat_number].price) +
      // parseInt(this.travel.insurance_third) +
      // parseInt(insurance_body_for_passenger);
      this.form.passengers[seat_number].tax = tax;
      this.form.passengers[seat_number].commission = commission;
      this.form.passengers[seat_number].price = price;
      this.form.passengers[seat_number].amount = seatPrice;
      this.form.passengers[seat_number].total_amount = seatPrice;
    },
    onSubmit(evt) {
      this.showLoading = true;
      this.loading.label = "در حال ذخیره اطلاعات کمی صبر کنید";
      evt.preventDefault();
      var promise = null;
      this.form.turn_list_id = this.travel.turn_list_id;
      for (var ii = 0; ii < this.form.passengers.length; ii++) {
        this.changeTotalAmount(ii, true, false);
        this.form.passengers[ii].extra_price = this.travel.static_price;
      }

      if (this.form.status === 111) {
        promise = this.$http.post(this.$api(this.api + this.travel_id), this.form);
      } else {
        if (this.status === 2) {
          this.set_travel_status.type = "complete";
          this.set_travel_status.flag = false;
        }
        promise = this.$http.post(this.$api(this.api + this.travel_id), this.form);
      }

      promise
        .then(() => {
          if (this.form.status === 1)
            this.$notify({
              group: "error",
              title: "ذخیره اطلاعات",
              text: "اطلاعات فروش این وسیله نقلیه ذخیره شد",
              duration: 10000,
            });
          if (this.print_status == true) {
            this.modalHandler();
          }
          if (this.form.status === 2)
            this.$router.push(this.$route.query.redirect || this.baseUrl);
        })
        .catch((error) => {
          let e = error.response;
          if (e.status != undefined)
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
        })
        .finally(() => (this.showLoading = false));
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.passengers = [];
      for (var i = 0; i < this.travel.chairs_number; i++) {
        var insurance_body_for_passenger =
          parseInt(this.travel.insurance_body) / this.travel.chairs_number;
        var tax = parseInt(this.travel.seat_prices[i].tax);
        var commission = parseInt(this.travel.seat_prices[i].commission);
        var price = parseInt(this.travel.seat_prices[i].price);
        var seatPrice = parseInt(this.travel.seat_prices[i].passenger); // +
        // parseInt(this.travel.seat_prices[i].tax) +
        // parseInt(this.travel.seat_prices[i].commission) +
        // parseInt(this.travel.seat_prices[i].price) +
        // parseInt(this.travel.insurance_third) +
        // parseInt(insurance_body_for_passenger);
        this.form.passengers.push({
          id: null,
          fname: null,
          lname: null,
          mobile: null,
          sex: null,
          nation_code: null,
          child_number: 0,
          seat_number: i + 1,
          tax: tax,
          commission: commission,
          price: price,
          amount: seatPrice,
          total_amount: seatPrice,
          discont: null,
          package_number: 0,
          package: 0,
          selected: 0,
          other_seats: [],
          other_seats_status: [],
          parent_id: 0,
          have_parent: 0,
          extra_price: this.travel.static_price,
        });
      }
    },
    countDownChangedAlert(dismissCountDown) {
      this.alert.show = dismissCountDown;
    },
    close() {
      alert("Leaving...");
      this.set_travel_status.type = "waiting";
      this.setTravelStatus();
    },
  },
};
</script>
