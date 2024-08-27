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
    <b-alert
      :show="isDateAlert"
      fade
      variant="warning"
      @dismiss-count-down="countDownChangedDateAlert"
    >زمان شروع و پایان معتبر نمی باشد، لطفا مجددا بررسی کنید.</b-alert>

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش اطلاعات شیفت کاری « {{form.name}} »</span>
                <span v-else>افزودن شیفت جدید</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="{name: 'client-work-times'}" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">عنوان</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.name"
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
                <label class="col-2 col-form-label">روز</label>
                <div class="col-10">
                  <multiselect
                    v-model="dayOfWeek"
                    label="name"
                    track-by="id"
                    placeholder="روز را انتخاب کنید."
                    open-direction="bottom"
                    :options="days"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectWeek"
                    @change="onSelectWeek"
                  ></multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">وضعیت دسترسی :</label>
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">ساعت شروع</label>
                <b-col cols="10">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.startTime"
                    id="startTime"
                    placeholder="ساعت شروع شیفت را انتخاب کنید."
                  />
                  <date-picker
                    type="time"
                    v-model="form.startTime"
                    format="HH:mm"
                    element="startTime"
                  />
                </b-col>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">ساعت پایان</label>
                <b-col cols="10">
                  <input
                    type="text"
                    class="form-control"
                    v-model="form.endTime"
                    id="endTime"
                    placeholder="ساعت پایان شیفت را انتخاب کنید."
                  />
                  <date-picker
                    type="time"
                    v-model="form.endTime"
                    :min="form.startTime"
                    format="HH:mm"
                    element="endTime"
                  />
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
  </section>
</template>

<script>
import Body from "../../../components/portal/Body";
import CardProgress from "../../../components/CardProgress";

export default {
  data() {
    return {
      form: {
        name: "",
        company_id: null,
        startTime: "",
        endTime: "",
        week: "",
        type: "admin",
        status: 1
      },
      isEdit: false,
      isLoading: false,

      days: [
        { id: 1, name: "شنبه" },
        { id: 2, name: "یک شنبه" },
        { id: 3, name: "دو شنبه" },
        { id: 4, name: "سه شنبه" },
        { id: 5, name: "چهار شنبه" },
        { id: 6, name: "پنج شنبه" },
        { id: 7, name: "جمعه" }
      ],
      dayOfWeek: [],

      disableCompany: true,
      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
      isDateAlert: 0
    };
  },

  components: {
    Body,
    CardProgress
  },

  computed: {
    isType: function() {
      return this.$store.getters.isType;
    }
  },
  mounted() {
    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api("api/v1/client/worktimes/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.form = response.data;
          this.form.startTime = response.data.start;
          this.form.endTime = response.data.end;
          this.setDay(response.data.week);
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
    onSelectWeek(select) {
      if (select) {
        this.form.week = select.id;
      } else {
        this.form.week = null;
      }
    },
    clearAll() {
      this.selectedCountries = [];
    },
    onSubmit(evt) {
      evt.preventDefault();
      if (this.form.startTime == this.form.endTime) {
        if (this.form.endTime != "00:00") {
          this.isDateAlert = this.dismissSecs;
          return;
        }
      }
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api("api/v1/client/worktimes/" + this.$route.params.id),
          this.form
        );

        promise
          .then(response => {
            this.isEdited = this.dismissSecs;
              this.$route.query.redirect || {name: 'client-work-times'}
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
        let promise = this.$http.post(
          this.$api("api/v1/client/worktimes/new"),
          this.form
        );
        promise
          .then(response => {
            this.$router.push(
              this.$route.query.redirect || {name: 'client-work-times'}
            );
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
      this.form.name = "";
      this.form.startTime = "";
      this.form.endTime = "";
      this.form.week = "";
      this.form.company_id = null;
      this.dayOfWeek = [];
      this.company = [];
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
    setDay(value) {
      switch (parseInt(value)) {
        case 1:
          return (this.dayOfWeek = [{ id: 1, name: "شنبه" }]);
        case 2:
          return (this.dayOfWeek = [{ id: 2, name: "یک شنبه" }]);
        case 3:
          return (this.dayOfWeek = [{ id: 3, name: "دو شنبه" }]);
        case 4:
          return (this.dayOfWeek = [{ id: 4, name: "سه شنبه" }]);
        case 5:
          return (this.dayOfWeek = [{ id: 5, name: "چهار شنبه" }]);
        case 6:
          return (this.dayOfWeek = [{ id: 6, name: "پنج شنبه" }]);
        case 7:
          return (this.dayOfWeek = [{ id: 7, name: "جمعه" }]);
        default:
          return "---";
      }
    },
  }
};
</script>

