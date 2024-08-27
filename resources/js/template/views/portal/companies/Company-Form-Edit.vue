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
                <span>ویرایش اطلاعات حقوقی شرکت {{form.name}}</span>
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
                    @uploaded="handleUploaded"
                    @uploading="handleUploading"
                    trigger="#pick-img"
                    :upload-url="uploadImageURL"
                    :upload-headers="this.setAuthorize()"
                    :labels="{ submit: 'تایید', cancel: 'انصراف'}"
                    v-if="form.company_code != null"
                  />
                  <img class="profile" v-if="form.img" :src="form.img" />
                  <span id="pick-img" class="profile_placeholder">
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
                    v-model.trim="form.mobile"
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
                <span>تغییر مدیر عامل شرکت</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مدیر عامل</label>
                <b-col cols="10">
                  <multiselect
                    v-model="manager"
                    :custom-label="selectCustomLabelUser"
                    track-by="id"
                    placeholder="مدیر عامل را انتخاب کنید."
                    open-direction="bottom"
                    :options="users"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectUser"
                    @change="onSelectUser"
                  >
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
                <label class="col-2 col-form-label">توضیحات</label>
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
        name: "",
        tell: "",
        mobile: "",
        postal_code: "",
        address: "",
        province: null,
        county: null,
        city: null,
        img: "",
        code: null,
        status: 1,
        manager_id: 0,
        note: "-"
      },
      file_location: "/logos/company/",
      uploadImageURL: this.$api("api/v1/portal/upload"),
      showModal: false,
      isEdit: false,
      isLoading: false,
      worktimes: [],
      roles: [],
      provinces: [],
      counties: [],
      cities: [],
      users:[],
      role_id: null,
      province: null,
      county: null,
      city: null,
      manager: null,

      dismissSecs: 5,
      isEdited: 0,
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
    if (this.$route.params.id) {
      this.getProvinces();
      this.getUsers();
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api("api/v1/portal/companies/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.form = response.data;
          this.getCounties(response.data.province);
          this.getCities(response.data.county);
          this.getDataProvince(response.data.province);
          this.getDataCounty(response.data.county);
          this.getDataCity(response.data.city);
          this.manager = response.data.company_manager;
          this.file_location = "/company/" + response.data.folder + "/logo/";
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    } else {
      this.$router.push(this.$route.query.redirect || "/portal/companies/new");
    }
  },
  methods: {
    onSelectUser(value) {
      this.form.manager_id = value.id;
    },
    onSelectProvince(value) {
      let val = value.id;
      this.form.province = val;
      this.form.county = null;
      this.form.city = null;
      this.county = null;
      this.city = null;
      this.getCounties(value.id);
    },
    onSelectCounty(value) {
      let val = value.id;
      this.form.county = val;
      this.form.city = null;
      this.city = null;
      this.getCities(value.id);
    },
    onSelectCity(value) {
      let val = value.id;
      this.form.city = val;
    },
    getUsers() {
      let promise = this.$http.get(
        this.$api(
          "api/v1/portal/companies/" + this.$route.params.id + "/users/list"
        )
      );
      return promise
        .then(response => {
          this.users = response.data;
          return response.data;
        })
        .catch(error => {
          this.users = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
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
    getDataProvince(city) {
      let promise = this.$http.get(
        this.$api("api/v1/core/city/province/" + city)
      );
      promise
        .then(response => {
          this.province = response.data;
        })
        .catch(error => {
          this.province = [{ id: 0, name: "-----" }];
        });
    },
    getDataCounty(city) {
      let promise = this.$http.get(
        this.$api("api/v1/core/city/county/" + city)
      );
      promise
        .then(response => {
          this.county = response.data;
        })
        .catch(error => {
          this.county = [{ id: 0, name: "-----" }];
        });
    },
    getDataCity(city) {
      let promise = this.$http.get(this.$api("api/v1/core/city/city/" + city));
      promise
        .then(response => {
          this.city = response.data;
        })
        .catch(error => {
          this.city = [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      let promise = this.$http.put(
        this.$api("api/v1/portal/companies/" + this.$route.params.id),
        this.form
      );
      promise
        .then(response => {
          this.isEdited = this.dismissSecs;
        })
        .catch(error => {
          this.isAlert = this.dismissSecs;
          console.error("Dashboard Error : " + error);
        });
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.name = "";
      this.form.tell = "";
      this.form.mobile = "";
      this.form.postal_code = "";
      this.form.address = "";
      this.form.province = null;
      this.form.county = null;
      this.form.city = null;
      this.form.note = "-";
      this.form.company_code = null;
      this.form.status = 1;
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
    handleUploading(form, xhr) {
      if (this.form.img != "") form.append("old_file", this.form.img);
      form.append("file_location", this.file_location);
    },
    handleUploaded(response, form, xhr) {
      this.form.img = this.$asestUrl(response.data.file);
    },
    selectCustomLabelUser({ fname, lname }) {
      if (fname && lname) return `${fname} ${lname}`;
      return "انتخاب مدیر عامل";
    }
  }
};
</script>