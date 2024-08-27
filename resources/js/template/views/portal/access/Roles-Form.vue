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
                <span v-if="isEdit">ویرایش اطلاعات سطح دسترسی « {{form.name}} »</span>
                <span v-else>افزودن سطح دسترسی جدید</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link to="/portal/roles" class="btn btn-danger w-100">بازگشت</router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شرکت/شرکت‌های</label>
                <div class="col-9">
                  <multiselect
                    v-model="company"
                    label="name"
                    track-by="id"
                    placeholder="برای جستجو بخشی از نام را وارد کنید."
                    open-direction="bottom"
                    :options="companies"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    @search-change="getCompanyList"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectCompany"
                    @input="onSelectCompany"
                    :disabled="disableCompany"
                  >
                    <span slot="noResult">موردی یافت نشد !</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">اعمال بروی</label>
                <b-col cols="10">
                  <multiselect
                    v-model="user_type"
                    label="name"
                    track-by="id"
                    placeholder="کاربران استفاده کننده را انتخاب کنید."
                    open-direction="bottom"
                    :options="users_type"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectType"
                    @change="onSelectType"
                  ></multiselect>
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
                <label class="col-1 col-form-label">توضیحات</label>
                <b-col cols="11">
                  <b-textarea v-model="form.description" />
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">سمت کاربری</label>
                <b-col cols="9">
                  <multiselect
                    v-model="form.level"
                    label="name"
                    track-by="id"
                    placeholder="بخش مجاز کاربر فعالیت را انتخاب کنید."
                    open-direction="bottom"
                    :options="levels"
                    :multiple="false"
                    :searchable="true"
                    :close-on-select="true"
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
                  </multiselect>
                </b-col>
              </div>
            </b-col>
            <b-col cols="8">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">دسترسی های مجاز</label>
                <b-col cols="10">
                  <multiselect
                    v-model="form.roles"
                    label="name"
                    track-by="id"
                    placeholder="دسترسی های مجاز کاربر را انتخاب کنید."
                    open-direction="bottom"
                    :options="roles"
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
                    <span
                      slot="noResult"
                    >Oops! No elements found. Consider changing the search query.</span>
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
        company_id: null,
        description: "",
        type: "admin",
        status: 1,
        level: 0,
        roles: []
      },
      isEdit: false,
      companies: [],
      company: [],
      isLoading: false,

      roles: [],
      levels: [],

      users_type: [
        { id: "admin", name: "کاربران سیستم" },
        { id: "client", name: "کاربران شرکتها" }
      ],
      user_type: [{ id: "admin", name: "کاربران سیستم" }],

      disableCompany: true,
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
    this.showUserRole(this.form.type);
    this.showUserLevel(this.form.type);

    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api("api/v1/portal/roles/" + this.$route.params.id)
      );
      promise
        .then(response => {
          this.form = response.data;
          console.error(response.data.roles)
          this.showUserRole(response.data.type);
          this.showUserLevel(response.data.type);
          this.form.level = this.levels[response.data.level];
          this.setCompany(response.data.company_id);
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }

    this.getCompanyList(null);
  },
  methods: {
    onSelectCompany(select) {
      if (select) {
        this.user_type = [{ id: "client", name: "کاربران شرکتها" }];
        this.form.company_id = select.id;
        this.form.type = "client";
      } else {
        this.user_type = [{ id: "admin", name: "کاربران سیستم" }];
        this.form.type = "admin";
      }
    },
    onSelectType(select) {
      if (select) {
        this.user_type = select;
        this.form.type = select.id;
        this.form.roles = [];
        this.showUserRole(select.id);
        this.showUserLevel(select.id);
        this.disableCompany = false;
        this.form.level = null;
        if (select.id == "admin") {
          this.form.company_id = null;
          this.disableCompany = true;
          this.form.level = null;
          this.company = [];
        }
      } else {
        this.user_type = [{ id: "admin", name: "کاربران سیستم" }];
        this.form.type = "admin";
        this.form.roles = [];
        this.showUserRole("admin");
        this.showUserLevel("admin");
        this.form.level = null;
        this.form.company_id = null;
        this.company = [];
        this.disableCompany = true;
      }
      this.$root.$emit("bv::refresh::table", "table-one");
    },
    getCompanyList(search) {
      this.isLoading = true;
      let params = "";
      if (search) params = "?name=" + search;
      let promise = this.$http.get(
        this.$api("api/v1/portal/companies/list" + params)
      );
      console.error("api/v1/portal/companies/list" + params);

      return promise
        .then(response => {
          this.companies = response.data;
          this.isLoading = false;
          return response.data;
        })
        .catch(error => {
          this.companies = [{ id: 0, name: "-----" }];
          this.isLoading = false;
          return [{ id: 0, name: "-----" }];
        });
    },
    clearAll() {
      this.selectedCountries = [];
    },
    onCompanyClick({ option, addTag }) {
      addTag(option);
      this.searchCompany = "";
    },
    onSubmit(evt) {
      evt.preventDefault();
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api("api/v1/portal/roles/" + this.$route.params.id),
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
          this.$api("api/v1/portal/roles/new"),
          this.form
        );
        promise
          .then(response => {
            console.error(response)
            // this.$router.push(this.$route.query.redirect || "/portal/roles/");
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
      this.form.description = "";
      this.form.company_id = null;
      this.company = [];
      this.form.type = null;
      this.user_type = [{ id: "admin", name: "کاربران سیستم" }];
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
    setCompany(value) {
      for (var i = 0; i < this.companies.length; i++) {
        if (this.companies[i].id === value) {
          this.company = this.companies[i];
        }
      }
    },
    showUserRole(type) {
      if (type == "client") {
        this.roles = [
          //
          { id: "basic-banks", name: "مدیریت بانک ها" },
          { id: "basic-insurance-companies", name: "مدیریت شرکت های بیمه" },
          { id: "basic-travel-types", name: "مدیریت نوع سفرها" },
          { id: "basic-vichle-brand", name: "وسایل نقلیه - برند" },
          { id: "basic-vichle-types", name: "وسایل نقلیه - نوع" },
          //
          { id: "users-admin", name: "مدیریت پرسنل" },
          { id: "users-histories", name: "مشاهده تاریخچه پرسنل" },
          { id: "users-roles", name: "مدیریت سطوح دسترسی" },
          { id: "users-work-times", name: "مدیریت شیفت کاربران" },
          { id: "users-messages", name: "پیام های پرسنل" }
        ];
      } else {
        this.roles = [
          //
          { id: "basic-banks", name: "مدیریت بانک ها" },
          { id: "basic-insurance-companies", name: "مدیریت شرکت های بیمه" },
          { id: "basic-travel-types", name: "مدیریت نوع سفرها" },
          { id: "basic-vichle-brand", name: "وسایل نقلیه - برند" },
          { id: "basic-vichle-types", name: "وسایل نقلیه - نوع" },
          //
          { id: "users-admin", name: "مدیریت پرسنل" },
          { id: "users-histories", name: "مشاهده تاریخچه پرسنل" },
          { id: "users-roles", name: "مدیریت سطوح دسترسی" },
          { id: "users-work-times", name: "مدیریت شیفت کاربران" },
          { id: "users-messages", name: "پیام های پرسنل" }
        ];
      }
    },
    showUserLevel(type) {
      if (type == "client") {
        this.levels = [
          { id: 0, name: "مدیر عامل/اعضا هیت مدیره" },

          { id: 100, name: "مدیر فنی" },
          { id: 110, name: "ناظر فنی" },
          { id: 120, name: "کاربر فنی" },

          { id: 200, name: "مدیر پشتیبانی" },
          { id: 210, name: "ناظر پشتیبانی" },
          { id: 220, name: "کاربر پشتیبانی" },

          { id: 300, name: "مدیر مالی" },
          { id: 310, name: "ناظر مالی" },
          { id: 320, name: "کاربر مالی" },

          { id: 400, name: "مدیر انبار" },
          { id: 410, name: "ناظر انبار" },
          { id: 420, name: "انبار دار" },

          { id: 999, name: "کاربر" },
        ];
      } else {
        this.levels = [
          { id: 0, name: "مدیریت کل سیستم" },
          { id: 100, name: "مدیریت فنی" },
          { id: 200, name: "مدیریت پشتیبانی" },
          { id: 300, name: "مدیریت مالی" },
        ];
      }
    }
  }
};
</script>