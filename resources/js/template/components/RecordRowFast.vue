<template>
  <b-row
    :class="computedClasses"
    :id="item.id"
    :data-status="item.status"
    
    class="record-item"
  >
    <b-row class="col-12">
      <b-col cols="2" v-on:click="selectRecord()" v-if="item.travel_record.record_info">
        <span>{{item.travel_record.record_info.system_code}}</span>
      </b-col>
      <b-col cols="2" v-on:click="selectRecord()" v-else>
        <span>{{item.travel_record.chival_code}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.dest_city_info.name}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.driver_info_record.fname}} {{item.driver_info_record.lname}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.car_info_record.plate_series_3}}{{item.car_info_record.plate_series_2}}{{item.car_info_record.plate_series_1}} | {{item.car_info_record.plate_series}}</span>
      </b-col>
      <b-col cols="1" v-on:click="selectRecord()">
        <span>{{item.travel_record.move_date}}</span>
      </b-col>
      <b-col cols="1" v-on:click="selectRecord()">
        <span>{{item.travel_record.move_time}}</span>
      </b-col>
      <b-col class="text-left" v-if="$slots.action">
        <slot name="action"></slot>
      </b-col>
      <b-col v-if="item.travel_passengers_info_record" cols="1">
        <b-button class="btn-icon" v-b-toggle="'collapse-'+item.id">
          <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
        </b-button>
      </b-col>
    </b-row>
    <b-row class="col-12 mt-3">
      <b-col cols="2" v-on:click="selectRecord()" v-if="item.travel_record.record_info">
        <span>{{item.travel_record.record_info.system_code}}</span>
      </b-col>
      <b-col cols="2" v-on:click="selectRecord()" v-else>
        <span>{{item.travel_record.chival_code}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.dest_city_info.name}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.driver_info_record.fname}} {{item.driver_info_record.lname}}</span>
      </b-col>
      <b-col class="text-center" v-on:click="selectRecord()">
        <span>{{item.car_info_record.plate_series_3}}{{item.car_info_record.plate_series_2}}{{item.car_info_record.plate_series_1}} | {{item.car_info_record.plate_series}}</span>
      </b-col>
      <b-col cols="1" v-on:click="selectRecord()">
        <span>{{item.travel_record.move_date}}</span>
      </b-col>
      <b-col cols="1" v-on:click="selectRecord()">
        <span>{{item.travel_record.move_time}}</span>
      </b-col>
      <b-col class="text-left" v-if="$slots.action">
        <slot name="action"></slot>
      </b-col>
      <b-col v-if="item.travel_passengers_info_record" cols="1">
        <b-button class="btn-icon" v-b-toggle="'collapse-'+item.id">
          <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
        </b-button>
      </b-col>
    </b-row>
    <b-collapse :id="'collapse-'+item.id">
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
          <b-col cols="12" class="text-right mb-2">شماره صندلی : {{passenger.seat_number}}</b-col>
          <b-col cols="6" class="text-right mb-2">نام مسافر : {{passenger.fname}}</b-col>
          <b-col cols="6" class="text-right mb-2">نام خانوادگی مسافر : {{passenger.lname}}</b-col>
          <b-col cols="6" class="text-right">کد ملی : {{passenger.nation_code}}</b-col>
          <b-col cols="6" class="text-right" v-if="passenger.sex == 1">جنسیت : زن</b-col>
          <b-col cols="6" class="text-right" v-else>جنسیت : مرد</b-col>
        </b-row>
      </b-col>
    </b-row>
    </b-collapse>
  </b-row>
</template>

<script>
// console.error(params)
export default {
  name: "RecordRow",

  props: {
    item: {
      type: Object
    }
  },
  computed: {
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "inner-row";
      return cls;
    }
  },
  methods: {
    selectRecord() {
      this.$emit("clickOnRow", this.item);
    }
  }
};
</script>
