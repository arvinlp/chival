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
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">راننده اصلی</label>
                <div class="col-10">
                  <multiselect
                    v-model="driver"
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
                    @select="onSelectDriver"
                    @change="onSelectDriver"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-2 col-form-label">وسیله نقلیه</label>
                <div class="col-10">
                  <multiselect
                    v-model="car"
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
              <a v-on:click="getDerectionInfo()" class="btn btn-success w-100 my-3">محاسبه</a>
            </b-col>
            <b-col cols="12" v-if="locations">
              <b-row v-for="(item, index) in locations" v-bind:key="index">
                <b-col cols="4">{{ item.origin.province_name }} - {{ item.origin.county_name }} - {{ item.origin.name }}</b-col>
                <b-col cols="4">{{ item.destination.province_name }} - {{ item.destination.county_name }} - {{ item.destination.name }}</b-col>
                <b-col cols="4">{{ Number((item.distance / 1000).toFixed(3)) }} کیلومتر</b-col>
              </b-row>
            </b-col>
            <b-col cols="12" class=" mt-3">{{ Number((distance / 1000).toFixed(3)) }} کیلومتر</b-col>
            <b-col cols="12">{{ Number((duration / 60).toFixed(0)) }} دقیقه</b-col>
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
      form: {},

      baseUrl: { name: "client-exclusives" },
      api: "api/v1/client/travel/exclusives",

      center: L.latLng(30.29570222745681, 57.03753331757921),
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

      drivers: [],
      cars: [],
      driver: null,
      car: null,

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
      isEdit: false,
      isLoading: false,
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
  },
  methods: {
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
    onSelectDriver(evt) {},
    onSelectCar(evt) {},
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
                this.distance +=  Number(element.distance.toFixed(3));
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
                distance: Number(response.data.distance.find(
                  (item) =>
                    (parseInt(item.origin_index) === j) &
                    (parseInt(item.destination_index) === j)
                ).distance.toFixed(3)),
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
    getProvinces() {
      this.isLoading = true;
      let promise = this.$http.get(this.$api("api/v1/client/core/provinces"));
      return promise
        .then((response) => {
          this.provinces = response.data;
          this.isLoading = false;
        })
        .catch(() => {
          this.provinces = [{ id: 0, name: "-----" }];
          this.isLoading = false;
        });
    },
    getCounties(province) {
      if (province) {
        this.isLoading = true;
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
            this.isLoading = false;
          })
          .catch(() => {
            this.counties = [{ id: 0, name: "-----" }];
            this.isLoading = false;
          });
      }
      this.counties = [{ id: 0, name: "-----" }];
      return [{ id: 0, name: "-----" }];
    },
    getCities(county) {
      if (county) {
        this.isLoading = true;
        let promise = this.$http.get(this.$api("api/v1/client/core/cites/" + county));
        return promise
          .then((response) => {
            this.cities = response.data;
            if (this.isEdit)
              this.city = this.cities.find(
                (item) => item.id === parseInt(this.form.city)
              );
            this.isLoading = false;
          })
          .catch(() => {
            this.cities = [{ id: 0, name: "-----" }];
            this.isLoading = false;
          });
      }
      this.cities = [{ id: 0, name: "-----" }];
    },
    onSubmit(evt) {},
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
