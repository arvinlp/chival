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
                <span v-if="isEdit"
                  >ویرایش قرارداد همکاری با شرکت « {{ form.partner }} »</span
                >
                <span v-else>اطلاعات همکاری</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100"
                  >بازگشت</router-link
                >
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">شماره قرارداد</label>
                <div class="col-11">
                  <input
                    type="text"
                    v-model.trim="form.number"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تاریخ پایان قرارداد</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.expire_date"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت همکار</label>
                <b-col cols="10">
                  <multiselect
                    v-model="partner_id"
                    label="name"
                    track-by="id"
                    placeholder="مقصد را انتخاب کنید."
                    open-direction="bottom"
                    :options="companies"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @change="onSelectPartner"
                    @select="onSelectPartner"
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
        </div>
      </b-col>
      <b-col v-if="!isEdit" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>معرفی شرکت همکار به شیوال</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام شرکت</label>
                <div class="col-10">
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
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مقصد</label>
                <b-col cols="10">
                  <multiselect
                    v-model="destination_id"
                    label="name"
                    :custom-label="destinationLabel"
                    track-by="id"
                    placeholder="محل شرکت را انتخاب کنید."
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
                <div class="col-12">
                  <small class="text-muted"
                    >محل قرار گرفتن شرکت را انتخاب کنید این بخش جهت هماهنگی با سامانه های
                    راهداری کل کشور می باشد.</small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تلفن تماس</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.number="form.tel"
                    placeholder="02100000000‬"
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تلفن همراه</label>
                <b-col cols="10">
                  <input
                    type="number"
                    v-model.number="form.mobile"
                    placeholder="0900000000"
                    class="form-control"
                    lang="fa"
                  />
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">استان</label>
                <div class="col-10">
                  <multiselect
                    v-model="province"
                    label="name"
                    track-by="id"
                    placeholder="استان را انتخاب کنید."
                    open-direction="bottom"
                    :options="provinces"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectProvince"
                    @change="onSelectProvince"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
                <div class="col-12">
                  <small class="text-muted">تکمیل این بخش اجباری نمی باشد.</small>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهر</label>
                <div class="col-10">
                  <multiselect
                    v-model="county"
                    label="name"
                    track-by="id"
                    placeholder="شهر را انتخاب کنید."
                    open-direction="bottom"
                    :options="counties"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectCounty"
                    @change="onSelectCounty"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
                <div class="col-12">
                  <small class="text-muted">تکمیل این بخش اجباری نمی باشد.</small>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهرستان</label>
                <div class="col-10">
                  <multiselect
                    v-model="city"
                    label="name"
                    track-by="id"
                    placeholder="شهرستان را انتخاب کنید."
                    open-direction="bottom"
                    :options="cities"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectCity"
                    @change="onSelectCity"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
                <div class="col-12">
                  <small class="text-muted">تکمیل این بخش اجباری نمی باشد.</small>
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
        <button type="submit" class="btn btn-success w-50">ثبت</button>
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
        partner_id: null,
        expire_date: null,
        number: null,
        file: null,
      },
      destinations: [],
      provinces: [],
      counties: [],
      cities: [],
      destination_id: null,
      province: null,
      county: null,
      city: null,

      showModal: false,
      isEdit: false,
      isLoading: false,

      companies: [],
      partner_id: null,

      baseUrl: { name: "client-partnears" },
      api: "api/v1/client/partnears",

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
  computed: {
    getUserData: function () {
      return this.$store.getters.user;
    },
  },
  mounted() {
    this.getCompanies();
    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(this.$api(this.api + "/" + this.$route.params.id));

      promise
        .then((response) => {
          this.form = response.data;
          this.partner_id = {
            id: response.data.partner_id,
            name: response.data.partner,
          };
        })
        .catch((error) => {
          console.error("Get Update Data Error : " + error);
        });
    } else {
      this.getDestination();
      this.getProvinces();
    }
  },
  methods: {
    onSelectPartner(value) {
      this.partner_id = value;
      this.form.partner_id = value.id;
    },
    onSelectDestination(value) {
      this.destination_id = value;
      this.form.rmto_city = value.id;
    },
    onSelectProvince(value) {
      this.form.province = parseInt(value.id);
      this.province = parseInt(value.id);
      this.county = null;
      this.city = null;
      this.getCounties(parseInt(value.id));
    },
    onSelectCounty(value) {
      this.form.county = parseInt(value.id);
      this.county = parseInt(value.id);
      this.city = null;
      this.getCities(parseInt(value.id));
    },
    onSelectCity(value) {
      this.city = parseInt(value.id);
      this.form.city = parseInt(value.id);
      this.getCompanies(parseInt(value.id));
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
    getProvinces() {
      let promise = this.$http.get(this.$api("api/v1/client/core/provinces"));
      return promise
        .then((response) => {
          this.provinces = response.data;
          return response.data;
        })
        .catch((error) => {
          this.provinces = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/client/core/counties/" + province)
        );
        return promise
          .then((response) => {
            this.counties = response.data;
            if (this.isEdit)
              this.county = this.counties.find((item) => item.id === this.form.county);
            return response.data;
          })
          .catch((error) => {
            this.counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/client/core/cites/" + county));
        return promise
          .then((response) => {
            this.cities = response.data;
            if (this.isEdit)
              this.city = this.cities.find((item) => item.id === this.form.city);
            return response.data;
          })
          .catch((error) => {
            this.cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.cities = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCompanies() {
      let promise = this.$http.get(this.$api("api/v1/client/companies"));
      return promise
        .then((response) => {
          this.companies = response.data;
          return response.data;
        })
        .catch((error) => {
          this.companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api(this.api + "/" + this.$route.params.id),
          this.form
        );

        promise
          .then((response) => {
            this.isEdited = this.dismissSecs;
            this.$router.push(this.$route.query.redirect || this.baseUrl);
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
            console.error(response);
            this.$router.push(this.$route.query.redirect || this.baseUrl);
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
      }
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.partner_id = null;
      this.form.expire_date = null;
      this.form.number = null;
      this.partner_id = null;
      this.$nextTick(() => {
        this.show = true;
      });
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
