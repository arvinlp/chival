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
                  >ویرایش دسته صورت وضعیت « {{ form.partner }} »</span
                >
                <span v-else>اطلاعات دسته صورت وضعیت</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100"
                  >بازگشت</router-link
                >
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">ردیف ثبت</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نوع صورت</label>
                <div class="col-10">
                  <multiselect
                    v-model="travel_type_id"
                    label="name"
                    track-by="id"
                    placeholder="نوع سفر صورت وضعیت را انتخاب کنید."
                    open-direction="bottom"
                    :options="travel_types"
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
                    <span slot="noResult"
                      >موردی یافت نشد مجددا بررسی کنید.</span
                    >
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col col-form-label">سری</label>
                <div class="col-3">
                  <multiselect
                    v-model="form.series1"
                    placeholder="حرف"
                    open-direction="bottom"
                    :options="rmtoChars"
                    :multiple="false"
                    :searchable="true"
                    selectLabel
                    selectedLabel
                    deselectLabel
                  >
                    <span slot="noResult"
                      >موردی یافت نشد مجددا بررسی کنید.</span
                    >
                  </multiselect>
                </div>
                <label class="w-auto col-form-label">/</label>
                <div class="col-3">
                  <input
                    type="number"
                    v-model.number="form.series2"
                    placeholder="۱"
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
                <label class="w-auto col-form-label">/</label>
                <div class="col-3">
                  <input
                    type="number"
                    v-model.number="form.series3"
                    placeholder="۹۹"
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تعداد برگ</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.pages"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                    v-on="setToPage"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">از شماره</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.of"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="0"
                    v-on="setToPage"
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center" v-if="form.pages > 1">
                <label class="col-2 col-form-label">تا شماره</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.to"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="form.of + form.pages"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
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
        travel_type_id: null,
        code: null,
        pages: 100,
        of: null,
        to: null,
        status: 1,
      },
      showModal: false,
      isEdit: false,
      isLoading: false,

      rmtoChars: [
        "آ",
        "ا",
        "ب",
        "پ",
        "ت",
        "ث",
        "ج",
        "چ",
        "ح",
        "خ",
        "د",
        "ذ",
        "ر",
        "ز",
        "ژ",
        "س",
        "ش",
        "ص",
        "ض",
        "ط",
        "ظ",
        "ع",
        "غ",
        "ف",
        "ق",
        "ک",
        "گ",
        "ل",
        "م",
        "ن",
        "و",
        "ه",
        "ی",
        "ئ",
      ],

      travel_types: [],
      travel_type_id: null,

      baseUrl: { name: "client-records" },
      api: "api/v1/client/records",

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
    setToPage: function (value) {
      if (this.form.pages > 1) this.form.to = this.form.pages + this.form.of;
      else this.form.to = this.form.of;
    },
  },
  mounted() {
    this.getTravelTypes();
    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api(this.api + "/" + this.$route.params.id)
      );

      promise
        .then((response) => {
          this.form = response.data;
          this.travel_type_id = this.travel_types.find(
            (item) => item.id === response.data.travel_type_id
          );
        })
        .catch((error) => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
    onSelectTravelType(value) {
      this.travel_type_id = value;
      this.form.travel_type_id = value.id;
    },
    getTravelTypes() {
      let promise = this.$http.get(
        this.$api("api/v1/client/core/travel-types/list")
      );
      return promise
        .then((response) => {
          this.travel_types = response.data;
          return response.data;
        })
        .catch((error) => {
          this.travel_types = [{ id: 0, name: "-----" }];
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
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedEdited(dismissCountDown) {
      this.isEdited = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    },
  },
};
</script>