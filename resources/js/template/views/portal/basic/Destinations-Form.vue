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
                <span v-if="isEdit">ویرایش اطلاعات مقصد « {{form.name}} »</span>
                <span v-else>افزودن مقصد</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link to="/portal/destinations" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام مقصد</label>
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
                <label class="col-2 col-form-label">کد مقصد</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.code"
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
        code: "",
        province: null,
        county: null,
        city: null
      },
      isEdit: false,
      isLoading: false,

      provinces: [],
      counties: [],
      cities: [],
      province: null,
      county: null,
      city: null,

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
    this.getProvinces();
    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api("api/v1/core/destinations/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.getCounties(response.data.province,true);
          this.getCities(response.data.county,true);
          this.form.name = response.data.name;
          this.form.code = response.data.code;
          this.form.province = response.data.province;
          this.form.county = response.data.county;
          this.form.city = response.data.city;
          this.form.status = response.data.status;
          if(this.form.province)
          this.province = this.provinces.find(this.findP);
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
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
    findP(arr) {
      console.error(arr);
      if (arr.id == this.form.province) return arr;
    },
    findC(arr) {
      console.error(arr);
      if (arr.id == this.form.county) return arr;
    },
    findCi(arr) {
      console.error(arr);
      if (arr.id == this.form.city) return arr;
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
    getCounties(province, fetch = false) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/core/counties/" + province)
        );
        return promise
          .then(response => {
            this.counties = response.data;
            if (fetch) this.county = this.counties.find(this.findC);
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
    getCities(county, fetch = false) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/core/cites/" + county));
        return promise
          .then(response => {
            this.cities = response.data;
            if (fetch) this.city = this.cities.find(this.findCi);
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
    onSubmit(evt) {
      evt.preventDefault();
      if(!this.province){
        this.form.province = null;
      }
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api("api/v1/core/destinations/" + this.$route.params.id),
          this.form
        );

        promise
          .then(response => {
            this.$router.push(
              this.$route.query.redirect || "/portal/destinations/"
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
      } else {
        let promise = this.$http.post(
          this.$api("api/v1/core/destinations/new"),
          this.form
        );
        promise
          .then(response => {
            this.$router.push(
              this.$route.query.redirect || "/portal/destinations/"
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
      this.form.code = "";
      this.form.status = 1;
      this.form.province = null;
      this.form.county = null;
      this.form.city = null;
      this.province = null;
      this.county = null;
      this.city = null;
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

