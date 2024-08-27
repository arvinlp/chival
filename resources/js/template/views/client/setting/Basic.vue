<template>
  <section class="page">
    <b-alert
      :show="isAlert"
      fade
      :variant="variant"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div>{{ isAlertMessage }}</div>
    </b-alert>

    <b-form @submit="onSubmit" class="row">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>تنظیمات مرتبط با راهداری</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کد راهداری شرکت</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.rmto_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                    disabled
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
                <span>تنظیمات بخش لیست رانندگان و فروش بیلط</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">اعزام خودکار</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.push_to_selling"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
                <div class="col-12">
                  <small class="text-muted"
                    >تعداد پیش فرض اعزام خودکار را در صورت نیاز می توانید از طریق این بخش
                    تغییر دهید.</small
                  >
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
                <span>تنظیمات سامانه پیامک</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کلید دسترسی</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.sms_api"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12">
        <button type="submit" class="btn btn-success w-25">ثبت</button>
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
        manager_id: null,
        sms_number: null,
        sms_username: null,
        sms_password: null,
        bpi_terminal: null,
        rmto_code: null,
        push_to_selling: 3,
        reject_driver: 5,
      },
      showModal: false,
      isEdit: false,
      isLoading: false,

      baseUrl: { name: "client-setting" },
      api: "api/v1/client/setting",

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
      isAlertMessage: "",
      variant: "danger",
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
    let promise = this.$http.get(this.$api(this.api));

    promise
      .then((response) => {
        this.form.manager_id = response.data.find(
          (item) => item.key === "manager_id"
        ).value;
        this.form.rmto_code = response.data.find(
          (item) => item.key === "rmto_code"
        ).value;
        this.form.sms_number = response.data.find(
          (item) => item.key === "sms_number"
        ).value;
        this.form.sms_username = response.data.find(
          (item) => item.key === "sms_username"
        ).value;
        this.form.sms_password = response.data.find(
          (item) => item.key === "sms_password"
        ).value;
        this.form.bpi_terminal = response.data.find(
          (item) => item.key === "bpi_terminal"
        ).value;
        this.form.push_to_selling = response.data.find(
          (item) => item.key === "push_to_selling"
        ).value;
        this.form.reject_driver = response.data.find(
          (item) => item.key === "reject_driver"
        ).value;
      })
      .catch((error) => {});
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      console.error(this.form);
      let promise = this.$http.post(this.$api(this.api), this.form);
      promise
        .then((response) => {
          this.$router.push(
            this.$route.query.redirect || {
              name: "user-dashboard",
            }
          );
        })
        .catch((error) => {
          this.variant = "danger";
          this.isAlertMessage = "خطای در ویرایش رخ داد مجددا سعی نمایید.";
          this.isAlert = this.dismissSecs;
        });
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    },
  },
};
</script>
