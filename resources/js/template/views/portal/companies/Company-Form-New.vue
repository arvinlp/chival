<template>
  <section class="page">
    <b-alert :show="isAlert" fade variant="danger" @dismiss-count-down="countDownChangedAlert">
      <div>خطای در افزودن رخ داد مجددا سعی نمایید.</div>
    </b-alert>

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات حقوقی شرکت</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link to="/portal/companies" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <div class="pick_profile">
                  <avatar-cropper
                    @uploaded="handleUploadedLogo"
                    @uploading="handleUploadingLogo"
                    trigger="#pick-logo"
                    :upload-url="uploadImageURL"
                    :upload-headers="this.setAuthorize()"
                    :labels="{ submit: 'تایید', cancel: 'انصراف'}"
                    v-if="form.company_code != null"
                  />
                  <img class="profile" v-if="form.logo" :src="form.logo" />
                  <span id="pick-logo" class="profile_placeholder">
                    <i class="fas fa-plus-circle fa-3x"></i>
                    <br />لوگو شرکت را انتخاب کنید.
                    <br />تصویر بهتر است مربع باشد.
                  </span>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">کد ثبت شرکت</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.company_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :disabled="form.logo !== null"
                  />
                </div>
                <label class="col-3 col-form-label">نام</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.name"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-3 col-form-label">تلفن تماس</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.tell"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-3 col-form-label">موبایل</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.company_mobile"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-4 col-form-label">وضعیت دسترسی</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Enable"
                    type="radio"
                    v-model.trim="form.company_status"
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
                    v-model.trim="form.company_status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Disable">
                    <span></span>خارج از دسترس
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات پستی شرکت</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کد پستی</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.postal_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">استان</label>
                <b-col cols="10">
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
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهرستان</label>
                <b-col cols="10">
                  <multiselect
                    v-model="county"
                    label="name"
                    track-by="id"
                    placeholder="شهرستان را انتخاب کنید."
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
                </b-col>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهر</label>
                <b-col cols="10">
                  <multiselect
                    v-model="city"
                    label="name"
                    track-by="id"
                    placeholder="شهر را انتخاب کنید."
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
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">آدرس پستی</label>
                <div class="col-11">
                  <textarea v-model="form.address" class="form-control" />
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
              <b-col cols="11">
                <span>اطلاعات فردی مدیر عامل شرکت</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <div class="pick_profile">
                  <avatar-cropper
                    @uploaded="handleUploaded"
                    @uploading="handleUploading"
                    trigger="#pick-profile"
                    :upload-url="uploadImageURL"
                    :upload-headers="this.setAuthorize()"
                    :labels="{ submit: 'تایید', cancel: 'انصراف'}"
                    v-if="form.company_code != null"
                  />
                  <img class="profile" v-if="form.img" :src="form.img" />
                  <span id="pick-profile" class="profile_placeholder">
                    <i class="fas fa-plus-circle fa-3x"></i>
                    <br />تصویر را انتخاب کنید.
                  </span>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.fname"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-2 col-form-label">نام خانوادگی</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.lname"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-2 col-form-label">کد ملی</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.trim="form.nation_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-2 col-form-label">موبایل</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.mobile"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <label class="col-2 col-form-label">تاریخ تولد</label>
                <b-col cols="10">
                  <date-picker
                    type="date"
                    v-model="form.birthday"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </b-col>
                <label class="col-4 col-form-label">جنسیت</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Male"
                    type="radio"
                    v-model.trim="form.sex"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Male">
                    <span></span>مرد
                  </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Female"
                    type="radio"
                    v-model.trim="form.sex"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Female">
                    <span></span>زن
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات کاربری مدیر عامل</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام کاربری</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.username"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">پست الکترونیک</label>
                <div class="col-9">
                  <input
                    type="email"
                    v-model.trim="form.email"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">گذرواژه</label>
                <div class="col-10">
                  <input
                    type="password"
                    v-model.trim="form.password"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تکرار گذرواژه</label>
                <div class="col-9">
                  <input
                    type="password"
                    v-model.trim="form.password_confirmation"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">سطح کاربری</label>
                <b-col cols="10">
                  <multiselect
                    v-model="role_id"
                    label="name"
                    track-by="id"
                    placeholder="سطح مجاز دسترسی را انتخاب کنید."
                    open-direction="bottom"
                    :options="roles"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectRole"
                    @change="onSelectRole"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
              </div>
            </b-col>
            <b-col cols="6">
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
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">شیفت کاری</label>
                <b-col cols="11">
                  <multiselect
                    v-model="form.work_times"
                    label="name"
                    track-by="id"
                    placeholder="شیفت کاری را انتخاب کنید."
                    open-direction="bottom"
                    :options="worktimes"
                    :multiple="true"
                    :searchable="true"
                    :clear-on-select="false"
                    :close-on-select="false"
                    :internal-search="true"
                    :hide-selected="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
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
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>توضیحات اضافی</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">توضیحات برای شرکت</label>
                <div class="col-10">
                  <textarea v-model="form.note_company" class="form-control" />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">توضیحات برای مدیرعامل شرکت</label>
                <div class="col-10">
                  <textarea v-model="form.note" class="form-control" />
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
import Body from "../../../components/portal/Body";
import CardProgress from "../../../components/CardProgress";
import Modal from "../../../components/Modal";
import AvatarCropper from "vue-avatar-cropper";

