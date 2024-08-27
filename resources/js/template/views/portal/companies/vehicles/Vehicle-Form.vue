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
                <span v-if="isEdit">ویرایش اطلاعات وسلیه نقلیه</span>
                <span v-else>اطلاعات وسلیه نقلیه</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100">بازگشت</router-link>
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
                  />
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
                  <button class="btn btn-primary w-100">بررسی</button>
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
                <small
                  class="col-12 text-right text-small"
                >ظرفیت وسیله نقلیه بصورت خودکار وارد می شود در صورت نادرست بودن ویرایش کنید، این ظرفیت بدون احتساب راننده می باشد.</small>
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
                    min="1360"
                    max="1410"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">سوخت وسیله نقلیه</label>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Ouil"
                    type="radio"
                    v-model.trim="form.fuel"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Ouil">
                    <span></span>بنزین
                  </label>
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
                <div class="col-11 text-justify text-small">
                  {{form.status_note}}
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
                <span>مقصد</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">استان</label>
                <div class="col-10">
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
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهر</label>
                <div class="col-10">
                  <multiselect
                    v-model="county"
                    label="name"
                    track-by="id"
                    placeholder="شهر را انتخاب کنید."
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
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شهرستان</label>
                <div class="col-10">
                  <multiselect
                    v-model="city"
                    label="name"
                    track-by="id"
                    placeholder="شهرستان را انتخاب کنید."
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
                </div>
              </div>
            </b-col>
            <b-col cols="6">
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
                <label class="col-3 col-form-label">وسیله نقلیه دارای بیمه بدنه می باشد ؟</label>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="No"
                    type="radio"
                    v-model.trim="form.insurance_body"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="No">
                    <span></span>بیمه بدنه ندارد
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="Yes"
                    type="radio"
                    v-model.trim="form.insurance_body"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Yes">
                    <span></span>بیمه بدنه دارد
                  </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
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
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
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
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.fname"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کد ملی</label>
                <div class="col-8">
                  <input
                    type="number"
                    v-model.trim="form.nation_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
                <div class="col-2">
                  <button class="btn btn-primary w-100">بررسی</button>
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">نام خانوادگی</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.lname"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
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
                    id="Yes"
                    type="radio"
                    v-model.trim="form.marital_status"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Yes">
                    <span></span>متاهل
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
                  <input
                    id="No"
                    type="radio"
                    v-model.trim="form.marital_status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="No">
                    <span></span>مجرد
                  </label>
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
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Male">
                    <span></span>مرد
                  </label>
                </b-col>
                <b-col cols="2" class="form-radio-datamis">
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
                    :options="counties"
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
                    :options="cities"
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
        <button type="submit" class="btn btn-success w-50">ثبت</button>
      </b-col>
    </b-form>
  </section>
</template>

<script>
import Body from "../../../../components/portal/Body";
import CardProgress from "../../../../components/CardProgress";

