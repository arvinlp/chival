<template v-if="ItemHandler">
  <div id="print" v-if="ItemHandler.data">
    <div class="record">
      <div class="sample"></div>
      <div class="part-1">
        <div class="row-1">
          <div class="d-col-3">
            <div v-if="ItemHandler.data.company_record">
              {{ ItemHandler.data.company_record.province_name }}
            </div>
            <div v-if="ItemHandler.data.travel_record" class="d-cols">
              <div class="d-col-1">
                {{ ItemHandler.data.travel_record.starting_city.name }}
              </div>
              <div class="d-col-2">
                {{ ItemHandler.data.travel_record.move_date }}
              </div>
            </div>
            <div v-if="ItemHandler.data.travel_record" class="d-cols">
              <div class="d-col-1">
                {{ ItemHandler.data.travel_record.destanation_city.name }}
              </div>
              <div class="d-col-2">
                {{ ItemHandler.data.travel_record.move_time }}
              </div>
            </div>
          </div>
          <div class="d-col-2"></div>
          <div class="d-col-1">
            <barcode
              v-if="ItemHandler.data.record_info"
              v-bind:value="ItemHandler.data.record_info.system_code"
              class="w-100"
              format="CODE39"
            />
          </div>
        </div>
        <div v-if="ItemHandler.data.driver_info_record" class="row-2">
          <div class="d-col-6">-</div>
          <div class="d-col-5">
            {{ ItemHandler.data.driver_info_record.driver_card_no }}
          </div>
          <div class="d-col-4">
            {{ ItemHandler.data.driver_info_record.nation_code }}
          </div>
          <div class="d-col-3">
            {{ ItemHandler.data.driver_info_record.driver_license }}
          </div>
          <div class="d-col-2">
            {{ ItemHandler.data.driver_info_record.province_name }}
          </div>
          <div class="d-col-1">
            {{ ItemHandler.data.driver_info_record.fname }}
            {{ ItemHandler.data.driver_info_record.lname }}
          </div>
        </div>
        <div v-if="ItemHandler.data.car_info_record" class="row-3">
          <div class="d-col-7">
            {{ ItemHandler.data.car_info_record.car_card_no }}
          </div>
          <div class="d-col-6">
            {{ ItemHandler.data.car_info_record.code }} -
            {{ ItemHandler.data.car_info_record.expire_date }}
          </div>
          <div class="d-col-5">{{ ItemHandler.data.chairs_number }}</div>
          <div class="d-col-4"><i class="fas fa-check-circle mr-5"></i></div>
          <div class="d-col-3">ایران</div>
          <div class="d-col-2">
            {{ ItemHandler.data.car_info_record.plate_series }}
          </div>
          <div class="d-col-1">
            {{ ItemHandler.data.car_info_record.plate_series_1 }}
            {{ ItemHandler.data.car_info_record.plate_series_2 }}
            {{ ItemHandler.data.car_info_record.plate_series_3 }}
          </div>
        </div>
        <div v-if="ItemHandler.data.car_info_record" class="row-4">
          <div class="d-col-10">
            {{ ItemHandler.data.travel_record.insurance_third }}
          </div>
          <div class="d-col-9">-</div>
          <div class="d-col-8">{{ ItemHandler.data.travel_record.tax }}</div>
          <div class="d-col-7">-</div>
          <div class="d-col-6">{{ ItemHandler.data.travel_record.coast }}</div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ ItemHandler.data.travel_record.package }}
          </div>
          <div class="d-col-3">-</div>
          <div class="d-col-2">
            {{ ItemHandler.data.travel_record.passenger_number }}
          </div>
          <div class="d-col-1">-</div>
        </div>
        <div v-if="ItemHandler.data.car_info_record" class="row-5">
          <div class="d-col-7">-</div>
          <div class="d-col-6">
            {{ ItemHandler.data.company_record.company_name }}
          </div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ ItemHandler.data.travel_record.commission }}
          </div>
          <div class="d-col-3">-</div>
          <div class="d-col-2">{{ ItemHandler.data.travel_record.price }}</div>
          <div class="d-col-1">-</div>
        </div>
        <div v-if="ItemHandler.data.company_record" class="row-6">
          <div class="d-col-1">{{ calendar }}</div>
          <div class="d-col-2">-</div>
          <div class="d-col-3">{{ ItemHandler.data.company_record.tell }}</div>
          <div class="d-col-4">-</div>
          <div class="d-col-5">
            {{ ItemHandler.data.company_record.province_name }}
          </div>
          <div class="d-col-6">
            {{ ItemHandler.data.company_record.city_name }}
          </div>
          <div class="d-col-7">
            {{ ItemHandler.data.company_record.company_code }}
          </div>
        </div>
      </div>
      <div class="part-2">
        <div class="row-1">
          <div class="d-col-3">
            <div v-if="ItemHandler.data.company_record">
              {{ ItemHandler.data.company_record.province_name }}
            </div>
            <div v-if="ItemHandler.data.travel_record">
              {{ ItemHandler.data.travel_record.move_date }}
            </div>
          </div>
          <div class="d-col-2"></div>
          <div class="d-col-1">
            <barcode
              v-if="ItemHandler.data.record_info"
              v-bind:value="ItemHandler.data.record_info.system_code"
              class="w-100"
              format="CODE39"
            />
          </div>
        </div>
        <div v-if="ItemHandler.data.driver_info_record" class="row-2">
          <div class="d-col-6"></div>
          <div class="d-col-5">
            {{ ItemHandler.data.driver_info_record.driver_card_no }}
          </div>
          <div class="d-col-4">
            {{ ItemHandler.data.driver_info_record.nation_code }}
          </div>
          <div class="d-col-3">
            {{ ItemHandler.data.driver_info_record.driver_license }}
          </div>
          <div class="d-col-2">
            {{ ItemHandler.data.driver_info_record.province_name }}
          </div>
          <div class="d-col-1">
            {{ ItemHandler.data.driver_info_record.fname }}
            {{ ItemHandler.data.driver_info_record.lname }}
          </div>
        </div>
        <div v-if="ItemHandler.data.car_info_record" class="row-3">
          <div class="d-col-7">
            {{ ItemHandler.data.car_info_record.car_card_no }}
          </div>
          <div class="d-col-6">
            {{ ItemHandler.data.car_info_record.code }} -
            {{ ItemHandler.data.car_info_record.expire_date }}
          </div>
          <div class="d-col-5">{{ ItemHandler.data.chairs_number }}</div>
          <div class="d-col-4"><i class="fas fa-check-circle mr-5"></i></div>
          <div class="d-col-3">ایران</div>
          <div class="d-col-2">
            {{ ItemHandler.data.car_info_record.plate_series }}
          </div>
          <div class="d-col-1">
            {{ ItemHandler.data.car_info_record.plate_series_1 }}
            {{ ItemHandler.data.car_info_record.plate_series_2 }}
            {{ ItemHandler.data.car_info_record.plate_series_3 }}
          </div>
        </div>
        <div v-if="ItemHandler.data.travel_record" class="row-4">
          <div class="d-col-8">--------------------</div>
          <div class="d-col-7">-</div>
          <div class="d-col-6">-</div>
          <div class="d-col-5">-</div>
          <div class="d-col-4">
            {{ ItemHandler.data.travel_record.destanation_city.name }}
          </div>
          <div class="d-col-3">
            {{ ItemHandler.data.travel_record.move_time }}
          </div>
          <div class="d-col-2">
            {{ ItemHandler.data.travel_record.starting_city.name }}
          </div>
          <div class="d-col-1"></div>
        </div>
        <div v-if="ItemHandler.data.company_record" class="row-5">
          <div class="d-col-7"></div>
          <div class="d-col-2">{{ ItemHandler.data.company_record.tell }}</div>
          <div class="d-col-3">
            {{ ItemHandler.data.company_record.province_name }}
          </div>
          <div class="d-col-4">
            {{ ItemHandler.data.company_record.city_name }}
          </div>
          <div class="d-col-5">
            {{ ItemHandler.data.company_record.company_code }}
          </div>
          <div class="d-col-6">
            {{ ItemHandler.data.company_record.company_name }}
          </div>
          <div class="d-col-1"></div>
          <div class="d-col-1"></div>
        </div>
      </div>
      <div class="part-3" v-if="ItemHandler.data.travel_passengers_info_record">
        <div
          class="row-1"
          v-for="(item, index) in ItemHandler.data
            .travel_passengers_info_record"
          v-bind:key="index"
        >
          <div>
            <span v-if="item.fname">{{ item.fname }} </span
            ><span v-if="item.lname">{{ item.lname }}</span>
          </div>
        </div>
      </div>
      <div class="part-4">
        <div v-if="ItemHandler.data.travel_record" class="row-1">
          <div class="d-col-7"></div>
          <div class="d-col-6">
            {{ ItemHandler.data.travel_record.package }}
          </div>
          <div class="d-col-5"></div>
          <div class="d-col-4">{{ ItemHandler.data.travel_record.coast }}</div>
          <div class="d-col-3"></div>
          <div class="d-col-2">
            {{ ItemHandler.data.travel_record.passenger_number }}
          </div>
          <div class="d-col-1"></div>
        </div>
        <div v-if="ItemHandler.data.travel_record" class="row-2">
          <div class="d-col-11"></div>
          <div class="d-col-10">
            {{ ItemHandler.data.travel_record.package }}
          </div>
          <div class="d-col-9"></div>
          <div class="d-col-8">
            {{ ItemHandler.data.travel_record.commission }}
          </div>
          <div class="d-col-7"></div>
          <div class="d-col-6">{{ ItemHandler.data.travel_record.tax }}</div>
          <div class="d-col-5"></div>
          <div class="d-col-4">
            {{ ItemHandler.data.travel_record.insurance_third }}
          </div>
          <div class="d-col-3"></div>
          <div class="d-col-2">{{ ItemHandler.data.travel_record.price }}</div>
          <div class="d-col-1"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// console.error(params)
export default {
  data() {
    return {
    };
  },
  props: {
    ItemHandler: {
      type: Object,
      default: [],
    },
  },
  computed: {
  },
  methods: {
  },
};
</script>
