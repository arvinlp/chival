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
                <span>تنظیمات بیلط سفر</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label"
                  >مبلغ ثابت</label
                >
                <b-col>
                  <currency-input
                    v-model="form.passenger_extra_price"
                    placeholder="مبلغ ثابت اضافی را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >
                    در صورتی که نیاز است مبلغی ثابت را به بیلط مسافرین خود اضافه کنید و مبلغ مذکور برای سامانه راه‌داری ارسال نگردد، در این بخش آن را وارد نمایید.
                    </small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12 d-none">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>تنظیمات لغو سفر</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">درصد کسر وضعیت در انتظار مسافر</label>
                <b-col>
                  <input
                    type="number"
                    v-model.number="form.passenger_cancel_step_3"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >در صورتی که مسافر درخواست لغو سفر خود را در زمان «در انتظار تکمیل
                    ظرفیت» دهد. شامل کسر این درصد از قیمیت خرید مسافر می شود.</small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">درصد کسر وضعیت تکمیل ظرفیت</label>
                <b-col>
                  <input
                    type="number"
                    v-model.number="form.passenger_cancel_step_4"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >در صورتی که مسافر درخواست لغو سفر خود را در زمان «ظرفیت تکمیل است»
                    دهد. شامل کسر این درصد از قیمیت خرید مسافر می شود.</small
                  >
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label"
                  >درصد کسر وضعیت رهگیری دریافت شده</label
                >
                <b-col>
                  <input
                    type="number"
                    v-model.number="form.passenger_cancel_step_5"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </b-col>
                <div class="col-12">
                  <small class="text-muted"
                    >در صورتی که مسافر درخواست لغو سفر خود را در زمان «کد رهگیری دریافت
                    شده است» دهد. شامل کسر این درصد از قیمیت خرید مسافر می شود.</small
                  >
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
        passenger_cancel_step_3: null,
        passenger_cancel_step_4: null,
        passenger_cancel_step_5: null,
        passenger_extra_price:0,
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
        this.form.passenger_cancel_step_3 = response.data.find(
          (item) => item.key === "passenger_cancel_step_3"
        ).value;
        this.form.passenger_cancel_step_4 = response.data.find(
          (item) => item.key === "passenger_cancel_step_4"
        ).value;
        this.form.passenger_cancel_step_5 = response.data.find(
          (item) => item.key === "passenger_cancel_step_5"
        ).value;
        this.form.passenger_extra_price = response.data.find(
          (item) => item.key === "passenger_extra_price"
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
          this.variant = "success";
          this.isAlertMessage = "تنظیمات سیستم بروزرسانی شد";
          this.isAlert = this.dismissSecs;
          this.$router.push(this.$route.query.redirect || { name: "user-dashboard" });
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
