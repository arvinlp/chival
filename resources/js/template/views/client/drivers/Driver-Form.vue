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
                <span v-if="isEdit">ویرایش اطلاعات راننده</span>
                <span v-else>اطلاعات راننده</span>
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
                <label class="col-2 col-form-label">کد راننده</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.driver_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    v-on:keyup="check(form.driver_code)"
                    min="1000"
                  />
                </div>
                <div class="col-12" v-if="error != null">
                  <small>{{ error }}</small>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">کد ملی</label>
                <div class="col-6">
                  <input
                    type="number"
                    v-model.trim="form.nation_code"
                    placeholder="را به صورت کامل و بدون خط تیره وارد نماید"
                    class="form-control"
                    lang="fa"
                  />
                </div>
                <div class="col-3 mt-2">
                  <a class="btn btn-primary w-100" @click="getDriverInfo()"
                    >دریافت اطلاعات</a
                  >
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <div class="pick_profile">
                  <avatar-cropper
                    @uploaded="handleUploaded"
                    @uploading="handleUploading"
                    @completed="handleCompleted"
                    trigger="#pick-avatar"
                    :upload-url="uploadImageURL"
                    :upload-headers="this.setAuthorize()"
                    :labels="{ submit: 'تایید', cancel: 'انصراف' }"
                  />
                  <img class="profile" v-if="form.picture" :src="form.picture" />
                  <span id="pick-avatar" class="profile_placeholder">
                    <i class="fas fa-plus-circle fa-3x"></i>
                    <br />تصویر را انتخاب کنید.
                  </span>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <b-col cols="12" class="row pt-3 pb-3">
                  <label class="col-3 col-form-label">شماره کارت هوشمند</label>
                  <div class="col">
                    <input
                      type="number"
                      v-model.number="form.driver_card_no"
                      placeholder="مشخصات درست را وارد نمایید."
                      class="form-control"
                    />
                  </div>
                </b-col>
                <b-col cols="12" class="row pb-3">
                  <label class="col-3 col-form-label">نام</label>
                  <div class="col-9">
                    <input
                      lang="fa-IR"
                      dir="rtl"
                      id="FirstName"
                      name="FirstName"
                      type="text"
                      v-model.trim="form.fname"
                      placeholder="مشخصات درست را وارد نمایید."
                      class="form-control"
                    />
                  </div>
                </b-col>
                <b-col cols="12" class="row pb-3">
                  <label class="col-3 col-form-label">نام خانوادگی</label>
                  <div class="col-9">
                    <input
                      type="text"
                      v-model.trim="form.lname"
                      placeholder="مشخصات درست را وارد نمایید."
                      class="form-control"
                      lang="fa"
                    />
                  </div>
                </b-col>
                <b-col cols="12" class="row pb-3">
                  <label class="col-3 col-form-label">نام پدر</label>
                  <div class="col-9">
                    <input
                      type="text"
                      v-model.trim="form.father"
                      placeholder="مشخصات درست را وارد نمایید."
                      class="form-control"
                      lang="fa"
                    />
                  </div>
                </b-col>
                <b-col cols="12" class="row pb-3">
                  <label class="col-3 col-form-label">تاریخ تولد</label>
                  <b-col cols="9">
                    <date-picker
                      type="date"
                      v-model="form.birthday"
                      view="year"
                      format="YYYY-MM-DD HH:mm:ss"
                      display-format="jDD jMMMM jYYYY"
                      placeholder="تاریخ را انتخاب کنید."
                    />
                  </b-col>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تلفن ثابت</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.tel"
                    placeholder="شماره تلفن را به صورت 02133442255 وارد نماید"
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">موبایل</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.mobile"
                    placeholder="شماره موبایل را بدون صفر ابتدا وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">جنسیت</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Male"
                    type="radio"
                    v-model.trim="form.sex"
                    value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Male"> <span></span>مرد </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">وضعیت تاهل</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Single"
                    type="radio"
                    v-model.trim="form.marital_status"
                    value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Single"> <span></span>مجرد </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
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
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">توضیحات</label>
                <div class="col-11 text-justify text-small">{{ form.driver_note }}</div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <!-- Address -->
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>آدرس محل سکونت</span>
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
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-1 col-form-label">آدرس پستی</label>
                <div class="col-11">
                  <textarea
                    type="text"
                    v-model.trim="form.address"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <!-- Drive Info -->
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات حرفه ای</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">شماره گواهینامه</label>
                <div class="col-8">
                  <input
                    type="number"
                    v-model.trim="form.driver_license"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col col-form-label">تاریخ انقضا</label>
                <b-col cols="10">
                  <date-picker
                    type="date"
                    v-model="form.driver_license_expire"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col col-form-label">شماره کارت صحت سلامت</label>
                <b-col cols="8">
                  <input
                    type="number"
                    v-model.trim="form.driver_health"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </b-col>
              </div>
            </b-col>
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col col-form-label">تاریخ انقضا</label>
                <b-col cols="10">
                  <date-picker
                    type="date"
                    v-model="form.driver_health_expire"
                    view="year"
                    format="YYYY-MM-DD HH:mm:ss"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </b-col>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <!-- Book Time -->
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>دفترچه ثبت ساعت</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره دفترچه</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.driver_book_code"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
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
                    v-model="form.driver_book_expire_date"
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
      <!-- Car -->
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="12">
                <span>وسیله نقلیه‌ی پیش فرض</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">انتخاب وسیله نقلیه</label>
                <div class="col-10">
                  <multiselect
                    v-model="car_id"
                    :custom-label="carName"
                    track-by="id"
                    placeholder="وسیله نقلیه پیش فرض راننده را انتخاب کنید."
                    open-direction="bottom"
                    :options="cars"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectCar"
                    @change="onSelectCar"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col>
      <!-- Contract -->
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>قرارداد</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شماره قرارداد</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.contract_number"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
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
                    v-model="form.contract_expire_date"
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
      <!-- Insurance -->
      <!-- <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اقساط بیمه تکمیلی</span>
                <small class="text-muted">
                  این بخش اجباری
                  <u>نمی باشد</u>.
                </small>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مبلغ ماهانه</label>
                <div class="col-10">
                  <currency-input
                    v-model.number="form.insurance_price"
                    v-on:change="calc"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">تعداد نفرات</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.insurance_people"
                    v-on:change="calc"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">کسر از تعداد</label>
                <div class="col-10">
                  <input
                    type="number"
                    v-model.number="form.insurance_number"
                    v-on:change="calc"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">مبلغ کسر</label>
                <div class="col-10">
                  <currency-input
                    v-model.number="form.insurance_amount"
                    placeholder="مشخصات درست را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </b-col> -->
      <!-- destanation -->
      <b-col cols="12" v-if="!this.isEdit">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>شرکت‌</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col>
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
            <b-col>
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شرکت مقصد</label>
                <div class="col-10">
                  <multiselect
                    v-model="company_dest_id"
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
        </div>
      </b-col>
      <!-- Banks -->
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>اطلاعات حساب</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">بانک</label>
                <div class="col-10">
                  <multiselect
                    v-model="bank_id"
                    label="name"
                    track-by="id"
                    placeholder="بانک را انتخاب کنید."
                    open-direction="bottom"
                    :options="banks"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                    @select="onSelectBank"
                    @change="onSelectBank"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شماره حساب</label>
                <div class="col-10">
                  <input
                    v-model.trim="form.bank_number"
                    placeholder="شماره حساب را وارد نمایید."
                    class="form-control"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شبا</label>
                <div class="col-10">
                  <span class="iban_ir">IR</span>
                  <input
                    v-model="form.bank_iban"
                    placeholder="شماره شبا را بدون IR وارد نمایید"
                    class="form-control iban_number"
                    pattern="(?=.{24}$)[0-9]*"
                  /><!-- check -->
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">شماره کارت</label>
                <div class="col-10">
                  <input
                    v-model.trim="form.bank_card"
                    placeholder="بدون فاصله وارد شود."
                    class="form-control"
                    v-on:keyup="checkCreditCardBank"
                  /><!-- check -->
                </div>
                <small v-if="cardError" class="col-12"
                  >خطا: شماره کارت وارد شده معتبر نمی باشد.</small
                >
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
              @click="getDriverInfoFromASKOK()"
            >
              انجمن صنفی شرکت‌های مسافربری سواری کرایه
            </b-button>
          </b-col>
          <b-col cols="12">
            <b-button
              size="md"
              class="d-block mx-auto"
              variant="success"
              @click="getDriverInfoFromRMTO()"
            >
              اداره کل راه داری کشور
            </b-button>
          </b-col>
        </b-row>
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import AvatarCropper from "vue-avatar-cropper";
var moment = require("moment-jalaali");

