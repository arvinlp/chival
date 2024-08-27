<template>
  <div id="print" class="record-print" v-if="data">
    <div class="record">
      <div class="sample"></div>
      <div class="part-1">
        <div class="row-1">
          <div class="d-col-3">
            <div v-if="data.company_record">
              {{ data.company_record.province_name }}
            </div>
            <div v-if="data.travel_record" class="d-cols">
              <div class="d-col-1">
                {{ data.travel_record.starting_city.name }}
              </div>
              <div class="d-col-2">
                {{ data.travel_record.move_date }}
              </div>
            </div>
            <div v-if="data.travel_record" class="d-cols">
              <div class="d-col-1">
                {{ data.travel_record.destanation_city.name }}
              </div>
              <div class="d-col-2">
                {{ data.travel_record.move_time }}
              </div>
            </div>
          </div>
          <div class="d-col-2"></div>
          <div class="d-col-1">
            <div v-if="data.record_info">
              <barcode
                v-if="data.record_info.system_code >= 10000000000000"
                v-bind:value="data.record_info.system_code"
                class="w-100"
                format="CODE39"
              />
            </div>
          </div>
        </div>
        <div v-if="data.driver_info_record" class="row-2">
          <div class="d-col-6">-</div>
          <div class="d-col-5">
            {{ data.driver_info_record.driver_card_no }}
          </div>
          <div class="d-col-4">
            {{ data.driver_info_record.nation_code }}
          </div>
          <div class="d-col-3">
            {{ data.driver_info_record.driver_license }}
          </div>
          <div class="d-col-2">
            {{ data.driver_info_record.province_name }}
          </div>
          <div class="d-col-1">
            {{ data.driver_info_record.fname }}
            {{ data.driver_info_record.lname }}
          </div>
        </div>
        <div v-if="data.car_info_record" class="row-3">
          <div class="d-col-7">
            {{ data.car_info_record.car_card_no }}
          </div>
          <div class="d-col-6">
            {{ data.car_info_record.code }} -
            {{ data.car_info_record.expire_date }}
          </div>
          <div class="d-col-5">{{ data.chairs_number }}</div>
          <div class="d-col-4">
            <i class="fas fa-check-circle mr-5"></i>
          </div>
          <div class="d-col-3">ایران</div>
          <div class="d-col-2">
            {{ data.car_info_record.plate_series }}
          </div>
          <div class="d-col-1">
            {{ data.car_info_record.plate_series_1 }}
            {{ data.car_info_record.plate_series_2 }}
            {{ data.car_info_record.plate_series_3 }}
          </div>
        </div>
        <div v-if="data.car_info_record" class="row-4">
          <div class="d-col-10">
            {{ data.travel_record.insurance_third }}
          </div>
          <div class="d-col-9">-</div>
          <div class="d-col-8">
            {{ data.travel_record.tax }}
          </div>
          <div class="d-col-7">-</div>
          <div class="d-col-6">
            {{ data.travel_record.coast }}
          </div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ data.travel_record.package }}
          </div>
          <div class="d-col-3">-</div>
          <div class="d-col-2">
            {{ data.travel_record.passenger_number }}
          </div>
          <div class="d-col-1">-</div>
        </div>
        <div v-if="data.car_info_record" class="row-5">
          <div class="d-col-7">-</div>
          <div class="d-col-6">
            {{ data.company_record.company_name }}
          </div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ data.travel_record.commission }}
          </div>
          <div class="d-col-3">-</div>
          <div class="d-col-2">
            {{ data.travel_record.price }}
          </div>
          <div class="d-col-1">-</div>
        </div>
        <div v-if="data.company_record" class="row-6">
          <div class="d-col-1">{{ calendar }}</div>
          <div class="d-col-2">-</div>
          <div class="d-col-3">
            {{ data.company_record.tell }}
          </div>
          <div class="d-col-4">-</div>
          <div class="d-col-5">
            {{ data.company_record.province_name }}
          </div>
          <div class="d-col-6">
            {{ data.company_record.city_name }}
          </div>
          <div class="d-col-7">
            {{ data.company_record.company_code }}
          </div>
        </div>
      </div>
      <div class="part-2">
        <div class="row-1">
          <div class="d-col-3">
            <div v-if="data.company_record">
              {{ data.company_record.province_name }}
            </div>
            <div v-if="data.travel_record">
              {{ data.travel_record.move_date }}
            </div>
          </div>
          <div class="d-col-2"></div>
          <div class="d-col-1">
            <div v-if="data.record_info">
              <barcode
                v-if="data.record_info.system_code >= 10000000000000"
                v-bind:value="data.record_info.system_code"
                class="w-100"
                format="CODE39"
              />
            </div>
          </div>
        </div>
        <div v-if="data.driver_info_record" class="row-2">
          <div class="d-col-6"></div>
          <div class="d-col-5">
            {{ data.driver_info_record.driver_card_no }}
          </div>
          <div class="d-col-4">
            {{ data.driver_info_record.nation_code }}
          </div>
          <div class="d-col-3">
            {{ data.driver_info_record.driver_license }}
          </div>
          <div class="d-col-2">
            {{ data.driver_info_record.province_name }}
          </div>
          <div class="d-col-1">
            {{ data.driver_info_record.fname }}
            {{ data.driver_info_record.lname }}
          </div>
        </div>
        <div v-if="data.car_info_record" class="row-3">
          <div class="d-col-7">
            {{ data.car_info_record.car_card_no }}
          </div>
          <div class="d-col-6">
            {{ data.car_info_record.code }} -
            {{ data.car_info_record.expire_date }}
          </div>
          <div class="d-col-5">{{ data.chairs_number }}</div>
          <div class="d-col-4">
            <i class="fas fa-check-circle mr-5"></i>
          </div>
          <div class="d-col-3">ایران</div>
          <div class="d-col-2">
            {{ data.car_info_record.plate_series }}
          </div>
          <div class="d-col-1">
            {{ data.car_info_record.plate_series_1 }}
            {{ data.car_info_record.plate_series_2 }}
            {{ data.car_info_record.plate_series_3 }}
          </div>
        </div>
        <div v-if="data.travel_record" class="row-4">
          <div class="d-col-8">--------------------</div>
          <div class="d-col-7">-</div>
          <div class="d-col-6">-</div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ data.travel_record.destanation_city.name }}
          </div>
          <div class="d-col-3">
            {{ data.travel_record.move_time }}
          </div>
          <div class="d-col-2">
            {{ data.travel_record.starting_city.name }}
          </div>
          <div class="d-col-1"></div>
        </div>
        <div v-if="data.company_record" class="row-5">
          <div class="d-col-7"></div>
          <div class="d-col-2">
            {{ data.company_record.tell }}
          </div>
          <div class="d-col-3">
            {{ data.company_record.province_name }}
          </div>
          <div class="d-col-4">
            {{ data.company_record.city_name }}
          </div>
          <div class="d-col-5">
            {{ data.company_record.company_code }}
          </div>
          <div class="d-col-6">
            {{ data.company_record.company_name }}
          </div>
          <div class="d-col-1"></div>
          <div class="d-col-1"></div>
        </div>
      </div>
      <div class="part-3" v-if="data.travel_passengers_info_record">
        <div
          class="row-1"
          v-for="(item, index) in data.travel_passengers_info_record"
          v-bind:key="index"
        >
          <div>
            <span v-if="item.fname">{{ item.fname }} </span
            ><span v-if="item.lname">{{ item.lname }}</span>
          </div>
        </div>
      </div>
      <div class="part-4">
        <div v-if="data.travel_record" class="row-1">
          <div class="d-col-7"></div>
          <div class="d-col-6">
            {{ data.travel_record.package }}
          </div>
          <div class="d-col-5"></div>
          <div class="d-col-4">
            {{ data.travel_record.coast }}
          </div>
          <div class="d-col-3"></div>
          <div class="d-col-2">
            {{ data.travel_record.passenger_number }}
          </div>
          <div class="d-col-1"></div>
        </div>
        <div v-if="data.travel_record" class="row-2">
          <div class="d-col-11"></div>
          <div class="d-col-10">
            {{ data.travel_record.package }}
          </div>
          <div class="d-col-9"></div>
          <div class="d-col-8">
            {{ data.travel_record.commission }}
          </div>
          <div class="d-col-7"></div>
          <div class="d-col-6">
            {{ data.travel_record.tax }}
          </div>
          <div class="d-col-5"></div>
          <div class="d-col-4">
            {{ data.travel_record.insurance_third }}
          </div>
          <div class="d-col-3"></div>
          <div class="d-col-2">
            {{ data.travel_record.price }}
          </div>
          <div class="d-col-1"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
var moment = require("moment-jalaali");
export default {
  props: {
    data: {
      description: "Data we need to print.",
    },
  },
  computed: {
    calendar: function () {
      return moment().format("jYYYY/jM/jD");
    },
  },
};
</script>
