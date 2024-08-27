<template>
  <b-row
    :class="computedClasses"
    :id="item.id"
    :data-status="item.status"
    class="record-item"
  >
    <b-row class="col-12" align-v="center">
      <b-col cols="2">
        <span v-if="item.record_info">
          {{ item.record_info.system_code }}
          <hr />
        </span>
        <span>{{ item.travel_record.chival_code }}</span>
      </b-col>
      <b-col cols="1" class="text-center">
        <span>{{ item.dest_city_info.name }}</span>
      </b-col>
      <b-col cols="2" class="text-center">
        <span>
          {{ item.driver_info_record.fname }} {{ item.driver_info_record.lname }}
        </span>
      </b-col>
      <b-col cols="2" class="text-center">
        <div class="plate w-100 mx-auto">
          <div class="plate county">
            <span class="county_code">{{ item.car_info_record.plate_series }}</span>
          </div>
          <span class="plate part">{{ item.car_info_record.plate_series_1 }}</span>
          <span class="plate part">{{ item.car_info_record.plate_series_2 }}</span>
          <span class="plate part">{{ item.car_info_record.plate_series_3 }}</span>
        </div>
      </b-col>
      <b-col cols="1">
        <span>{{ item.travel_record.move_date }}</span>
      </b-col>
      <b-col cols="1">
        <span>{{ item.travel_record.move_time }}</span>
      </b-col>
      <b-col cols="3" class="text-left btn-box">
        <b-button variant="success" v-on:click="showModal()">
          <span v-if="item.record_info != null">نمایش صورت وضعیت</span>
          <span v-else>درخواست صدور صورت وضعیت</span>
        </b-button>
        <b-button variant="warning" v-b-toggle="'collapse-' + item.id">
          نمایش اطلاعات مسافر
        </b-button>
      </b-col>
    </b-row>
    <b-collapse class="col-12" :id="'collapse-' + item.id">
      <b-col cols="12">
        <div class="split"></div>
      </b-col>
      <b-row class="col-12" v-if="item.travel_passengers_info_record">
        <b-col
          v-for="passenger in item.travel_passengers_info_record"
          v-bind:key="passenger.seat_number"
          class="passenger"
        >
          <b-row class="mt-3 mb-3">
            <b-col cols="12" class="text-right mb-2">
              شماره صندلی : {{ passenger.seat_number }}
            </b-col>
            <b-col cols="6" class="text-right mb-2">
              نام مسافر : {{ passenger.fname }}
            </b-col>
            <b-col cols="6" class="text-right mb-2">
              نام خانوادگی مسافر : {{ passenger.lname }}
            </b-col>
            <b-col cols="6" class="text-right">
              کد ملی : {{ passenger.nation_code }}
            </b-col>
            <b-col cols="6" class="text-right" v-if="passenger.sex == 1">
              جنسیت : زن
            </b-col>
            <b-col cols="6" class="text-right" v-else>جنسیت : مرد</b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-collapse>
    <Modalhandler
      :show="recodModalHandlerData.show"
      :data="recodModalHandlerData.data"
    />
  </b-row>
</template>

<script>
import Modalhandler from "./modal-forms/record/Modalhandler";
export default {
  name: "RecordRow",

  props: {
    item: {
      type: Object,
    },
    recordModal: {
      type: Object,
    },
  },
  data() {
    return {
      recodModalHandlerData: {
        show: false,
        data: null,
        title: "عنوان آیتم",
        content: null,
        btnPrint: null,
        btnOK: "بلی",
        btnClose: "بستن",
        btnCancel: "لغو/ابطال",
        btnTry: null,
        loading: false,
        endPoint: null,
        item: null,
        rows: null,
        type: 0,
        btnShowCancel: false,
        form: {},
      },
    };
  },
  components: {
    Modalhandler,
  },
  computed: {
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "inner-row";
      return cls;
    },
  },
  methods: {
    showModal() {
      this.recodModalHandlerData.data = this.item;
      this.recodModalHandlerData.show = !this.recodModalHandlerData.show;
    },
  },
};
</script>