export default {
  data() {
    return {
      form: {
        company_id: null,
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

        destanations:null,

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
        owner_status: 1
      },
      showModal: false,
      isEdit: false,
      isLoading: false,

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

      baseUrl: "",
      api: null,

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0
    };
  },

  components: {
    Body,
    CardProgress
  },

  computed: {},
  mounted() {
    this.getProvinces();
    this.getRoutes();
    this.getCompanies();
    this.getVehicleType();
    this.getVehicleBrand();
    this.getInsuranceCompanies();
    if (this.$route.params.id) {
      this.baseUrl = "/portal/companies/" + this.$route.params.id + "/vehicles";
      this.api =
        "api/v1/portal/companies/" + this.$route.params.id + "/vehicles";
    } else {
      this.$router.push(this.$route.query.redirect || "/portal/companies/");
    }
    if (this.$route.params.uid) {
      this.isEdit = true;
      let promise = this.$http.get(
        this.$api(this.api + "/" + this.$route.params.uid)
      );
      promise
        .then(response => {
          this.form = response.data;
          this.form.vehicle_code = response.data.car_code
          this.form.vehicle_card_number = response.data.car_card_no
          this.vehicle_brand = {
            id : response.data.car_type.id,
            name : response.data.car_type.name
          }
          this.vehicle_type = {
            id : response.data.car_system.id,
            name : response.data.car_system.name,
          }
          if(response.data.status_note == null){
            this.form.status_note = "وضعیت فعالیت این وسیله نقلیه نامشخص است !"
            this.form.status = 3
          }
        })
        .catch(error => {
          console.error("Get Update Data Error : " + error);
        });
    }
  },
  methods: {
    onSelectRoute(value) {
      this.form.route_id = value.id;
      this.route_id = value.id;
    },
    onSelectCompany(value) {
      this.company_id = value.id;
      this.form.destanations = value.id
    },
    onSelectProvince(value) {
      this.province = value.id;
      this.county = null;
      this.city = null;
      this.getCounties(value.id);
    },
    onSelectCounty(value) {
      this.county = value.id;
      this.city = null;
      this.getCities(value.id);
    },
    onSelectCity(value) {
      this.city = value.id;
      this.getCompanies(value.id);
    },
    onSelectInsuranceCompany(value) {
      this.insurance_company = value;
      this.form.insurance_company_id = value.id
    },
    onSelectInsuranceCompanyBody(value) {
      this.insurance_company_body = value;
      this.form.insurance_body_company_id = value.id
    },
    onSelectOwenerProvince(value) {
      this.owner_province = value.id;
      this.form.province = value.id;
      this.owner_county = null;
      this.owner_city = null;
      this.getOwnerCounties(value.id);
    },
    onSelectOwenerCounty(value) {
      this.owner_county = value.id;
      this.form.county = value.id;
      this.owner_city = null;
      this.getOwnerCities(value.id);
    },
    onSelectOwenerCity(value) {
      this.owner_city = value.id;
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
    getCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/core/counties/" + province)
        );
        return promise
          .then(response => {
            this.counties = response.data;
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
    getCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/core/cites/" + county));
        return promise
          .then(response => {
            this.cities = response.data;
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
    getOwnerCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/core/counties/" + province)
        );
        return promise
          .then(response => {
            this.owner_counties = response.data;
            return response.data;
          })
          .catch(error => {
            this.owner_counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.owner_counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getOwnerCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/core/cites/" + county));
        return promise
          .then(response => {
            this.owner_cities = response.data;
            return response.data;
          })
          .catch(error => {
            this.owner_cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.owner_cities = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCompanies(value) {
      let promise = "";
      if (value != undefined) {
        promise = this.$http.get(
          this.$api("api/v1/portal/companies/list?city=" + value)
        );
      } else {
        promise = this.$http.get(this.$api("api/v1/portal/companies/list"));
      }
      return promise
        .then(response => {
          this.companies = response.data;
          return response.data;
        })
        .catch(error => {
          this.companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getRoutes(car_type_id) {
      var gURL = "";
      if (car_type_id != undefined) {
        gURL =
          "api/v1/portal/companies/" +
          this.$route.params.id +
          "/routes/list?car_type_id=" +
          car_type_id;
      } else {
        gURL =
          "api/v1/portal/companies/" + this.$route.params.id + "/routes/list";
      }
      let promise = this.$http.get(this.$api(gURL));
      return promise
        .then(response => {
          this.routes = response.data;
          return response.data;
        })
        .catch(error => {
          this.routes = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getInsuranceCompanies() {
      let promise = this.$http.get(this.$api("api/v1/core/insurance-companies/list"));
      return promise
        .then(response => {
          this.insurance_companies = response.data;
          return response.data;
        })
        .catch(error => {
          this.insurance_companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getVehicleType() {
      let promise = this.$http.get(this.$api("api/v1/core/vehicle-types/list"));
      return promise
        .then(response => {
          this.vehicleType = response.data;
          return response.data;
        })
        .catch(error => {
          this.vehicleType = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    getVehicleBrand() {
      let promise = this.$http.get(
        this.$api("api/v1/core/vehicle-brands/list")
      );
      return promise
        .then(response => {
          this.vehicleBrand = response.data;
          return response.data;
        })
        .catch(error => {
          this.vehicleBrand = [{ id: 0, name: "-----" }];
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
            console.error("Dashboard Error : " + error);
          });
      } else {
        let promise = this.$http.post(this.$api(this.api + "/new"), this.form);
        promise
          .then(response => {
            console.error(response);
            // this.$router.push(this.$route.query.redirect || this.baseUrl);
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
      if (value.route_code != undefined)
        return value.route_code + " - " + value.name;
      return "خط سیری برای این نوع وسلیه نقلیه یافت نشد.";
    },
    companyLabel(value) {
      if (value.name != undefined) return value.name;
      return "شهر جهت نمایش شرکت انتخاب نشده است.";
    }
  }
};
</script>