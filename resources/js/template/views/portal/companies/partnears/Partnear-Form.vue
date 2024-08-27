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
                <span v-if="isEdit">ویرایش قرارداد همکاری دو شرکت « {{form.partner}} و {{form.company}} »</span>
                <span v-else>اطلاعات همکاری</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100">بازگشت</router-link>
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
                <label class="col-2 col-form-label">تاریخ پایان قرارداد</label>
                <div class="col-10">
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
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت اول</label>
                <b-col cols="10">
                  <multiselect
                    v-model="company_id"
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
                    @change="onSelectCompanies"
                    @select="onSelectCompanies"
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
                <label class="col-2 col-form-label">شرکت دوم</label>
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
import Body from "../../../../components/portal/Body";
import CardProgress from "../../../../components/CardProgress";
import Modal from "../../../../components/Modal";
import AvatarCropper from "vue-avatar-cropper";

export default {
  data() {
    return {
      form: {
        company_id: null,
        partner_id: null,
        expire_date: null,
        number: null,
        file:null,
      },
      showModal: false,
      isEdit: false,
      isLoading: false,

      companies: [],
      company_id: null,
      partner_id: null,

      baseUrl: "",
      api: null,
      
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
  computed: {},
  mounted() {
    this.seats = this.form.seats = null;
    this.getCompanies();
    if (this.$route.params.id) {
      this.baseUrl = "/portal/companies/" + this.$route.params.id + "/partnears";
      this.api = "api/v1/portal/companies/" + this.$route.params.id + "/partnears";
      this.form.company_id = this.$route.params.id;

      let promise = this.$http.get(
        this.$api("api/v1/portal/companies/"+this.$route.params.id)
      );
      promise
        .then(response => {
          this.company_id = {
            id : response.data.id,
            name : response.data.name
          }
        })
        .catch(error => {
          console.error("Get Company Data Error : " + error);
        });
    } else {
      this.baseUrl = "/portal/partnears";
      this.api = "api/v1/portal/companies/null/partnears";
    }
    if (this.$route.params.uid) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api(this.api + "/" + this.$route.params.uid)
      );
      
      promise
        .then(response => {
          this.form = response.data;
          this.company_id = {
            id : response.data.company_id,
            name : response.data.company
          }
          this.partner_id = {
            id : response.data.partner_id,
            name : response.data.partner
          }
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
    onSelectCompanies(value) {
      this.company_id = value
      this.form.company_id = value.id;
    },
    onSelectPartner(value) {
      this.partner_id = value
      this.form.partner_id = value.id;
    },
    getCompanies() {
      let promise = this.$http.get(this.$api("api/v1/portal/companies/list"));
      return promise
        .then(response => {
          this.companies = response.data;
          return response.data;
        })
        .catch(error => {
          this.companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      if (this.$route.params.uid) {
        let promise = this.$http.put(
          this.$api(this.api + "/" + this.$route.params.uid),
          this.form
        );

        promise
          .then(response => {
            this.isEdited = this.dismissSecs;
          })
          .catch(error => {
            this.isAlert = this.dismissSecs;
            let e = error.response;
            if (e.status === 422 || e.status === 409) {
                let er = e.data
              if (er) {
                for (var i = 0; i < Object.keys(er).length; i++) {
                  this.$notify({
                    group: "error",
                    text: er[Object.keys(er)[i]][0],
                    type: "error",

                    duration: 10000 + (i*1000),
                  });
                }
              }
            }
            console.error("Dashboard Error : " + error);
          });
      } else {
        let promise = this.$http.post(this.$api(this.api + "/new"), this.form);
        promise
          .then(response => {
            console.error(response);
            this.$router.push(this.$route.query.redirect || this.baseUrl);
          })
          .catch(error => {
            this.isAlert = this.dismissSecs;
            let e = error.response;
            if (e.status === 422 || e.status === 409) {
                let er = e.data
              if (er) {
                for (var i = 0; i < Object.keys(er).length; i++) {
                  this.$notify({
                    group: "error",
                    text: er[Object.keys(er)[i]][0],
                    type: "error",

                    duration: 10000 + (i*1000),
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
      this.form.company_id = null;
      this.form.partner_id = null;
      this.form.expire_date = null;
      this.form.number = null;
      this.company_id = null;
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
    }
  }
};
</script>