export default {
  data() {
    return {
      form: {
        company_id: null,
        company_dest_id: null,
        car_id: null,
        contract_id: null,
        driver_book_id: null,
        fname: null,
        lname: null,
        father: null,
        nation_code: null,
        birthday: null,
        marital_status: 0,
        sex: 0,
        tel: null,
        mobile: null,
        province: null,
        county: null,
        city: null,
        address: null,
        picture: null,
        driver_note: "جهت دریافت اطلاعات شماره کارت هوشمند وسیله نقلیه را بررسی کنید.",
        driver_code: null,
        driver_card_no: null,
        driver_license: null,
        driver_health: null,
        driver_health_status: 3,
        driver_license_status: 3,
        insurance_price: null,
        insurance_people: null,
        insurance_number: null,
        insurance_amount: null,
        bank_id: null,
        bank_number: null,
        bank_iban: null,
        bank_card: null,
        status: 1,

        destenation_company: null,
        contract_number: null,
        contract_expire_date: null,
        driver_book_code: null,
        driver_book_expire_date: null,
      },
      file_location: "/avatars/chival/driver",
      uploadImageURL: this.$api("api/v1/client/upload"),
      showModal: false,
      isEdit: false,
      isLoading: false,

      //
      cardError: true,
      btnDisabled: true,
      error: null,

      companies: [],
      routes: [],
      provinces: [],
      counties: [],
      cities: [],
      banks: [],
      cars: [],
      destenation_counties: [],
      destenation_cities: [],
      company_dest_id: null,
      company_id: null,
      bank_id: null,
      province: null,
      county: null,
      city: null,
      destenation_province: null,
      destenation_county: null,
      destenation_city: null,
      car_id: null,

      baseUrl: { name: "client-drivers" },
      api: "api/v1/client/drivers",

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,

      modalShow: false,
    };
  },

  components: {
    Body,
    CardProgress,
    AvatarCropper,
  },

  computed: {
    isUserData: function () {
      return this.$store.getters.user;
    },
    getAmount: function () {
      return 0;
    },
  },
  mounted() {
    this.getBanks();
    this.getCars();
    this.getCompanies("");
    // this.getProvinces();
    this.file_location = "/company/" + this.isUserData["company_id"] + "/drivers";
    if (this.$route.params.id) {
      this.isEdit = true;
      this.btnDisabled = true; //////////////// default false
      let promise = this.$http.get(this.$api(this.api + "/" + this.$route.params.id));
      promise
        .then((response) => {
          this.form = response.data;
          this.province = this.provinces.find(
            (item) => item.id === parseInt(response.data.province)
          );
          this.car_id = this.cars.find(
            (item) => item.id === parseInt(response.data.car_id)
          );
          this.bank_id = this.banks.find(
            (item) => item.id === parseInt(response.data.bank_id)
          );
          this.checkCreditCardBank();
          this.getCounties(parseInt(response.data.province));
          this.getCities(parseInt(response.data.county));
          if (response.data.driver_note == null) {
            this.form.driver_note = "وضعیت فعالیت این راننده نامشخص است !";
            this.form.status = 3;
          }

          if (response.data.partnear_code != "-") {
            this.form.driver_code = response.data.partnear_code;
            this.baseUrl = { name: "client-partnear-drivers" };
          } else {
            this.form.driver_code = response.data.driver_code;
          }
        })
        .catch((error) => {
          this.$router.push(this.$route.query.redirect || this.baseUrl);
        });
    }
  },
  watch: {
    onDateChenge: function (value) {
      console.log(value);
    },
  },
  methods: {
    checkCreditCardBank() {
      this.cardError = this.verifyCard(this.form.bank_card) ? false : true;
    },
    verifyCard(code) {
      var L = code.length;
      if (
        L < 16 ||
        parseInt(String(code).substr(1, 10), 10) == 0 ||
        parseInt(String(code).substr(10, 6), 10) == 0
      )
        return false;
      var c = parseInt(String(code).substr(15, 1), 10);
      var s = 0;
      var k, d;
      for (var i = 0; i < 16; i++) {
        k = i % 2 == 0 ? 2 : 1;
        d = parseInt(String(code).substr(i, 1), 10) * k;
        s += d > 9 ? d - 9 : d;
      }
      return s % 10 == 0;
    },
    check(value) {
      let promise = this.$http.get(this.$api("api/v1/client/check/driver/" + value));

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
    calc(value) {
      this.form.insurance_amount = this.form.insurance_price / this.form.insurance_number;
    },
    onSelectCompany(value) {
      this.company_id = value;
      this.form.company_id = value.id;
    },
    onSelectBank(value) {
      this.bank_id = parseInt(value.id);
      this.form.bank_id = parseInt(value.id);
    },
    onSelectCar(value) {
      this.car_id = value;
      this.form.car_id = parseInt(value.id);
    },
    onSelectCompanyDest(value) {
      this.company_dest_id = value;
      this.form.company_dest_id = value.id;
    },
    onSelectProvince(value) {
      this.form.province = parseInt(value.id);
      this.province = parseInt(value);
      this.county = null;
      this.city = null;
      this.getCounties(parseInt(value.id));
    },
    onSelectCounty(value) {
      this.form.county = parseInt(value.id);
      this.county = parseInt(value);
      this.city = null;
      this.getCities(parseInt(value.id));
    },
    onSelectCity(value) {
      this.city = parseInt(value);
      this.form.city = parseInt(value.id);
      this.getCompanies(parseInt(value.id));
    },
    onSelectDestenationProvince(value) {
      this.destenation_province = parseInt(value.id);
      this.destenation_county = null;
      this.destenation_city = null;
      this.getDestenationCounties(parseInt(value.id));
    },
    onSelectDestenationCounty(value) {
      this.destenation_county = parseInt(value.id);
      this.destenation_city = null;
      this.getDestenationCities(parseInt(value.id));
    },
    onSelectDestenationCity(value) {
      this.destenation_city = parseInt(value.id);
    },
    selectCity() {
      this.province = this.provinces.find(
        (item) => item.id == parseInt(this.form.province)
      );
      this.getCounties(parseInt(province.id));
    },
    getDriverInfo() {
      if (this.form.nation_code) {
        this.modalShow = true;
      } else {
        this.$notify({
          group: "dataGetter",
          title: "استعلام اطلاعات راننده",
          text: "لطفا کد ملی راننده را وارد نمایید.",
          type: "warn",
          duration: 5000,
        });
      }
    },
    getDriverInfoFromRMTO() {
      this.$notify({
        group: "dataGetter",
        title: "استعلام اطلاعات راننده",
        text: "در حال دریافت اطلاعات راننده لطفا شکیبا باشید ...",
        duration: 1000,
      });
      let promise = this.$http.get(
        this.$api("api/v1/client/core/rmto/driver/" + this.form.nation_code)
      );
      return promise
        .then((response) => {
          var data = response.data;
          this.form.driver_card_no = data.no_kart;
          // this.form.fname           = data.tarikh_sodor
          this.form.fname = data.name;
          this.form.lname = data.family;
          this.form.father = data.father_name;
          this.form.birthday = moment(data.birth_date, "jYYYY/jMM/jDD")
            .locale("fa")
            .format("YYYY-MM-DD HH:mm:ss");
          // this.form.fname = data.nove_ranandeh
          this.form.driver_license = data.shomare_gavahinameh;
          // this.form.fname = data.somare_bime
          this.form.status = data.is_active;
          this.form.driver_license_expire = moment(
            data.tarikh_payan_etebar,
            "jYYYYjMMjDD"
          )
            .locale("fa")
            .format("YYYY-MM-DD HH:mm:ss");
          this.form.des = data.shahr_mahal_sokonat;
          // this.form.fname = data.mahale_daryaft
          this.form.driver_note = data.comments;
          this.form.driver_health_expire = moment(data.salamat_date, "jYYYY/jMM/jDD")
            .locale("fa")
            .format("YYYY-MM-DD HH:mm:ss");
          this.form.driver_health = data.salamat_no;

          this.$notify({
            group: "dataGetter",
            title: "استعلام اطلاعات راننده",
            text: "اطلاعات با موفقیت دریافت شد لطفا اطلاعات را با دقت بررسی فرمایید.",
            type: "success",
            duration: 10000,
          });
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
    getDriverInfoFromASKOK() {
      this.$notify({
        group: "dataGetter",
        title: "استعلام اطلاعات راننده",
        text: "در حال دریافت اطلاعات راننده از انجمن لطفا شکیبا باشید ...",
        duration: 1000,
      });
      let promise = this.$http.get(
        this.$api("api/v1/client/core/askok/driver/" + this.form.nation_code)
      );
      return promise
        .then((response) => {
          const data = response.data;
          try {
            this.form.fname = data.fname;
            this.form.lname = data.lname;
            this.form.father = data.father;
            this.form.birthday = moment(data.birthday, "jYYYY/jMM/jDD")
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
            this.form.marital_status = parseInt(data.marital_status) ? 1 : 0;
            this.form.sex = parseInt(data.sex) ? 1 : 0;
            this.form.tel = data.tel;
            this.form.mobile = parseInt(data.mobile);
            this.form.province = parseInt(data.province);
            this.form.county = parseInt(data.county);
            this.form.city = parseInt(data.city);

            this.province = this.provinces.find(
              (item) => item.id === parseInt(data.province)
            );
            this.getCounties(data.province);
            this.getCities(data.county);
            this.getCompanies(data.city);
            setTimeout(() => {
              this.county = this.counties.find(
                (item) => item.id === parseInt(data.county)
              );
            }, 500);
            setTimeout(() => {
              this.city = this.cities.find((item) => item.id === parseInt(data.city));
            }, 500);

            this.form.rmto_city = parseInt(data.rmto_city);
            this.form.address = data.address;
            this.form.postal_code = data.postal_code;
            this.form.picture = data.picture;
            this.form.driver_card_no = parseInt(data.driver_card_no);
            this.form.driver_license = parseInt(data.driver_license);
            this.form.driver_health = parseInt(data.driver_health);
            this.form.driver_health_status = data.driver_health_status;
            this.form.driver_license_status = data.driver_license_status;
            this.form.driver_health_expire = moment(
              data.driver_health_expire,
              "jYYYY/jMM/jDD"
            )
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");
            this.form.driver_license_expire = moment(
              data.driver_license_expire.slice(0, 3) +
                "/" +
                data.driver_license_expire.slice(4, 5) +
                "/" +
                data.driver_license_expire.slice(6, 7),
              "jYYYY/jMM/jDD"
            )
              .locale("fa")
              .format("YYYY-MM-DD HH:mm:ss");

            this.bank_id = this.banks.find((item) => item.id == parseInt(data.bank_id));
            this.form.bank_id = data.bank_id;
            this.form.bank_number = data.bank_number;
            this.form.bank_iban = data.bank_iban;
            this.form.bank_card = data.bank_card;
            if (data.bank_iban.length && data.bank_card.length) {
              this.btnDisabled = false;
            }

            if (data.vehicles.length > 0) {
              if (data.vehicles[0] != undefined) {
                this.onSelectCar(
                  this.cars.find((item) => item.vin === data.vehicles[0].car.vin)
                );
              }
            }

            if (data.book_times.length > 0) {
              this.form.driver_book_code = data.book_times[0].code;
              this.form.driver_book_expire_date = moment(
                data.book_times[0].expire_date,
                "jYYYY/jMM/jDD"
              )
                .locale("fa")
                .format("YYYY-MM-DD HH:mm:ss");
            }
          } catch (e) {
            alert(e);
            console.error("Error", e);
          }
          this.modalShow = false;
          this.$notify({
            group: "dataGetter",
            title: "استعلام اطلاعات راننده",
            text: "اطلاعات با موفقیت دریافت شد لطفا اطلاعات را با دقت بررسی فرمایید.",
            type: "success",
            duration: 10000,
          });
        })
        .catch((error) => {
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
    getCars() {
      let promise = this.$http.get(this.$api("api/v1/client/vehicles/list"));
      return promise
        .then((response) => {
          this.cars = response.data;
          return response.data;
        })
        .catch((error) => {
          this.provinces = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
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
            if (this.isEdit)
              this.county = this.counties.find(
                (item) => item.id === parseInt(this.form.county)
              );
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
            if (this.isEdit)
              this.city = this.cities.find(
                (item) => item.id === parseInt(this.form.city)
              );
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
    getDestenationCounties(province) {
      if (province) {
        let promise = this.$http.get(
          this.$api("api/v1/client/core/counties/" + province)
        );
        return promise
          .then((response) => {
            this.destenation_counties = response.data;
            return response.data;
          })
          .catch((error) => {
            this.destenation_counties = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.destenation_counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getDestenationCities(county) {
      if (county) {
        let promise = this.$http.get(this.$api("api/v1/client/core/cites/" + county));
        return promise
          .then((response) => {
            this.destenation_cities = response.data;
            return response.data;
          })
          .catch((error) => {
            this.destenation_cities = [{ id: 0, name: "-----" }];
            return [{ id: 0, name: "-----" }];
          });
      }
      this.destenation_cities = [{ id: 0, name: "-----" }];
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
    getBanks() {
      let promise = this.$http.get(this.$api("api/v1/client/core/banks"));

      return promise
        .then((response) => {
          this.banks = response.data;
          return response.data;
        })
        .catch((error) => {
          this.companies = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
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
          });
      }
    },
    onReset(evt) {
      evt.preventDefault();

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
    carName(value) {
      return (
        "کد وسیله نقلیه : " +
        value.car_code +
        " - پلاک : ایران " +
        value.plate_series +
        " | " +
        value.plate_series_1 +
        " - " +
        value.plate_series_1 +
        " - " +
        value.plate_series_3
      );
    },
    companyLabel(value) {
      if (value.partner != undefined) return value.partner;
      return "---";
    },
    handleUploading(form, xhr) {
      if (this.form.picture != "") form.append("old_file", this.form.picture);
      form.append("file_location", this.file_location);
    },
    handleUploaded(response, form, xhr) {
      this.form.picture = this.$asestUrl(response.data.file);
    },
    handleCompleted(response, form, xhr) {},
    handlerError(message, type, xhr) {
      if (type == "upload") {
        // xhr.response...
      }
    },
  },
};
</script>
