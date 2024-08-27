<template>
  <div class="modal-base">
    <b-form v-if="modalFormHandler" @submit="onSubmit" class="row">
      <b-col v-if="modalType == 'insurance-third'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن بیمه شخص ثالث</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-2 col-form-label">شرکت بیمه شخص ثالث</label>
                <div class="col-10">
                  <multiselect
                    v-model="insurance_company"
                    label="name"
                    track-by="id"
                    placeholder="شرکت بیمه را انتخاب کنید."
                    open-direction="bottom"
                    :options="insurance_companies"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectInsuranceCompany"
                    @change="onSelectInsuranceCompany"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="7">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">شماره بیمه شخص ثالث</label>
                <div class="col-7">
                  <input
                    type="number"
                    v-model.trim="form.insurance_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <button class="btn btn-primary w-100">بررسی</button>
                </div>
              </div>
            </b-col>
            <b-col cols="5">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">تاریخ انقضا</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.insurance_expire_date"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-if="modalType == 'insurance-body'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن بیمه بدنه</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-2 col-form-label">شرکت بیمه بدنه</label>
                <div class="col-10">
                  <multiselect
                    v-model="insurance_company"
                    label="name"
                    track-by="id"
                    placeholder="شرکت بیمه را انتخاب کنید."
                    open-direction="bottom"
                    :options="insurance_companies"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectInsuranceCompany"
                    @change="onSelectInsuranceCompany"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="7">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">شماره بیمه بدنه</label>
                <div class="col-7">
                  <input
                    type="number"
                    v-model.trim="form.insurance_body_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <button class="btn btn-primary w-100">بررسی</button>
                </div>
              </div>
            </b-col>
            <b-col cols="5">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">تاریخ انقضا</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.insurance_body_expire_date"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-if="modalType == 'technical-diagnoses'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن معاینه فنی</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="7">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">شماره معاینه فنی</label>
                <div class="col-7">
                  <input
                    type="number"
                    v-model.trim="form.car_technical_diagnoses_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <button class="btn btn-primary w-100">بررسی</button>
                </div>
              </div>
            </b-col>
            <b-col cols="5">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-3 col-form-label">تاریخ انقضا</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.car_technical_diagnoses_expire_date"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-if="modalType == 'destenations'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن شرکت مقصد جدید برای وسیله نقلیه</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت مقصد</label>
                <div class="col-10">
                  <multiselect
                    v-model="company_id"
                    label="name"
                    :customLabel="companyLabel"
                    track-by="id"
                    placeholder="شرکت مقصد را انتخاب کنید."
                    open-direction="bottom"
                    :options="companies"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectCompany"
                    @change="onSelectCompany"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-if="modalType == 'routes'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن خط سیر جدید برای وسیله نقلیه</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">خط سیر</label>
                <div class="col-10">
                  <multiselect
                    v-model="route_id"
                    label="name"
                    :custom-label="routeLabel"
                    track-by="id"
                    placeholder="خط سیر را انتخاب کنید."
                    open-direction="bottom"
                    :options="routes"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectRoute"
                    @change="onSelectRoute"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col v-if="modalType == 'records'" cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>افزودن گزارش جدید</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-12 col-form-label">متن گزارش</label>
                <div class="col-12">
                  <textarea
                    v-model="form.note"
                    placeholder="متن گزارش را وارد نمایید.."
                    class="form-control"
                  ></textarea>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>

      <b-col cols="12" class="text-center">
        <button type="submit" class="btn btn-success w-25">ثبت</button>
      </b-col>
    </b-form>

    <b-form v-if="modalType == 'license'" @submit="onSubmitForm" class="row">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>مجوز دریافت سرویس</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">وضعیت دسترسی</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="enable"
                    type="radio"
                    v-model.trim="form.status"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="enable">
                    <span></span>مجاز به دریافت سرویس
                  </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="disable"
                    type="radio"
                    v-model.trim="form.status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="disable">
                    <span></span>غیر مجاز
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center justify-content-center">
                <label class="col-12 col-form-label">توضیحات</label>
                <div class="col-12">
                  <textarea
                    v-model="form.status_note"
                    placeholder="متن توضیحات را وارد نمایید.."
                    class="form-control"
                  ></textarea>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col col-form-label">ثبت گزارش</label>
                <b-col cols="10" class="form-checkbox-datamis text-right">
                  <input
                    id="UseSameRoute"
                    type="checkbox"
                    v-model="form.add_record"
                    class="form-checkbox-input"
                  />
                  <label class="form-checkbox-label" for="UseSameRoute">
                    <span></span>
                    ثبت به عنوان سوابق راننده در بخش گزارشات
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12" class="text-center">
        <button type="submit" class="btn btn-success w-25">ثبت</button>
      </b-col>
    </b-form>

    <b-col cols="12" v-if="modalType == 'owners'">
      <div class="inner-main">
        <div class="inner-header">
          <b-row>
            <b-col cols="12">
              <span>اطلاعات مالک فعلی</span>
            </b-col>
          </b-row>
        </div>
        <b-row class="inner-body row-eq-height">
          <b-col cols="4">
            نام و نام خانوادگی : <b>{{ current.fname }} {{ current.lname }}</b>
          </b-col>
          <b-col cols="4">
            نام پدر : <b>{{ current.father }}</b>
          </b-col>
          <b-col cols="4"></b-col>
        </b-row>
        <b-row class="inner-body row-eq-height">
          <b-col cols="4">
            کد ملی : <b>{{ current.nation_code }}</b>
          </b-col>
          <b-col cols="4">
            تلفن تماس :
            <b
              ><a :href="`tel:` + current.tel">{{ current.tel }}</a></b
            >
          </b-col>
          <b-col cols="4">
            تلفن همراه :
            <b
              ><a :href="`tel:+98` + current.mobile">0{{ current.mobile }}</a></b
            >
          </b-col>
        </b-row>
        <b-row class="inner-body row-eq-height">
          <b-col cols="12">
            آدرس محل سکونت : <b>{{ current.full_address }}</b>
          </b-col>
        </b-row>
      </div>
    </b-col>
    <b-col cols="12" v-if="modalType == 'owners' && owners.length > 0">
      <div class="inner-main">
        <div class="inner-header">
          <b-row>
            <b-col cols="12">
              <span>اطلاعات مالکین قبلی</span>
            </b-col>
          </b-row>
        </div>
        <div>
          <b-row class="pb-3">
            <b-col cols="2" class="text-right">
              <span>نام و نام خانوادگی</span>
            </b-col>
            <b-col cols="2" class="text-right">
              <span>تلفن</span>
            </b-col>
            <b-col cols="2" class="text-center">
              <span>پلاک</span>
            </b-col>
            <b-col cols="2" class="text-center">
              <span>ظرفیت خودرو</span>
            </b-col>
            <b-col cols="2" class="text-center">
              <span>کارت هوشمند</span>
            </b-col>
            <b-col cols="1" class="text-center">
              <span>VIN</span>
            </b-col>
          </b-row>
          <OwnerItem v-for="item in owners" :key="item.queue" :item="item" />
        </div>
      </div>
    </b-col>
    <b-col cols="12" v-if="modalTableHandler">
      <b-table
        id="table-two"
        :busy.sync="modalIsBusy"
        :items="modalProvider"
        :fields="modalFields"
        :sort-by.sync="modalSortBy"
        :sort-desc.sync="modalSortType"
        :filter="modalFilter"
        :filterIncludedFields="modalFilterOn"
        :current-page="modalCurrentPage"
        :per-page="modalPerPage"
        responsive="sm"
      >
        <template v-slot:table-busy>
          <div class="text-center text-danger my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>دریافت اطلاعات</strong>
          </div>
        </template>
      </b-table>
      <!-- <b-col cols="12" v-else>
          <div class="inner-main">
            <b-row class="inner-body row-eq-height">
              <b-col cols="12" class="text-center">
                <b>موردی جهت نمایش وجود ندارد.</b>
              </b-col>
            </b-row>
          </div>
        </b-col> -->
      <div
        class="col-12"
        v-if="modalTotalRows > modalPerPage && modalTableHandler == true"
      >
        <b-pagination
          v-model="modalCurrentPage"
          :total-rows="modalTotalRows"
          :per-page="modalPerPage"
          align="fill"
          style="direction: ltr"
          :hide-goto-end-buttons="true"
          :limit="20"
        ></b-pagination>
      </div>
    </b-col>
  </div>
