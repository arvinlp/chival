<template>
  <section class="page">
    <b-alert
      :show="isAlert"
      fade
      variant="danger"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div v-if="isEdit">خطای در ویرایش رخ داد مجددا سعی نمایید.</div>
      <div v-else>خطای در افزودن رخ داد مجددا سعی نمایید.</div>
    </b-alert>
    <b-alert
      :show="isEdited"
      fade
      variant="success"
      @dismiss-count-down="countDownChangedEdited"
      >اطلاعات با موفقیت بروزرسانی شد.</b-alert
    >

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش اطلاعات خط سیر « {{ form.name }} »</span>
                <span v-else>اطلاعات خط سیر</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="{ name: 'client-routes' }" class="btn btn-danger w-100"
                  >بازگشت</router-link
                >
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نام خط</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.name"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کد خط</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.trim="form.route_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    v-on:keyup="check(form.route_code)"
                    min="1"
                    max="100000"
                  />
                </div>
                <div class="col-12" v-if="error != null">
                  <small>{{ error }}</small>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">ابطال خودکار پس از </label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.reject_number"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="0"
                    max="100000"
                  />
                </div>
                <div class="col-12" v-if="error != null">
                  <small>{{ error }}</small>
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">وضعیت دسترسی</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Enable"
                    type="radio"
                    v-model.trim="form.status"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Enable">
                    <span></span>در دسترس
                  </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Disable"
                    type="radio"
                    v-model.trim="form.status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Disable">
                    <span></span>خارج از دسترس
                  </label>
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >در صورتی که نیاز به غیر فعال کردن این مسیر برای مدتی دارید می توانید
                    آن را غیر فعال کنید.</small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نوع وسیله نقلیه</label>
                <b-col cols="9">
                  <multiselect
                    v-model="car_type_id"
                    label="name"
                    track-by="id"
                    placeholder="نوع وسیله نقلیه را انتخاب کنید."
                    open-direction="bottom"
                    :options="carTypes"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @change="onSelectCarType"
                    @select="onSelectCarType"
                  >
                    <template slot="tag" slot-scope="{ option, remove }">
                      <div class="selected">
                        <span>{{ option.name }}</span>
                        <span class="custom__remove" @click="remove(option)">
                          <i class="fas fa-trash"></i>
                        </span>
                      </div>
                    </template>
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مقصد</label>
                <b-col cols="10">
                  <multiselect
                    v-model="destination_id"
                    label="name"
                    :custom-label="destinationLabel"
                    track-by="id"
                    placeholder="مقصد را انتخاب کنید."
                    open-direction="bottom"
                    :options="destinations"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @change="onSelectDestination"
                    @select="onSelectDestination"
                  >
                    <template slot="tag" slot-scope="{ option, remove }">
                      <div class="selected">
                        <span>{{ option.name }}</span>
                        <span class="custom__remove" @click="remove(option)">
                          <i class="fas fa-trash"></i>
                        </span>
                      </div>
                    </template>
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">مسافت</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.distance"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نوع سفر</label>
                <b-col cols="10">
                  <multiselect
                    v-model="travel_type_id"
                    label="name"
                    track-by="id"
                    placeholder="نوع سفر را انتخاب کنید."
                    open-direction="bottom"
                    :options="travelTypes"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @change="onSelectTravelType"
                    @select="onSelectTravelType"
                  >
                    <template slot="tag" slot-scope="{ option, remove }">
                      <div class="selected">
                        <span>{{ option.name }}</span>
                        <span class="custom__remove" @click="remove(option)">
                          <i class="fas fa-trash"></i>
                        </span>
                      </div>
                    </template>
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="SINGLE"
                    type="radio"
                    v-model.trim="pricingType"
                    v-on:click="OnChangePriceType(1)"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="SINGLE">
                    <span></span>قیمت گذاری یکسان برای تمام صندلی ها
                  </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="FIRST_ONE"
                    type="radio"
                    v-model.trim="pricingType"
                    v-on:click="OnChangePriceType(2)"
                    value="2"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="FIRST_ONE">
                    <span></span>فقط صندلی اول متفاوت است
                  </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="MULTIPLE"
                    type="radio"
                    v-model.trim="pricingType"
                    v-on:click="OnChangePriceType(0)"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="MULTIPLE">
                    <span></span>قیمت گذاری انعطاف پذیر
                  </label>
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >«قیمت گذاری یکسان» : با وارد کردن قیمت صندلی اول، قیمت تمامی صندلی ها
                    همانند آن می شود.</small
                  >
                  <small class="text-muted"
                    >«قیمت گذاری فقط صندلی اول متفاوت است» : قیمت گذاری تمامی صندلی ها
                    براساس صندلی دوم انجام می شود و صندلی اول قیمت گذاری جداگانه ای خواهد
                    داشت.</small
                  >
                  <small class="text-muted"
                    >«قیمت گذاری انعطاف پذیر» : قیمت گذاری صندلی ها به صورت جداگانه انجام
                    می شود.</small
                  >
                  <small class="text-danger"
                    >توجه : در زمان ویرایش بهتر است بروی «قیمت گذاری انعطاف پذیر» قرار
                    گیرد تا خطایی در ویرایش اطلاعات شما رخ ندهد.</small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12" v-if="car_capacity">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>شماره صندلی ها</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height" v-if="car_capacity >= 16">
            <b-col cols="3">
              <div class="seat empty">صندلی شماره 1</div>
            </b-col>
            <b-col cols="3">
              <div class="seat empty">صندلی شماره 2</div>
            </b-col>
            <b-col cols="3">
              <div class="seat null"></div>
            </b-col>
            <b-col cols="3">
              <div class="seat driver">راننده</div>
            </b-col>
            <b-col cols="3" v-for="item in car_capacity - 2" v-bind:key="item">
              <div class="seat empty">صندلی شماره {{ item + 2 }}</div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height" v-else-if="car_capacity % 3 == 0">
            <b-col cols="6">
              <div class="seat empty">صندلی شماره 1</div>
            </b-col>
            <b-col cols="6">
              <div class="seat driver">راننده</div>
            </b-col>
            <b-col cols="6" v-for="item in car_capacity - 1" v-bind:key="item">
              <div class="seat empty">صندلی شماره {{ item + 1 }}</div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height" v-else>
            <b-col cols="4">
              <div class="seat empty">صندلی شماره 1</div>
            </b-col>
            <b-col cols="4">
              <div class="seat null"></div>
            </b-col>
            <b-col cols="4">
              <div class="seat driver">راننده</div>
            </b-col>
            <b-col cols="4" v-for="item in car_capacity - 1" v-bind:key="item">
              <div class="seat empty">صندلی شماره {{ item + 1 }}</div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="3" v-if="seatValid">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>نرخ پایه</span>
              </b-col>
            </b-row>
          </div>
          <b-row
            class="inner-body row-eq-height"
            v-for="(item, i) in seatValid"
            v-bind:key="item"
          >
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-12 col-form-label text-center"
                  >نرخ پایه صندلی {{ item }}</label
                >
                <div class="col-12">
                  <currency-input
                    v-model="form.seats[i].price"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />

                  <input type="hidden" v-model="form.seats[i].seat_number" />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="3" v-if="seatValid">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>عوارض شهرداری</span>
              </b-col>
            </b-row>
          </div>
          <b-row
            class="inner-body row-eq-height"
            v-for="(item, i) in seatValid"
            v-bind:key="item"
          >
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-12 col-form-label text-center"
                  >عوارض سرنشین صندلی {{ item }}</label
                >
                <div class="col-12">
                  <currency-input
                    v-model="form.seats[i].tax"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="3" v-if="seatValid">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>کمیسون شرکت</span>
              </b-col>
            </b-row>
          </div>
          <b-row
            class="inner-body row-eq-height"
            v-for="(item, i) in seatValid"
            v-bind:key="item"
          >
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-12 col-form-label text-center"
                  >کمیسون صندلی {{ item }}</label
                >
                <div class="col-12">
                  <currency-input
                    v-model="form.seats[i].commission"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="3" v-if="seatValid">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>کرایه مسافر</span>
              </b-col>
            </b-row>
          </div>
          <b-row
            class="inner-body row-eq-height"
            v-for="(item, i) in seatValid"
            v-bind:key="item"
          >
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-12 col-form-label text-center"
                  >کرایه سرنشین صندلی {{ item }}</label
                >
                <div class="col-12">
                  <currency-input
                    v-model="form.seats[i].passenger"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>تعرفه بیمه</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">بیمه سرنشین</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.trim="form.insurance_passenger"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">بیمه بدنه</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.trim="form.insurance_body"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="6" class="text-right">
        <button type="reset" class="btn btn-reset w-50">پاک کرد فرم</button>
      </b-col>
      <b-col cols="6">
        <button type="submit" :disabled="btnDisabled" class="btn btn-success w-50">
          ثبت
        </button>
      </b-col>
    </b-form>
    <!-- Modal -->
    <Modal
      :v-model="showModal"
      :modalShow="showModal"
      modalTitle="خطا بارگذاری تصویر"
      modalContent="تصویر انتخابی باید مربع باشد ! تصویر انتخابی شما مربع نیست لطفا مجددا سعی کنید."
      modalBtnCancel="متوجه شدم"
    />
    <div v-if="errors">
      <b-alert
        v-for="(value, i) in errors"
        v-bind:key="i"
        show
        fade
        variant="danger"
        dismissible
        >{{ value[0] }}</b-alert
      >
    </div>
    <!-- End -->
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
      form: {
        name: null,
        route_code: null,
        travel_type_id: null,
        destination_id: null,
        distance: null,
        car_type_id: null,
        insurance_passenger: null,
        insurance_body: null,
        reject_number: 3,
        status: 1,
        seats: [],
      },
      errors: [],
      showModal: false,
      isEdit: false,
      isLoading: false,

      //
      btnDisabled: true,
      error: null,
      error2: null,

      travelTypes: [],
      destinations: [],
      carTypes: [],
      travel_type_id: null,
      destination_id: null,
      car_type_id: null,
      seats: [],
      car_capacity: 0,
      seatValid: 0,
      pricingType: 0,

      api: "api/v1/client/routes",

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
    };
  },
  components: {
    Body,
    CardProgress,
    Modal,
    AvatarCropper,
  },
  computed: {},
  mounted() {
    this.getTravelType();
    this.getCarType();
    this.getDestination();

    if (this.$route.params.id) {
      this.isEdit = true;
      this.btnDisabled = false;
      this.getLastData();
    }
  },
  methods: {
    getLastData() {
      let promise = this.$http.get(this.$api(this.api + "/" + this.$route.params.id));

      promise
        .then((response) => {
          this.form = response.data;
          
          this.travel_type_id = {
            id: response.data.travel_type.id,
            name: response.data.travel_type.name,
          };
          if (response.data.destination)
            this.destination_id = {
              id: response.data.destination.id,
              name: response.data.destination.name,
              code: response.data.destination.code,
            };
          // this.onSelectCarType(response.data.car_type)
          this.seats = this.form.seats = response.data.seats;
          if (response.data.seats.length > 0 || response.data.seats.length != undefined) {
            this.onSelectCarType(response.data.car_type, true);
          } else {
            this.onSelectCarType(response.data.car_type, false);
          }
        })
        .catch((error) => {
          console.error("Get Update Data Error : " + error);
        });
    },
    check(value) {
      if (this.isEdit) {
        this.btnDisabled = false;
      } else {
        let promise = this.$http.get(this.$api("api/v1/client/check/route/" + value));

        return promise
          .then((response) => {
            var data = response.data;
            if (data.code == 1) {
              (this.btnDisabled = false), (this.error = null);
            } else {
              (this.btnDisabled = true), (this.error = data.message);
            }
          })
          .catch(() => {
            (this.btnDisabled = false), (this.error = null);
          });
      }
    },
    OnChangePriceType(value) {
      this.pricingType = value;
      switch (parseInt(value)) {
        case 1:
          this.seatValid = 1;
          break;
        case 2:
          this.seatValid = 2;
          break;
        default:
          this.seatValid = this.car_capacity;
          break;
      }
    },
    onSelectTravelType(value) {
      this.travel_type_id = value;
      this.form.travel_type_id = value.id;
    },
    onSelectCarType(value, edit = false) {
      this.car_type_id = value;
      this.form.car_type_id = value.id;
      if (!edit) {
        if (this.form.seats.length == undefined) {
          this.form.seats = [];
        }
        if (this.form.seats.length > 0) {
          this.form.seats = [];
        }
        for (let i = 0; i < value.capacity; i++) {
          this.form.seats.push({
            seat_number: i + 1,
            price: 0,
            tax: 0,
            commission: 0,
            passenger: 0,
          });
        }
      }else{
        if(this.form.seats.length < parseInt(value.capacity)){
          for (let i = this.form.seats.length - 1; i < value.capacity; i++) {
            this.form.seats.push({
              seat_number: i + 1,
              price: 0,
              tax: 0,
              commission: 0,
              passenger: 0,
            });
          }
        }
      }
      console.error(this.form.seats);
      this.car_capacity = parseInt(value.capacity);
      this.OnChangePriceType(0);
    },
    onSelectDestination(value) {
      this.destination_id = value;
      this.form.destination_id = value.id;
    },
    getTravelType() {
      let promise = this.$http.get(this.$api("api/v1/client/core/travel-types/list"));
      return promise
        .then((response) => {
          this.travelTypes = response.data;
          return response.data;
        })
        .catch((error) => {
          this.travelTypes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getCarType() {
      let promise = this.$http.get(this.$api("api/v1/client/core/vehicle-types/list"));
      return promise
        .then((response) => {
          this.carTypes = response.data;
          return response.data;
        })
        .catch((error) => {
          this.carTypes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getDestination() {
      let promise = this.$http.get(this.$api("api/v1/client/core/destinations/list"));
      return promise
        .then((response) => {
          this.destinations = response.data;
          return response.data;
        })
        .catch((error) => {
          this.destinations = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      if (this.pricingType == 1) {
        for (var i = 1; i < this.car_capacity; i++) {
          this.form.seats[i].seat_number = i + 1;
          this.form.seats[i].price = this.form.seats[0].price;
          this.form.seats[i].tax = this.form.seats[0].tax;
          this.form.seats[i].commission = this.form.seats[0].commission;
          this.form.seats[i].passenger = this.form.seats[0].passenger;
        }
      }
      if (this.pricingType == 2) {
        for (var i = 2; i < this.car_capacity; i++) {
          this.form.seats[i].seat_number = i + 1;
          this.form.seats[i].price = this.form.seats[1].price;
          this.form.seats[i].tax = this.form.seats[1].tax;
          this.form.seats[i].commission = this.form.seats[1].commission;
          this.form.seats[i].passenger = this.form.seats[1].passenger;
        }
      }
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api(this.api + "/" + this.$route.params.id),
          this.form
        );

        promise
          .then((response) => {
            this.isEdited = this.dismissSecs;
            this.$router.push(this.$route.query.redirect || { name: "client-routes" });
          })
          .catch((error) => {
            this.isAlert = this.dismissSecs;
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
            console.error("Dashboard Error : " + error);
          });
      } else {
        let promise = this.$http.post(this.$api(this.api + "/new"), this.form);
        promise
          .then((response) => {
            this.$router.push(this.$route.query.redirect || { name: "client-routes" });
          })
          .catch((error) => {
            this.isAlert = this.dismissSecs;
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
      }
    },
    onReset(evt) {
      evt.preventDefault();
      if (this.isEdit) {
        this.getLastData();
        this.$notify({
          group: "warning",
          text: "اطلاعات مجدد بارگزاری شد.",
          type: "warn",
          duration: 10000 + 2 * 1000,
        });
      } else {
        this.form.name = null;
        this.form.route_code = null;
        this.form.travel_type_id = null;
        this.form.destination_id = null;
        this.form.reject_number = 3;
        this.form.car_type_id = null;
        this.form.insurance_passenger = null;
        this.form.insurance_body = null;
        this.form.distance = null;
        this.form.status = 1;
        this.form.seats = [];
        this.travel_type_id = null;
        this.destination_id = null;
        this.car_type_id = null;
        this.seatValid = 0;
        this.$nextTick(() => {
          this.show = true;
        });
      }
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedEdited(dismissCountDown) {
      this.isEdited = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    },
    destinationLabel(value) {
      if (value.code != undefined) return value.code + " - " + value.name;
      return "مقصدی تعریف نشده است";
    },
  },
};
</script>
