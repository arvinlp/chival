<template>
  <section class="page">
    <b-alert :show="isAlert" fade variant="danger" @dismiss-count-down="countDownChangedAlert">
      <div v-if="isEdit">
        خطای در ویرایش رخ داد مجددا سعی نمایید.
      </div>
      <div v-else>
        خطای در افزودن رخ داد مجددا سعی نمایید.
      </div>
    </b-alert>
    <b-alert :show="isEdited" fade variant="success" @dismiss-count-down="countDownChangedEdited">اطلاعات با موفقیت بروزرسانی شد.</b-alert>

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش اطلاعات بانک « {{form.name}} »</span>
                <span v-else>اطلاعات بانک</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link to="/portal/banks" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="7">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام بانک</label>
                <div class="col-10">
                  <input type="text" v-model.trim="form.name" placeholder="مشخصات درست را وارد نمایید." class="form-control" />
                </div>
              </div>
            </b-col>
            <b-col cols="5">
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
        </div>
      </b-col>
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش اطلاعات حساب بانکی « {{form.owner}} »</span>
                <span v-else>اطلاعات حساب بانکی</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نام صاحب حساب</label>
                <div class="col-9">
                  <input type="text" v-model.trim="form.owner" placeholder="مشخصات درست را وارد نمایید." class="form-control" />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره کارت</label>
                <div class="col-9">
                  <input type="text" v-model.trim="form.card" placeholder="مشخصات درست را وارد نمایید." class="form-control" />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره حساب</label>
                <div class="col-9">
                  <input type="text" v-model.trim="form.account" placeholder="مشخصات درست را وارد نمایید." class="form-control" />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره شبا حساب</label>
                <div class="col-9">
                  <input type="text" v-model.trim="form.iban" placeholder="مشخصات درست را وارد نمایید." class="form-control" />
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
        account: "",
        iban: "",
        card: "",
        owner: "",
        status: "",
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
        this.$api("api/v1/core/banks/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.form.name=response.data.name
          this.form.account=response.data.account
          this.form.iban=response.data.iban
          this.form.card=response.data.card
          this.form.owner=response.data.owner
          this.form.status=response.data.status
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        })
    }
  },
  methods: {
    onSubmit(evt) {
      evt.preventDefault();
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api("api/v1/core/banks/" + this.$route.params.id),
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
          })
      } else {
        let promise = this.$http.post(
          this.$api("api/v1/core/banks/new"),
          this.form
        );
        promise
          .then(response => {
            this.$router.push(
              this.$route.query.redirect || "/portal/banks/"
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
          })
      }
    },
    onReset(evt) {
      evt.preventDefault();
      this.form.name    = ""
      this.form.account = ""
      this.form.iban    = ""
      this.form.card    = ""
      this.form.owner   = ""
      this.form.status  = 1
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
  }
};
</script>