export default {
  data() {
    return {
      form: {
        role_id: null,
        fname: "",
        lname: "",
        nation_code: "",
        mobile: "",
        birthday: "",
        email: "",
        username: "",
        password: "",
        password_confirmation: "",
        note: "-",
        img: "",
        file: null,
        sex: 0,
        status: 1,
        work_times: [],

        name: "",
        tell: "",
        company_mobile: "",
        postal_code: "",
        address: "",
        province: null,
        county: null,
        city: null,
        logo: null,
        company_code: null,
        company_status: 1,
        note_company: "-"
      },
      file_location: "/avatars/",
      file_location_logo: "/logos/",
      uploadImageURL: this.$api("api/v1/portal/upload"),
      showModal: false,
      isEdit: false,
      isLoading: false,
      worktimes: [],
      roles: [],
      provinces: [],
      counties: [],
      cities: [],
      role_id: null,
      province: null,
      county: null,
      city: null,

      dismissSecs: 5,
      isAlert: 0
    };
  },

  components: {
    Body,
    CardProgress,
    Modal,
    AvatarCropper
  },

  computed: {
    isType: function() {
      return this.$store.getters.isType;
    }
  },
  mounted() {
    this.getWorkTime();
    this.getRoles();
    this.getProvinces();
  },
  methods: {
    onSelectRole(value) {
      this.form.role_id = value.id;
    },
    onSelectProvince(value) {
      this.form.province = value.id;
      this.form.county = null;
      this.form.city = null;
      this.county = null;
      this.city = null;
      this.getCounties(value.id);
    },
    onSelectCounty(value) {
      this.form.county = value.id;
      this.form.city = null;
      this.city = null;
      this.getCities(value.id);
    },
    onSelectCity(value) {
      this.form.city = value.id;
    },
    getProvinces() {
      let promise = this.$http.get(this.$api("api/v1/core/provinces"));
      return promise
        .then(response => {
          this.provinces = response.data;
          return response.data;
        })
        .catch(error => {
          this.provinces = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/core/counties/" + province)
        );
        return promise
          .then(response => {
            this.counties = response.data;
            return response.data;
          })
          .catch(error => {
            this.counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/core/cites/" + county));
        return promise
          .then(response => {
            this.cities = response.data;
            return response.data;
          })
          .catch(error => {
            this.cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.cities = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getRoles() {
      let promise = this.$http.get(this.$api("api/v1/portal/roles/company"));
      return promise
        .then(response => {
          this.roles = response.data;
          return response.data;
        })
        .catch(error => {
          this.roles = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getWorkTime() {
      let promise = this.$http.get(
        this.$api("api/v1/portal/worktimes/company")
      );
      return promise
        .then(response => {
          this.worktimes = response.data;
          return response.data;
        })
        .catch(error => {
          this.worktimes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      let promise = this.$http.post(
        this.$api("api/v1/portal/companies/new"),
        this.form
      );
      promise
        .then(response => {
          console.error(response);
          this.$router.push(this.$route.query.redirect || "/portal/companies/");
        })
        .catch(error => {
          this.isAlert = this.dismissSecs;
          console.error("Dashboard Error : " + error);
        });
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.role_id = null;
      this.form.fname = "";
      this.form.lname = "";
      this.form.nation_code = "";
      this.form.mobile = "";
      this.form.birthday = "";
      this.form.email = "";
      this.form.username = "";
      this.form.password = "";
      this.form.password_confirmation = "";
      this.form.note = "";
      this.form.sex = 0;
      this.form.status = 1;
      this.form.work_times = [];

      this.form.name = "";
      this.form.tell = "";
      this.form.company_mobile = "";
      this.form.postal_code = "";
      this.form.address = "";
      this.form.province = null;
      this.form.county = null;
      this.form.city = null;
      this.form.note_company = "-";
      this.form.company_code = null;
      this.form.company_status = 1;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    },
    handleUploading(form, xhr) {
      this.file_location = "/company/" + this.form.company_code + "/avatar/";
      if (this.form.img != "") form.append("old_file", this.form.img);
      form.append("file_location", this.file_location);
    },
    handleUploadingLogo(form, xhr) {
      this.file_location_logo = "/company/" + this.form.company_code + "/logo/";
      if (this.form.logo != "") form.append("old_file", this.form.logo);
      form.append("file_location", this.file_location_logo);
    },
    handleUploaded(response, form, xhr) {
      this.form.img = this.$asestUrl(response.data.file);
    },
    handleUploadedLogo(response, form, xhr) {
      this.form.logo = this.$asestUrl(response.data.file);
    }
  }
};
</script>