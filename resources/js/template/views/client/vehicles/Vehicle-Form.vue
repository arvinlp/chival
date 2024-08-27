<template>
  <section class="page">
    <b-alert
      :show="isAlert"
      fade
      variant="danger"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div v-if="isEdit">خطای در ویرایش رخ داد مجددا سعی نمایید.</div>
      <div v-else>خطای در افزودن رخ داد مجددا سعی نمایید.</div>
    </b-alert>
    <b-alert
      :show="isEdited"
      fade
      variant="success"
      @dismiss-count-down="countDownChangedEdited"
      >اطلاعات با موفقیت بروزرسانی شد.</b-alert
    >

    <b-form @submit="onSubmit" class="row" @reset="onReset">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش اطلاعات وسلیه نقلیه</span>
                <span v-else>اطلاعات وسلیه نقلیه</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100"
                  >بازگشت</router-link
                >
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">کد وسلیه نقلیه</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.vehicle_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    v-on:keyup="check(form.vehicle_code)"
                    min="1000"
                    max="100000"
                  />
                </div>
                <div class="col-12" v-if="error != null">
                  <small>{{ error }}</small>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره کارت هوشمند</label>
                <div class="col-7">
                  <input
                    type="number"
                    v-model.trim="form.vehicle_card_number"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <a class="btn btn-primary w-100" @click="getVehicleInfo()">استعلام</a>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نوع وسلیه نقلیه</label>
                <div class="col-9">
                  <multiselect
                    v-model="vehicle_type"
                    label="name"
                    track-by="id"
                    placeholder="نوع وسلیه نقلیه را انتخاب کنید."
                    open-direction="bottom"
                    :options="vehicleType"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectVehicleType"
                    @change="onSelectVehicleType"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">VIN</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.vin"
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
                <label class="col-3 col-form-label">مدل وسلیه نقلیه</label>
                <div class="col-9">
                  <multiselect
                    v-model="vehicle_brand"
                    label="name"
                    track-by="id"
                    placeholder="مدل وسلیه نقلیه را انتخاب کنید."
                    open-direction="bottom"
                    :options="vehicleBrand"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectVehicleBrand"
                    @change="onSelectVehicleBrand"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">ظرفیت</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.capacity"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <small class="col-12 text-right text-small"
                  >ظرفیت وسیله نقلیه بصورت خودکار وارد می شود در صورت نادرست بودن ویرایش
                  کنید، این ظرفیت بدون احتساب راننده می باشد.</small
                >
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">سال ساخت</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.year"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    min="1370"
                    max="1430"
                    v-on:change="checkYear()"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">سوخت وسیله نقلیه</label>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="Ouil"
                    type="radio"
                    v-model.trim="form.fuel"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Ouil"> <span></span>بنزین </label>
                </b-col>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="Diesel"
                    type="radio"
                    v-model.trim="form.fuel"
                    value="2"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Diesel">
                    <span></span>گازوئیل
                  </label>
                </b-col>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="Diesel"
                    type="radio"
                    v-model.trim="form.fuel"
                    value="3"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Diesel">
                    <span></span>دوگانه سورز
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">پلاک وسلیه نقلیه</label>
                <div class="col-1 text-right">ایران</div>
                <div class="col-2">
                  <input
                    type="number"
                    v-model.trim="form.plate_series"
                    placeholder="کد استان"
                    class="form-control"
                    min="10"
                    max="99"
                  />
                </div>
                <div class="col-1 text-center">|</div>
                <div class="col-2">
                  <input
                    type="number"
                    v-model.trim="form.plate_series_1"
                    placeholder="بخش سه رقمی"
                    class="form-control"
                    min="100"
                    max="999"
                  />
                </div>
                <div class="col-2">
                  <input
                    type="text"
                    v-model.trim="form.plate_series_2"
                    placeholder="سری"
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <input
                    type="number"
                    v-model.trim="form.plate_series_3"
                    placeholder="بخش دو رقمی"
                    class="form-control"
                    min="10"
                    max="99"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">وضعیت</label>
                <div class="col-11 text-justify text-small">{{ form.status_note }}</div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>مبدا و مقصد</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت مبدا</label>
                <div class="col-10">
                  <multiselect
                    v-model="company_id"
                    label="name"
                    track-by="id"
                    placeholder="شرکت مبدا را انتخاب کنید."
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت مقصد</label>
                <div class="col-10">
                  <multiselect
                    v-model="company_id_dest"
                    label="name"
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
                    @select="onSelectCompanyDest"
                    @change="onSelectCompanyDest"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
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
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>وضعیت بیمه و معاینه فنی</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره بیمه شخص ثالث</label>
                <div class="col-9">
                  <input
                    v-model.trim="form.insurance_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تاریخ انقضا</label>
                <div class="col-10">
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
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label"
                  >وسیله نقلیه دارای بیمه بدنه می باشد ؟</label
                >
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="InsuranceBodyNo"
                    type="radio"
                    v-model.trim="form.insurance_body"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="InsuranceBodyNo">
                    <span></span>بیمه بدنه ندارد
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="InsuranceBodyYes"
                    type="radio"
                    v-model.trim="form.insurance_body"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="InsuranceBodyYes">
                    <span></span>بیمه بدنه دارد
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height" v-if="form.insurance_body == 1">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت بیمه بدنه</label>
                <div class="col-10">
                  <multiselect
                    v-model="insurance_company_body"
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
                    @select="onSelectInsuranceCompanyBody"
                    @change="onSelectInsuranceCompanyBody"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height" v-if="form.insurance_body == 1">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره بیمه بدنه</label>
                <div class="col-9">
                  <input
                    v-model.trim="form.insurance_body_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تاریخ انقضا</label>
                <div class="col-10">
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
          <b-row class="inner-body row-eq-height" v-if="showTD">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره معاینه فنی</label>
                <div class="col-9">
                  <input
                    v-model.trim="form.car_technical_diagnoses_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تاریخ انقضا</label>
                <div class="col-10">
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
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات مالک وسلیه نقلیه</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col col-form-label">نام و نام خانوادگی</label>
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
                <label class="col-2 col-form-label">نام پدر</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.father_name"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کد ملی</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.trim="form.nation_code"
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
                <label class="col-2 col-form-label">تاریخ تولد</label>
                <div class="col-10">
                  <date-picker
                    type="date"
                    v-model="form.birthday"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">وضعیت تاهل</label>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="Marriage"
                    type="radio"
                    v-model.trim="form.marital_status"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Marriage">
                    <span></span>متاهل
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Single"
                    type="radio"
                    v-model.trim="form.marital_status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Single"> <span></span>مجرد </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تلفن ثابت</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.tel"
                    placeholder="بصورت 02188997766 وارد شود"
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">موبایل</label>
                <div class="col-11">
                  <input
                    type="text"
                    v-model.trim="form.mobile"
                    placeholder="بدون صفر وارد شود"
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">استان</label>
                <div class="col-10">
                  <multiselect
                    v-model="owner_province"
                    label="name"
                    track-by="id"
                    placeholder="استان محل سکونت را انتخاب کنید."
                    open-direction="bottom"
                    :options="provinces"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectOwenerProvince"
                    @change="onSelectOwenerProvince"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">جنسیت</label>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="Male"
                    type="radio"
                    v-model.trim="form.sex"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Male"> <span></span>مرد </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Female"
                    type="radio"
                    v-model.trim="form.sex"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Female"> <span></span>زن </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهر</label>
                <div class="col-10">
                  <multiselect
                    v-model="owner_county"
                    label="name"
                    track-by="id"
                    placeholder="شهر محل سکونت را انتخاب کنید."
                    open-direction="bottom"
                    :options="owner_counties"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectOwenerCounty"
                    @change="onSelectOwenerCounty"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">شهرستان</label>
                <div class="col-11">
                  <multiselect
                    v-model="owner_city"
                    label="name"
                    track-by="id"
                    placeholder="شهرستان محل سکونت را انتخاب کنید."
                    open-direction="bottom"
                    :options="owner_cities"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectOwenerCity"
                    @change="onSelectOwenerCity"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">آدرس</label>
                <div class="col-11">
                  <textarea
                    type="text"
                    v-model.trim="form.address"
                    placeholder="آدرس پستی کامل محل سکونت را وارد کنید."
                    class="form-control"
                  />
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
        <button type="submit" :disabled="btnDisabled" class="btn btn-success w-50">
          ثبت
        </button>
      </b-col>
    </b-form>
    <!-- -->
    <b-modal v-model="modalShow" centered hide-footer>
      <template v-slot:modal-header="{ close }">
        <h5>استعلام اطلاعات</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <p>مایل به استعلام اطلاعات از چه ارگانی هستید ؟</p>
      </template>

      <template>
        <b-row>
          <b-col cols="12" class="mb-3">
            <b-button
              size="md"
              class="d-block mx-auto"
              variant="success"
              @click="getVehicleInfoFromASKOK()"
            >
              انجمن صنفی شرکت‌های مسافربری سواری کرایه
            </b-button>
          </b-col>
          <b-col cols="12">
            <b-button
              size="md"
              class="d-block mx-auto"
              variant="success"
              @click="getVehicleInfoFromRMTO()"
            >
              اداره کل راه داری کشور
            </b-button>
          </b-col>
        </b-row>
      </template>`
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
var moment = require("moment-jalaali");

export default {
  data() {
    return {
      form: {
        partnear_code: null,
        route_id: null,
        vehicle_code: null,
        vehicle_card_number: null,
        car_type_id: null,
        car_system_id: null,
        vin: null,
        year: null,
        fuel: 1,
        capacity: null,
        plate_series: null,
        plate_series_1: null,
        plate_series_2: null,
        plate_series_3: null,
        insurance_body: 0,
        status_note: "جهت دریافت اطلاعات شماره کارت هوشمند وسیله نقلیه را بررسی کنید.",
        status: 1,

        insurance_id: null,
        insurance_company_id: null,
        insurance_code: null,
        insurance_expire_date: null,
        insurance_type: 3,
        insurance_status: 1,

        insurance_body_id: null,
        insurance_body_company_id: null,
        insurance_body_code: null,
        insurance_body_expire_date: null,
        insurance_body_type: 1,
        insurance_body_status: 1,

        car_technical_diagnoses_id: null,
        car_technical_diagnoses_code: null,
        car_technical_diagnoses_expire_date: null,
        car_technical_diagnoses_status: 1,

        destanations: null,

        fname: null,
        lname: null,
        father_name: null,
        nation_code: null,
        tel: null,
        address: null,
        mobile: null,
        birthday: null,
        marital_status: 0,
        sex: 0,
        province: null,
        county: null,
        city: null,
        owner_status: 1,
      },
      showTD:true,
      showModal: false,
      isEdit: false,
      isLoading: false,

      //
      btnDisabled: true,
      error: null,

      companies: [],
      insurance_companies: [],
      routes: [],
      provinces: [],
      counties: [],
      cities: [],
      owner_counties: [],
      owner_cities: [],
      vehicleBrand: [],
      vehicleType: [],
      company_id: null,
      company_id_dest: null,
      route_id: null,
      insurance_company: null,
      insurance_company_body: null,
      province: null,
      county: null,
      city: null,
      owner_province: null,
      owner_county: null,
      owner_city: null,
      vehicle_brand: null,
      vehicle_type: null,

      baseUrl: { name: "client-vehicles" },
      api: "api/v1/client/vehicles",

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,

      modalShow: false,
    };
  },

  components: {
    Body,
    CardProgress,
  },

  computed: {
    getUserData: function () {
      return this.$store.getters.user;
    },
  },
  mounted() {
    this.getProvinces();
    this.getRoutes();
    this.getCompanies();
    this.getVehicleType();
    this.getVehicleBrand();
    this.getInsuranceCompanies();
    if (this.$route.params.id) {
      this.isEdit = true;
      let promise = this.$http.get(this.$api(this.api + "/" + this.$route.params.id));
      promise
        .then((response) => {
          this.form = response.data;
          this.form.vehicle_card_number = response.data.car_card_no;
          this.vehicle_brand = {
            id: response.data.car_type.id,
            name: response.data.car_type.name,
          };
          this.vehicle_type = {
            id: response.data.car_system.id,
            name: response.data.car_system.name,
          };
          if (response.data.status_note == null) {
            this.form.status_note = "وضعیت فعالیت این وسیله نقلیه نامشخص است !";
            this.form.status = 3;
          }
          if(response.data.partnear_code != "-"){
            this.form.vehicle_code = response.data.partnear_code;
            this.baseUrl = { name: "client-partnear-vehicles" }
          }else{
            this.form.vehicle_code = response.data.car_code;
          }
        })
        .catch((error) => {
          console.error("Get Update Data Error : " + error);
          this.$router.push(this.$route.query.redirect || this.baseUrl);
        });
    }
  },
  methods: {
    checkYear(){
      if(parseInt(this.form.year) < parseInt(moment().format('jYYYY')) - 4){
        this.showTD = true;
      }else{
        this.showTD = false;
      }
    },
    check(value) {
      let promise = this.$http.get(this.$api("api/v1/client/check/car/" + value));

      return promise
        .then((response) => {
          var data = response.data;
          if (data.code == 1) {
            (this.btnDisabled = false), (this.error = null);
          } else {
            (this.btnDisabled = true), (this.error = data.message);
          }
        })
        .catch(() => {
          (this.btnDisabled = false), (this.error = null);
        });
    },
    onSelectRoute(value) {
      this.form.route_id = value.id;
      this.route_id = value;
    },
    onSelectCompany(value) {
      this.company_id = value;
      this.form.company_id = value.id;
    },
    onSelectCompanyDest(value){
      this.company_id_dest = value;
      this.form.company_id_dest = value.id;
      this.form.destanations = value.id;
    },
    onSelectProvince(value) {
      this.province = value;
      this.county = null;
      this.city = null;
      this.getCounties(value.id);
    },
    onSelectCounty(value) {
      this.county = value;
      this.city = null;
      this.getCities(value.id);
    },
    onSelectCity(value) {
      this.city = value;
      this.getCompanies(value.id);
    },
    onSelectInsuranceCompany(value) {
      this.insurance_company = value;
      this.form.insurance_company_id = value.id;
    },
    onSelectInsuranceCompanyBody(value) {
      this.insurance_company_body = value;
      this.form.insurance_body_company_id = value.id;
    },
    onSelectOwenerProvince(value, county = null, city = null) {
      this.owner_province = value;
      this.form.province = value.id;
      this.owner_county = null;
      this.owner_city = null;
      console.error(value);
      this.getOwnerCounties(value.id, county, city);
    },
    onSelectOwenerCounty(value, city = null) {
      this.owner_county = value;
      this.form.county = value.id;
      this.owner_city = null;
      this.getOwnerCities(value.id, city);
    },
    onSelectOwenerCity(value) {
      this.owner_city = value;
      this.form.city = value.id;
    },
    onSelectVehicleType(value) {
      this.form.car_type_id = value.id;
      this.vehicle_type = value;
      this.form.capacity = value.capacity;
      this.getRoutes(value.id);
    },
    onSelectVehicleBrand(value) {
      this.form.car_system_id = value.id;
      this.vehicle_brand = value;
    },
    getVehicleInfo() {
      if (this.form.vehicle_card_number) {
        this.modalShow = true;
      } else {
        this.$notify({
          group: "dataGetter",
          title: "استعلام اطلاعات وسیله نقلیه",
          text: "لطفا شماره کارت هوشمند وسیله نقلیه را وارد نمایید.",
          type: "warn",
          duration: 5000,
        });
      }
    },
    getVehicleInfoFromRMTO() {
      this.$notify({
        group: "dataGetter",
        title: "استعلام اطلاعات وسیله نقلیه",
        text: "در حال دریافت اطلاعات وسیله نقلیه از سامانه راهداری لطفا شکیبا باشید ...",
        duration: 10000,
      });
      let promise = this.$http.get(
        this.$api("api/v1/client/core/rmto/vehicle/" + this.form.vehicle_card_number)
      );
      return promise
        .then((response) => {
          var data = response.data;
          this.form.vin = data.shenaseh_khodro;
          this.form.plate_series = data.shomare_serial_plaque;
          // this.form = data.nove_plaque;
          this.form.plate_series_1 = data.plq3;
          this.form.plate_series_2 = data.plq2;
          this.form.plate_series_3 = data.plq1;
          this.form.status = data.is_active_code;
          this.form.year = data.sal_sakht;
          // this.form = data.system_code;
          // this.form = data.type_code;
          this.form.capacity = data.zarfiat;
          // this.form = data.Tedad_mehvar;
          // this.form = data.tarikh_sodor;
          // this.form = data.mahale_daryaft_code;
          // this.form = data.nove_vasile;
          // this.form = data.nove_navgan_mosaferi_code;
          // this.form = data.naja_id;
          // this.form = data.moa_date;
          this.form.nation_code = data.NATIONAL_ID;
          this.form.name = data.NAME_MALEK;
          if (parseInt(data.is_active_code) == 1) {
            this.form.status_note =
              "مدارک این وسیله نقلیه تایید و امکان دریافت صورت وضعیت را دارد.";
          } else {
            this.form.status_note =
              "خطای در مدارک این وسیله نقلیه وجود دارد. کد راهداری : " +
              data.is_active_code;
          }
          this.$notify({
            group: "dataGetter",
            title: "استعلام اطلاعات وسیله نقلیه",
            text: "اطلاعات با موفقیت دریافت شد لطفا اطلاعات را با دقت بررسی فرمایید.",
            type: "success",
            duration: 10000,
          });
          this.checkYear();
          this.modalShow = false;
          return response.data;
        })
        .catch((error) => {
          let e = error.response;
          if (e.status === 500 || e.status === 404) {
            let er = e.data;
            if (er) {
              this.$notify({
                group: "dataGetter",
                text: er.message,
                type: "error",
                duration: 10000,
              });
            }
          }
          return;
        });
    },
    getVehicleInfoFromASKOK() {
      this.$notify({
        group: "dataGetter",
        title: "استعلام اطلاعات وسیله نقلیه",
        text: "در حال دریافت اطلاعات وسیله نقلیه از انجمن لطفا شکیبا باشید ...",
        duration: 10000,
      });
      let promise = this.$http.get(
        this.$api("api/v1/client/core/askok/vehicle/" + this.form.vehicle_card_number)
      );
      return promise
        .then((response) => {
          var data = response.data;
          this.form.vin = data.vin;
          this.form.car_type_id = data.car_type_id;
          this.form.car_system_id = data.car_system_id;
          this.form.car_card_no = data.car_card_no;
          this.form.year = data.year;
          this.form.fuel = data.fuel;
          this.form.capacity = data.capacity;
          this.form.plate_series = data.plate_series;
          this.form.plate_series_1 = data.plate_series_1;
          this.form.plate_series_2 = data.plate_series_2;
          this.form.plate_series_2_en = data.plate_series_2_en;
          this.form.plate_series_3 = data.plate_series_3;
          this.form.status = data.status;

          this.onSelectVehicleType(
            this.vehicleType.find((item) => item.name === data.car_system.name)
          );
          this.onSelectVehicleBrand(
            this.vehicleBrand.find((item) => item.name === data.car_type.name)
          );

          if (data.insurance_body != null) {
            this.form.insurance_body = 1;
            this.form.insurance_body_code = data.insurance_body.code;
            this.form.insurance_body_expire_date = moment(
              data.insurance_body.expire_date,
              "jYYYY/jMM/jDD"
            )
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
            this.form.insurance_body_company_id =
              data.insurance_body.insurance_company_id;
            this.form.insurance_type = 1;
            this.onSelectInsuranceCompanyBody(
              this.insurance_companies.find(
                (item) => item.id === parseInt(data.insurance_body.insurance_company_id)
              )
            );
          }
          if (data.insurance_third != null) {
            this.form.insurance_code = data.insurance_third.code;
            this.form.insurance_expire_date = moment(
              data.insurance_third.expire_date,
              "jYYYY/jMM/jDD"
            )
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
            this.form.insurance_company_id = data.insurance_third.insurance_company_id;
            this.form.insurance_type = 3;
            this.onSelectInsuranceCompany(
              this.insurance_companies.find(
                (item) => item.id === parseInt(data.insurance_third.insurance_company_id)
              )
            );
          }
          if (data.technical_diagnose != null) {
            this.form.car_technical_diagnoses_code = data.technical_diagnose.code;
            this.form.car_technical_diagnoses_expire_date = moment(
              data.technical_diagnose.expire_date,
              "jYYYY/jMM/jDD"
            )
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
          }
          if (data.destenations.length > 0) {
            this.company = this.companies.find(
              (item) => item.partnear_code == parseInt(data.destenations[0].company.company_code)
            );
            this.onSelectCompany(this.company);
          }
          if (data.owner != null) {
            this.form.name = data.owner.flname;
            this.form.father_name = data.owner.father;
            this.form.nation_code = data.owner.nation_code;
            this.form.marital_status = data.owner.marital_status;
            this.form.sex = data.owner.sex;
            this.form.tel = data.owner.tel;
            this.form.mobile = data.owner.mobile;
            this.form.postal_code = data.owner.postal_code;
            this.form.address = data.owner.address;
            this.form.city = data.owner.city;
            this.form.county = data.owner.county;
            this.form.province = data.owner.province;
            this.form.birthday = moment(data.owner.birthday, "jYYYY/jMM/jDD")
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
            this.owner_province = this.provinces.find(
              (item) => item.id === parseInt(data.owner.province)
            );
            this.getOwnerCounties(data.owner.province);
            this.getOwnerCities(data.owner.county);
            setTimeout(() => {
              this.owner_county = this.owner_counties.find(
                (item) => item.id === parseInt(data.owner.county)
              );
            }, 500);
            setTimeout(() => {
              this.owner_city = this.owner_cities.find(
                (item) => item.id === parseInt(data.owner.city)
              );
            }, 500);
          }

          this.$notify({
            group: "dataGetter",
            title: "استعلام اطلاعات وسیله نقلیه",
            text: "اطلاعات با موفقیت دریافت شد لطفا اطلاعات را با دقت بررسی فرمایید.",
            type: "success",
            duration: 10000,
          });
          this.checkYear();
          this.modalShow = false;
          return response.data;
        })
        .catch((error) => {
          console.error(error);
          if (error.response != undefined) {
            let e = error.response;
            if (e.status === 500 || e.status === 404) {
              let er = e.data;
              if (er) {
                this.$notify({
                  group: "dataGetter",
                  text: er.message,
                  type: "error",
                  duration: 10000,
                });
              }
            }
          }
          return;
        });
    },
    getProvinces() {
      let promise = this.$http.get(this.$api("api/v1/client/core/provinces"));
      return promise
        .then((response) => {
          this.provinces = response.data;
          return response.data;
        })
        .catch((error) => {
          this.provinces = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/client/core/counties/" + province)
        );
        return promise
          .then((response) => {
            this.counties = response.data;
            return response.data;
          })
          .catch((error) => {
            this.counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/client/core/cites/" + county));
        return promise
          .then((response) => {
            this.cities = response.data;
            return response.data;
          })
          .catch((error) => {
            this.cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.cities = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getOwnerCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/client/core/counties/" + province)
        );
        return promise
          .then((response) => {
            this.owner_counties = response.data;
            return response.data;
          })
          .catch((error) => {
            this.owner_counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.owner_counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getOwnerCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/client/core/cites/" + county));
        return promise
          .then((response) => {
            this.owner_cities = response.data;
            return response.data;
          })
          .catch((error) => {
            this.owner_cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.owner_cities = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCompanies() {
      let promise = this.$http.get(this.$api("api/v1/client/partnears/list/companies"));

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
    getRoutes(car_type_id) {
      var gURL = "";
      if (car_type_id != undefined) {
        gURL = "api/v1/client/routes/list?car_type_id=" + car_type_id;
      } else {
        gURL = "api/v1/client/routes/list";
      }
      let promise = this.$http.get(this.$api(gURL));
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
    getVehicleType() {
      let promise = this.$http.get(this.$api("api/v1/client/core/vehicle-types/list"));
      return promise
        .then((response) => {
          this.vehicleType = response.data;
          return response.data;
        })
        .catch((error) => {
          this.vehicleType = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getVehicleBrand() {
      let promise = this.$http.get(this.$api("api/v1/client/core/vehicle-brands/list"));
      return promise
        .then((response) => {
          this.vehicleBrand = response.data;
          return response.data;
        })
        .catch((error) => {
          this.vehicleBrand = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      this.form.partnear_code = this.form.vehicle_code;
      if (this.$route.params.id) {
        let promise = this.$http.put(
          this.$api(this.api + "/" + this.$route.params.id),
          this.form
        );

        promise
          .then((response) => {
            this.isEdited = this.dismissSecs;
            this.$router.push(this.$route.query.redirect || this.baseUrl);
          })
          .catch((error) => {
            this.isAlert = this.dismissSecs;
            let e = error.response;
            if (e.status === 422 || e.status === 409) {
              let er = e.data;
              if (er) {
                for (var i = 0; i < Object.keys(er).length; i++) {
                  this.$notify({
                    group: "error",
                    text: er[Object.keys(er)[i]][0],
                    type: "error",

                    duration: 10000 + i * 1000,
                  });
                }
              }
            }
            console.error("Dashboard Error : " + error);
          });
      } else {
        let promise = this.$http.post(this.$api(this.api + "/new"), this.form);
        promise
          .then((response) => {
            this.$router.push(this.$route.query.redirect || this.baseUrl);
          })
          .catch((error) => {
            this.isAlert = this.dismissSecs;
            let e = error.response;
            if (e.status === 422 || e.status === 409) {
              let er = e.data;
              if (er) {
                for (var i = 0; i < Object.keys(er).length; i++) {
                  this.$notify({
                    group: "error",
                    text: er[Object.keys(er)[i]][0],
                    type: "error",

                    duration: 10000 + i * 1000,
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
      this.form.route_id = null;
      this.form.vehicle_code = null;
      this.form.vehicle_card_number = null;
      this.form.car_type_id = null;
      this.form.car_system_id = null;
      this.form.vin = null;
      this.form.year = null;
      this.form.fuel = 1;
      this.form.capacity = null;
      this.form.plate_series = null;
      this.form.plate_series_1 = null;
      this.form.plate_series_2 = null;
      this.form.plate_series_3 = null;
      this.form.insurance_body = 0;
      this.form.status_note = null;
      this.form.status = 1;

      this.form.insurance_id = null;
      this.form.insurance_company_id = null;
      this.form.insurance_code = null;
      this.form.insurance_expire_date = null;
      this.form.insurance_type = null;
      this.form.insurance_status = 1;

      this.form.car_technical_diagnoses_id = null;
      this.form.car_technical_diagnoses_code = null;
      this.form.car_technical_diagnoses_expire_date = null;
      this.form.car_technical_diagnoses_status = 1;

      this.form.fname = null;
      this.form.lname = null;
      this.form.father_name = null;
      this.form.nation_code = null;
      this.form.tel = null;
      this.form.address = null;
      this.form.mobile = null;
      this.form.birthday = null;
      this.form.marital_status = 0;
      this.form.sex = 0;
      this.form.province = null;
      this.form.county = null;
      this.form.city = null;
      this.form.owner_status = 1;

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
    routeLabel(value) {
      if (value.route_code != undefined) return value.route_code + " - " + value.name;
      return "خط سیری برای این نوع وسلیه نقلیه یافت نشد.";
    },
    companyLabel(value) {
      if (value.partner != undefined) return value.partner;
      return "---";
    },
  },
};
</script>
