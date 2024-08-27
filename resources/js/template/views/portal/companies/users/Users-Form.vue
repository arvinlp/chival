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
                <span v-if="isEdit">ویرایش اطلاعات فردی « {{form.fname}} {{form.lname}} »</span>
                <span v-else>اطلاعات فردی</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100">بازگشت</router-link>
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
                    @completed="handleCompleted"
                    trigger="#pick-avatar"
                    :upload-url="uploadImageURL"
                    :upload-headers="this.setAuthorize()"
                    :labels="{ submit: 'تایید', cancel: 'انصراف'}"
                  />
                  <img class="profile" v-if="form.img" :src="form.img" />
                  <span id="pick-avatar" class="profile_placeholder">
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
                <span>اطلاعات کاربری سیستم</span>
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
import Body from "../../../../components/portal/Body";
import CardProgress from "../../../../components/CardProgress";
import Modal from "../../../../components/Modal";
import AvatarCropper from "vue-avatar-cropper";

export default {
  data() {
    return {
      form: {
        company_id: null,
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
        last_login: "",
        note: "",
        img: "",
        file: null,
        sex: 0,
        status: 1,
        work_times: []
      },
      file_location: "/company/unknown/avatar",
      uploadImageURL: this.$api("api/v1/portal/upload"),
      showModal: false,
      isEdit: false,
      isLoading: false,
      worktimes: [],
      roles: [],
      role_id: null,

      baseUrl: "/portal/companies/",
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

  computed: {
    isType: function() {
      return this.$store.getters.isType;
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.baseUrl = "/portal/companies/" + this.$route.params.id + "/users";
      this.api = "api/v1/portal/companies/" + this.$route.params.id + "/users";
      this.file_location =
        "/company/" + this.$route.params.id + "/avatar/";
    } else {
      this.$router.push(this.$route.query.redirect || "/portal/companies");
    }
    this.getWorkTime();
    this.getRoles();
    if (this.$route.params.uid) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api(this.api + "/" + this.$route.params.uid)
      );
      promise
        .then(response => {
          this.form = response.data;
          this.role_id = {
            id: response.data.role_id,
            name: response.data.role
          };
          this.file_location = "/company/" + response.data.folder + "/avatar/";
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error)
        });
    }
  },
  methods: {
    onSelectRole(value) {
      this.form.role_id = value.id;
    },
    getRoles() {
      let promise = this.$http.get(this.$api("api/v1/portal/roles/company"));
      return promise
        .then(response => {
          this.roles = response.data;
          return response.data;
        })
        .catch(error => {
          this.worktimes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getWorkTime() {
      let promise = this.$http.get(
        this.$api("api/v1/portal/worktimes/company?type=client")
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
            console.error("Dashboard Error : " + error)
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
      this.form.last_login = "";
      this.form.note = "";
      this.form.sex = 0;
      this.form.status = 1;
      this.form.work_times = [];
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
    handleCompleted(response, form, xhr) {},
    handlerError(message, type, xhr) {
      if (type == "upload") {
        // xhr.response...
      }
    }
  }
};
</script>