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
                <span v-if="isEdit">ویرایش اطلاعات سفر « {{form.name}} »</span>
                <span v-else>افزودن اطلاعات</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link to="/portal/travel-types" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="7">
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
            <b-col cols="5">
              <div class="form-group row align-items-center">
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
                <label class="col-2 col-form-label">نوع سفر</label>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Normal"
                    type="radio"
                    v-model.trim="form.type"
                    value="2"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Normal">
                    <span></span>مینی بوس یا سواری
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Vip"
                    type="radio"
                    v-model.trim="form.type"
                    value="3"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Vip">
                    <span></span>دربستی
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="International"
                    type="radio"
                    v-model.trim="form.type"
                    value="4"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="International">
                    <span></span>بین المللی
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Bus"
                    type="radio"
                    v-model.trim="form.type"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Bus">
                    <span></span>اتوبوس
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
        status: 1,
        type: 2,
      },
      isEdit: false,

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0
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
        this.$api("api/v1/core/travel-types/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.form.name = response.data.name;
          this.form.status = response.data.status;
          this.form.type = response.data.type;
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api("api/v1/core/travel-types/" + this.$route.params.id),
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
        let promise = this.$http.post(
          this.$api("api/v1/core/travel-types/new"),
          this.form
        );
        promise
          .then(response => {
            this.$router.push(
              this.$route.query.redirect || "/portal/travel-types/"
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
      this.form.status = 1;
      this.form.type = 2;
      this.$nextTick(() => {
        this.show = true;
      });
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedEdited(dismissCountDown) {
      this.isEdited = dismissCountDown;
    }
  }
};
</script>

