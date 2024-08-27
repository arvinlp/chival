<template>
  <section class="page">
    <b-form @submit="onSubmit" class="row">
      <b-col cols="12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span v-if="isEdit">ویرایش سفر دربستی</span>
                <span v-else>سفر دربستی جدید</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <router-link :to="baseUrl" class="btn btn-danger w-100">
                  بازگشت
                </router-link>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">ساعت حرکت</label>
                <div class="col-9">
                  <date-picker
                    type="time"
                    v-model="form.move_time"
                    format="HH:mm"
                    placeholder="ساعت را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تاریخ حرکت</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.move_date"
                    view="day"
                    format="YYYY-MM-DD"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">مدت سفر</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.duration"
                    placeholder="مدت را به عدد وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="1"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">وسیله نقلیه</label>
                <div class="col-9">
                  <multiselect
                    v-model="form.car"
                    :customLabel="customLabelCar"
                    track-by="id"
                    placeholder="وسیله نقلیه را انتخاب کنید."
                    open-direction="bottom"
                    :options="cars"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نوع سفر</label>
                <b-col cols="3" class="form-radio-datamis">
                  <input
                    id="OneWay"
                    type="radio"
                    v-model.trim="form.travel_way"
                    :value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="OneWay"> <span></span>رفت </label>
                </b-col>
                <b-col cols="6" class="form-radio-datamis">
                  <input
                    id="TwoWay"
                    type="radio"
                    v-model.trim="form.travel_way"
                    :value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="TwoWay">
                    <span></span>رفت و برگشت
                  </label>
                </b-col>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">مدت سفر</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Day"
                    type="radio"
                    v-model.trim="form.time_type"
                    :value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Day"> <span></span>روز </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="Hour"
                    type="radio"
                    v-model.trim="form.time_type"
                    :value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="Hour"> <span></span>ساعت </label>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">راننده اصلی</label>
                <div class="col-9">
                  <multiselect
                    v-model="form.driver"
                    :customLabel="customLabelDriver"
                    track-by="id"
                    placeholder="راننده را انتخاب کنید."
                    open-direction="bottom"
                    :options="drivers"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">راننده دوم</label>
                <div class="col-9">
                  <multiselect
                    v-model="form.driver2"
                    :customLabel="customLabelDriver"
                    track-by="id"
                    placeholder="راننده را انتخاب کنید."
                    open-direction="bottom"
                    :options="drivers"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">راننده سوم</label>
                <div class="col-9">
                  <multiselect
                    v-model="form.driver3"
                    :customLabel="customLabelDriver"
                    track-by="id"
                    placeholder="راننده را انتخاب کنید."
                    open-direction="bottom"
                    :options="drivers"
                    :multiple="false"
                    :searchable="true"
                    :loading="isLoading"
                    selectLabel
                    selectedLabel="انتخاب شده"
                    deselectLabel="حذف انتخاب"
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
                <label class="col-2 col-form-label font-size-100">مقاصد رفت</label>
                <b-col cols="10">
                  <multiselect
                    v-model="form.one_way"
                    label="name"
                    track-by="id"
                    placeholder="مقاصد رفت را انتخاب کنید."
                    open-direction="bottom"
                    :options="rmto_destinations"
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
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
                <b-col cols="12" class="text-right">
                  <p>ترتیب مقاصد</p>
                  <ul class="travel-list">
                    <li class="text-right">
                      {{ getUserData.rmto_city_name }}
                    </li>
                    <li
                      v-for="(item, index) in form.one_way"
                      v-bind:key="index"
                      class="text-right"
                    >
                      {{ item.name }}
                    </li>
                  </ul>
                </b-col>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height" v-if="form.travel_way == 1">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label font-size-100">مقاصد برگشت</label>
                <b-col cols="10">
                  <multiselect
                    v-model="form.two_way"
                    label="name"
                    track-by="id"
                    placeholder="مقاصد برگشت را انتخاب کنید."
                    open-direction="bottom"
                    :options="rmto_destinations"
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
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </b-col>
                <b-col cols="12" class="text-right">
                  <p>ترتیب مقاصد</p>
                  <ul class="travel-list">
                    <li
                      v-for="(item, index) in form.two_way"
                      v-bind:key="index"
                      class="text-right"
                    >
                      {{ item.name }}
                    </li>
                    <li class="text-right">
                      {{ getUserData.rmto_city_name }}
                    </li>
                  </ul>
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
              <b-col cols="12">
                <span>قرارداد</span>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">شماره قرارداد</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model.trim="form.contract_number"
                    placeholder="شماره قرارداد را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تاریخ قرارداد</label>
                <div class="col-9">
                  <date-picker
                    type="date"
                    v-model="form.contract_date"
                    view="day"
                    format="YYYY-MM-DD"
                    display-format="jDD jMMMM jYYYY"
                    placeholder="تاریخ را انتخاب کنید."
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">تعداد همراه</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.passenger"
                    placeholder="تعداد همراه را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="0"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="8">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">متقاضی</label>
                <div class="col-10">
                  <input
                    type="text"
                    v-model.trim="form.contract_person"
                    placeholder="نام و نام خانوادگی متقاضی را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">نرخ هر کیلومتر</label>
                <div class="col-8">
                  <currency-input
                    v-model="form.distance_price"
                    placeholder="نرخ هر کیلومتر را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نرخ توقف</label>
                <div class="col-9">
                  <currency-input
                    v-model="form.stop_price"
                    placeholder="نرخ توقف را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">مدت توقف</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.stop"
                    placeholder="مدت توقف را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="0"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-4 col-form-label">نوع توقف</label>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="DayS"
                    type="radio"
                    v-model.trim="form.stop_type"
                    :value="1"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="DayS"> <span></span>روز </label>
                </b-col>
                <b-col cols="4" class="form-radio-datamis">
                  <input
                    id="HourS"
                    type="radio"
                    v-model.trim="form.stop_type"
                    :value="0"
                    class="form-radio-input"
                  />
                  <label class="form-radio-label" for="HourS"> <span></span>ساعت </label>
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
              <b-col cols="12">
                <span>محاسبه مسافت</span>
              </b-col>
            </b-row>
          </div>
          <b-row>
            <b-col cols="12" style="height: 300px">
              <l-map
                :zoom.sync="zoom"
                :center="center"
                :min-zoom="minZoom"
                :max-zoom="maxZoom"
                @click="addMarker"
              >
                <l-tile-layer
                  v-for="tileProvider in tileProviders"
                  :key="tileProvider.name"
                  :name="tileProvider.name"
                  :visible="tileProvider.visible"
                  :url="tileProvider.url"
                  :attribution="tileProvider.attribution"
                  layer-type="base"
                />
                <l-marker
                  v-for="(marker, index) in markers"
                  v-bind:key="index"
                  :visible="marker.visible"
                  :draggable="marker.draggable"
                  :lat-lng.sync="marker.position"
                  :icon="icon"
                  @click="removeMarker(index)"
                />
              </l-map>
            </b-col>
            <b-col cols="12">
              <a v-on:click="getDerectionInfo()" class="btn btn-success w-100 my-3">
                محاسبه
              </a>
            </b-col>
            <b-col cols="12" v-if="locations" class="travel_price">
              <b-row v-for="(item, index) in locations" v-bind:key="index">
                <b-col cols="4" class="text-right">
                  {{ item.origin.province_name }} - {{ item.origin.county_name }} -
                  {{ item.origin.name }}
                </b-col>
                <b-col cols="4" class="text-right">
                  {{ item.destination.province_name }} -
                  {{ item.destination.county_name }} - {{ item.destination.name }}
                </b-col>
                <b-col cols="4" class="text-center travel_price">
                  {{ Number((item.distance / 1000).toFixed(3)) }} کیلومتر
                </b-col>
              </b-row>
            </b-col>
            <b-col cols="6" class="mt-3 text-right travel_price">
              جمع کل مسافت : {{ Number((distance / 1000).toFixed(3)) }} کیلومتر
            </b-col>
            <b-col cols="6" class="mt-3 text-right travel_price">
              مدت زمان تخمینی مسافت :
              {{ Number((duration / 60).toFixed(0)) }} دقیقه
            </b-col>
            <b-col cols="12" class="mt-3 text-right travel_price">
              نرخ خالص مسافت : {{ Number((distance / 1000).toFixed(3)) }} کیلومتر *
              {{ formatPrice(form.distance_price) }} ریال/کیلومتر =
              {{
                formatPrice(Number((distance / 1000).toFixed(3)) * form.distance_price)
              }}
              ریال
            </b-col>
            <b-col cols="12" class="mt-3 text-right travel_price">
              نرخ خالص توقف : {{ formatPrice(form.stop_price) }} ریال *
              {{ form.stop }} مدت = {{ formatPrice(form.stop * form.stop_price) }} ریال
            </b-col>
            <b-col cols="12" class="mt-3 text-right travel_price">
              جمع کل : <small>مسافت خالص</small>
              {{
                formatPrice(Number((distance / 1000).toFixed(3)) * form.distance_price)
              }}
              ریال + <small>توقف</small>
              {{ formatPrice(form.stop * form.stop_price) }} ریال =
              {{
                formatPrice(
                  (Number((distance / 1000).toFixed(3)) * form.distance_price) +
                    (form.stop * form.stop_price)
                )
              }}
              ریال
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">توشه اضافی</label>
                <div class="col-9">
                  <currency-input
                    v-model="form.package"
                    placeholder="نرخ توقف را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    v-on:change="totalPriceCal"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">کمیسیون</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.commission"
                    placeholder="درصد کمیسیون را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="0"
                    v-on:change="totalPriceCal"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">عوارض شهرداری</label>
                <div class="col-9">
                  <input
                    type="number"
                    v-model.trim="form.tax"
                    placeholder="درصد عوارض شهرداری را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    :min="0"
                    v-on:change="totalPriceCal"
                  />
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body row-eq-height">
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">بیمه سرنشین</label>
                <div class="col-9">
                  <currency-input
                    v-model="form.insurance"
                    placeholder="بیمه سرنشین را وارد نمایید."
                    class="form-control"
                    lang="fa"
                    v-on:change="totalPriceCal"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">راننده</label>
                <div class="col-9">
                  <currency-input
                    v-model="form.driver_coast"
                    placeholder="خالص پرداختی راننده را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
                </div>
              </div>
            </b-col>
            <b-col cols="4">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">مبلغ کل</label>
                <div class="col-9">
                  <currency-input
                    v-model="form.total_amount"
                    placeholder="مبلغ کل را وارد نمایید."
                    class="form-control"
                    lang="fa"
                  />
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
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";