</template>

<script>
import OwnerItem from "../../../components/modal-forms/vehicle/OwnerItem";
export default {
  props: {
    parentID: {
      type: Number,
      description: "Parent ID For Add/Edit",
    },
    modalTableHandler: {
      type: Boolean,
      description: "Show Table In Handler",
      default: true,
    },
    modalFormHandler: {
      type: Boolean,
      description: "Show Form In Handler",
      default: true,
    },
    modalApi: {
      type: String,
      description: "Modal Api Link",
    },
    modalType: {
      type: String,
      description: "Modal Type",
    },
    modalFields: {
      type: Array,
      description: "Modal Table Fields",
    },
    modalSortBy: {
      type: String,
      description: "id",
    },
    modalSortType: {
      type: Boolean,
      default: false,
    },
    modalID: {
      type: String,
      description: "modal-handler",
    },
  },
  components: {
    OwnerItem,
  },
  data() {
    return {
      form: {},
      modalFilterOn: [],
      modalFilter: [],
      modalMinApi: null,
      modalItems: null,
      modalTotalRows: 0,
      modalCurrentPage: 1,
      modalPerPage: 1,
      modalIsBusy: false,
      isLoading: false,

      owners: [],
      current: [],
      insurance_companies: [],
      insurance_company: null,

      company_id: null,
      companies: [],
      destanations: null,

      route_id: null,
      routes: [],
    };
  },
  computed: {
    modalSortOptions() {
      // Create an options list from our fields
      return this.modalFields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
    getUserData: function () {
      return this.$store.getters.user;
    },
  },
  mounted() {
    switch (this.modalType) {
      case "insurance-body":
      case "insurance-third":
        this.getInsuranceCompanies();
        break;
      case "destenations":
        this.getCompanies();
        break;
      case "routes":
        this.getRoutes();
        break;
      case "license":
        this.getInfo();
        break;
      case "owners":
        this.getOwners();
        this.getCurrentOwner();
        break;
    }
  },
  methods: {
    getInfo() {
      let promise = this.$http.get(this.$api(this.modalApi));
      return promise
        .then((response) => {
          this.form = response.data;
          return response.data;
        })
        .catch((error) => {
          return [{ id: 0, name: "-----" }];
        });
    },
    onSelectRoute(value) {
      this.form.route_id = value.id;
      this.route_id = value.id;
    },
    getOwners() {
      let promise = this.$http.get(this.$api(this.modalApi));
      return promise
        .then((response) => {
          this.owners = response.data;
          return response.data;
        })
        .catch((error) => {
          return [];
        });
    },
    getCurrentOwner() {
      let promise = this.$http.get(this.$api(this.modalApi + "/current"));
      return promise
        .then((response) => {
          this.current = response.data;
          return response.data;
        })
        .catch((error) => {
          return [];
        });
    },
    getRoutes(car_type_id) {
      let promise = this.$http.get(this.$api("api/v1/client/routes/list"));
      return promise
        .then((response) => {
          this.routes = response.data;
          return response.data;
        })
        .catch((error) => {
          this.routes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSelectInsuranceCompany(value) {
      this.insurance_company = value;
      if (this.modalType == "insurance-body") {
        this.form.insurance_body_company_id = value.id;
      } else {
        this.form.insurance_company_id = value.id;
      }
    },
    getInsuranceCompanies() {
      let promise = this.$http.get(
        this.$api("api/v1/client/core/insurance-companies/list")
      );
      return promise
        .then((response) => {
          this.insurance_companies = response.data;
          return response.data;
        })
        .catch((error) => {
          this.insurance_companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSelectCompany(value) {
      this.company_id = value.id;
      if (this.getUserData.company_id == value.partner_id) {
        this.form.destanations = value.company_id;
      } else {
        this.form.destanations = value.partner_id;
      }
    },
    getCompanies(value) {
      let promise = this.$http.get(this.$api("api/v1/client/partnears/list"));

      return promise
        .then((response) => {
          this.companies = response.data;
          return response.data;
        })
        .catch((error) => {
          this.companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    modalProvider(ctx) {
      let sort = "asc";
      if (ctx.sortDesc) {
        sort = "desc";
      }
      let sortBy = ctx.sortBy;
      if (ctx.sortBy == "") {
        sortBy = "id";
      }
      let params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;
      if (ctx.filter) {
        params = "?page=" + ctx.currentPage + "&order_by=" + sortBy + "&order=" + sort;
      }

      let promise = this.$http.get(this.$api(this.modalApi + params));

      return promise
        .then((response) => {
          const modalItems = response.data;
          this.modalTotalRows = response.data.total;
          this.modalPerPage = response.data.per_page;
          return modalItems.data;
        })
        .catch((error) => {
          console.error("Dashboard Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    onSubmit(evt) {
      evt.preventDefault();
      let promise = this.$http.post(this.$api(this.modalApi + "/new"), this.form);
      promise
        .then((response) => {
          this.$root.$emit("bv::refresh::table", "table-two");
        })
        .catch((error) => {
          this.isAlert = this.dismissSecs;
        });
    },
    onSubmitForm(evt) {
      evt.preventDefault();
      let promise = this.$http.post(this.$api(this.modalApi), this.form);
      promise
        .then((response) => {
          this.$root.$emit("bv::refresh::table", "table-one");
          this.$root.$emit("bv::hide::modal", this.modalID);
        })
        .catch((error) => {
          this.isAlert = this.dismissSecs;
        });
    },
    modalStatusType(value) {
      switch (parseInt(value)) {
        case 3:
          return "نامشخص";
        case 0:
          return "خارج از دسترس";
        case 1:
          return "در حال ارائه سرویس";
        case 2:
          return "در حال بررسی اطلاعات";
        default:
          return "---";
      }
    },
    flname(value) {
      return value.fname + " " + value.lname;
    },
    routeLabel(value) {
      if (value.route_code != undefined) return value.route_code + " - " + value.name;
      return "خط سیری برای این نوع وسلیه نقلیه یافت نشد.";
    },
    companyLabel(value) {
      if (value.company != undefined) return value.company;
      return "---";
    },
  },
};
</script>