var moment = require("moment-jalaali");

const tileProviders = [
  {
    name: "OpenStreetMap",
    visible: true,
    attribution:
      'نقشه اختصاصی سامانه <a target="_blank" href="http://osm.org/copyright">مسافربری</a>.',
    url: "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
  },
];

import {
  LPolyline,
  LLayerGroup,
  LTooltip,
  LPopup,
  LControlZoom,
  LControlAttribution,
  LControlScale,
  LControlLayers,
  LIcon,
} from "vue2-leaflet";
import { icon } from "leaflet";

export default {
  data() {
    return {
      form: {
        travel_way: 1,
        passenger: 0,
        distance_price: 10000,
        stop: 0,
        stop_price: 0,
      },

      baseUrl: { name: "client-exclusives" },
      api: "api/v1/client/travel/exclusives",

      center: L.latLng( 57.03753331757921, 30.29570222745681),
      markers: [
        {
          position: { lng: 57.03753331757921, lat: 30.29570222745681 },
          tooltip: "دفتر",
          draggable: true,
          visible: true,
        },
      ],
      icon: icon({
        iconUrl: "/images/location.png",
        iconSize: [32, 32],
        iconAnchor: [15, 25],
      }),
      tileProviders: tileProviders,
      zoom: 9,
      minZoom: 1,
      maxZoom: 20,
      zoomPosition: "topleft",
      imperial: false,
      gettingLocation: false,
      origins: "",
      destinations: "",
      direction: null,
      distance: null,
      duration: null,
      locations: [],

      rmto_destinations: [],

      drivers: [],
      cars: [],
      driver: null,
      driver2: null,
      driver3: null,
      car: null,

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
      isEdit: false,
      isLoading: false,

      api: "api/v1/client/travels/exclusives",
    };
  },

  components: {
    Body,
    CardProgress,
    LPolyline,
    LLayerGroup,
    LTooltip,
    LPopup,
    LControlZoom,
    LControlAttribution,
    LControlScale,
    LControlLayers,
    LIcon,
  },

  computed: {
    getUserData: function () {
      return this.$store.getters.user;
    },

  },
  created() {
    if (!("geolocation" in navigator)) {
      this.errorStr = "Geolocation is not available.";
      return;
    }

    this.gettingLocation = true;
    // get position
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        this.gettingLocation = false;
        this.markers[0].position = {
          lng: pos.coords.longitude,
          lat: pos.coords.latitude,
        };
        this.center = L.latLng(
          this.markers[0].position.lat,
          this.markers[0].position.lng
        );
      },
      (err) => {
        this.gettingLocation = false;
        this.errorStr = err.message;
      }
    );
  },
  mounted() {
    this.getDrivers();
    this.getCars();
    this.getDestination();
  },
  methods: {
    totalPriceCal(){
      let total = (Number((this.distance / 1000).toFixed(3)) * this.form.distance_price);// + (form.stop * form.stop_price);
      var driver = total - this.form.insurance + (this.form.commission/100 * total) + (this.form.tax/100 * total);
      driver = driver + this.form.package;
      this.form.total_amount = total;
      this.form.price = (Number((this.distance / 1000).toFixed(3)) * this.form.distance_price);
      this.form.distance = Number((this.distance / 1000).toFixed(3));
    },
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    removeMarker(index) {
      this.markers.splice(index, 1);
    },
    addMarker(evt) {
      let count = this.markers.length;
      this.markers.push({
        position: {
          lat: evt.latlng.lat,
          lng: evt.latlng.lng,
        },
        tooltip: "مقصد شماره " + (count + 1),
        draggable: true,
        visible: true,
      });
    },
    getDerectionInfo() {
      if (this.markers.length > 0) {
        this.distance = this.duration = null;
        this.isLoading = true;
        this.origins = this.destinations = "";
        for (var i = 0; i < this.markers.length; i++) {
          if (i > 1) {
            this.origins += "|";
            this.destinations += "|";
          }
          if (i !== 0) {
            this.origins +=
              i +
              "," +
              Number(this.markers[i - 1].position.lat.toFixed(7)) +
              "," +
              Number(this.markers[i - 1].position.lng.toFixed(7));
            this.destinations +=
              i +
              "," +
              Number(this.markers[i].position.lat.toFixed(7)) +
              "," +
              Number(this.markers[i].position.lng.toFixed(7));
          }
        }
        let promise = this.$http.get(
          "https://map.ir/distancematrix?origins=" +
            this.origins +
            "&destinations=" +
            this.destinations +
            "&sorted=true",
          {
            transformRequest: (data, headers) => {
              delete headers.common["Authorization"];
              headers.common["x-api-key"] =
                "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjBjYTBiNmE1YmZkNTJjYmViMWVhYzYzZmQzODJkNDI1ZmE1YTUwMTkwMDI2MmE3YTJmMzZlYzc1NDhhOWM3MjFjOTA0N2Q3Zjc5NzY5YzViIn0.eyJhdWQiOiIxNDE4MCIsImp0aSI6IjBjYTBiNmE1YmZkNTJjYmViMWVhYzYzZmQzODJkNDI1ZmE1YTUwMTkwMDI2MmE3YTJmMzZlYzc1NDhhOWM3MjFjOTA0N2Q3Zjc5NzY5YzViIiwiaWF0IjoxNjIyNDcyMTQ3LCJuYmYiOjE2MjI0NzIxNDcsImV4cCI6MTYyNDk3Nzc0Nywic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.XQrhmY_i5Poodh-hUKS16nqRVI0GK2HOEOVQYkbtGg9AcqOZUYbyDpO4uf8l9O1r2agnSL0UnUBKF4mW_wzS8FuZvH1uZANTQWjhoki47UPEOpqLNcdrhkDHr8tcoSrYXVEzniPIHBiJsoTp3FZfxmDRe8j4XQMjYrf38jTAh0ZT24223yXi0PT9qfmtuR2EN7i5o6RanBZAgq1hEfYFUREGiwPtJ1qzGhNIwjIkiw5hlkzSL_GTpYzxtT6qndHF4WJ3drADQGarKOgBC47gpkucAAmWxzsJtEqexNPJx8A8qQ0oVtmXcXhQFQUjBq9nojLjQn7e4qeMfSeOi0qP-A";
              return data;
            },
          }
        );

        return promise
          .then((response) => {
            this.direction = response.data;

            this.direction.distance.forEach((element) => {
              if (element.origin_index === element.destination_index) {
                this.distance += Number(element.distance.toFixed(3));
              }
            });
            this.direction.duration.forEach((element) => {
              if (element.origin_index === element.destination_index) {
                this.duration += element.duration;
              }
            });
            this.locations = [];
            for (var j = 1; j < i; j++) {
              this.locations.push({
                origin: response.data.origins[j],
                destination: response.data.destinations[j],
                distance: Number(
                  response.data.distance
                    .find(
                      (item) =>
                        (parseInt(item.origin_index) === j) &
                        (parseInt(item.destination_index) === j)
                    )
                    .distance.toFixed(3)
                ),
                duration: response.data.duration.find(
                  (item) =>
                    (parseInt(item.origin_index) === j) &
                    (parseInt(item.destination_index) === j)
                ).duration,
              });
            }
            this.isLoading = false;
          })
          .catch(() => {
            this.isLoading = false;
          });
      } else {
        alert("مقضد را مشخص کنید.");
      }
    },
    getDrivers() {
      this.isLoading = true;
      let promise = this.$http.get(this.$api("api/v1/client/drivers/list"));
      return promise
        .then((response) => {
          this.drivers = response.data;
          this.isLoading = false;
        })
        .catch(() => {
          this.drivers = [{ id: 0, name: "-----" }];
          this.isLoading = false;
        });
    },
    getCars() {
      this.isLoading = true;
      let promise = this.$http.get(this.$api("api/v1/client/vehicles/list"));
      return promise
        .then((response) => {
          this.cars = response.data;
          this.isLoading = false;
        })
        .catch(() => {
          this.cars = [{ id: 0, name: "-----" }];
          this.isLoading = false;
        });
    },
    getDestination() {
      let promise = this.$http.get(this.$api("api/v1/client/core/destinations/list"));
      return promise
        .then((response) => {
          this.rmto_destinations = response.data;
          return response.data;
        })
        .catch((error) => {
          this.rmto_destinations = [{ id: 0, name: "-----" }];
          return [{ id: 0, name: "-----" }];
        });
    },
    onSubmit(evt) {
      evt.preventDefault();
      this.totalPriceCal();

      let promise = this.$http.post(this.$api(this.api + "/new"), this.form);
      promise
        .then((response) => {
          console.error(response.data);
          // this.$router.push(this.$route.query.redirect || this.baseUrl);
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
    },
    customLabelDriver(evt) {
      return evt.driver_code + " - " + evt.fname + " " + evt.lname;
    },
    customLabelCar(evt) {
      return (
        evt.car_code +
        " - « " +
        evt.plate_series +
        " | " +
        evt.plate_series_1 +
        " " +
        evt.plate_series_2 +
        " " +
        evt.plate_series_3 +
        " »"
      );
    },
  },
};
</script>
