<template v-if="item">
  <b-col :cols="cell" class="ticket-cell mb-4" :id="item.id" :data-status="item.status">
    <div :class="computedClasses">
      <b-col v-if="item.status >= 90" cols="12" class="label">
        <span v-if="(item.status == 93) | (item.status == 98)"
          >ظرفیت این وسیله نقلیه تکمیل است.</span
        >
        <span v-if="(item.status == 92) | (item.status == 97)"
          >همکاری دیگر در حال فروش بیلط می باشد.</span
        >
        <span v-if="(item.status == 91) | (item.status == 96)"
          >در انتظار تکمیل ظرفیت</span
        >
        <span v-if="(item.status == 90) | (item.status == 95)">در انتظار مسافر</span>
      </b-col>
      <b-col cols="12" class="label">
        <span>{{ item.driver_info.fname }} {{ item.driver_info.lname }}</span>
      </b-col>
      <b-col cols="12" class="label">
        <div class="plate w-50 mx-auto">
          <div class="plate county">
            <span class="county_code">{{ item.car_info.plate_series }}</span>
          </div>
          <span class="plate part">{{ item.car_info.plate_series_1 }}</span>
          <span class="plate part">{{ item.car_info.plate_series_2 }}</span>
          <span class="plate part">{{ item.car_info.plate_series_3 }}</span>
        </div>
      </b-col>
      <b-col cols="12" class="seats">
        <b-row class="row-eq-height" v-if="computedSeats == 3">
          <b-col cols="4">
            <b-button :class="seatClass(1)" v-on:click="selectSeat(1)">1</b-button>
          </b-col>
          <b-col cols="4">
            <div class="seat null"></div>
          </b-col>
          <b-col cols="4">
            <div class="seat driver"></div>
          </b-col>
          <b-col cols="6" v-for="seat in computedSeats - 1" v-bind:key="seat">
            <b-button :class="seatClass(seat + 1)" v-on:click="selectSeat(seat + 1)" v-if="seat == 1" class="d-block mr-2">
              {{ seat + 1 }}
            </b-button>
            <b-button :class="seatClass(seat + 1)" v-on:click="selectSeat(seat + 1)" v-if="seat == 2" class="d-block ml-2">
              {{ seat + 1 }}
            </b-button>
          </b-col>
        </b-row>
        <b-row class="row-eq-height" v-if="computedSeats >= 4">
          <b-col cols="4">
            <b-button :class="seatClass(1)" v-on:click="selectSeat(1)">1</b-button>
          </b-col>
          <b-col cols="4">
            <div class="seat null"></div>
          </b-col>
          <b-col cols="4">
            <div class="seat driver"></div>
          </b-col>
          <b-col :cols="computedCell" v-for="seat in computedSeats - 1" v-bind:key="seat">
            <b-button :class="seatClass(seat + 1)" v-on:click="selectSeat(seat + 1)">
              {{ seat + 1 }}
            </b-button>
          </b-col>
        </b-row>
      </b-col>
    </div>
  </b-col>
</template>

<script>
// console.error(params)
export default {
  name: "SellingCell",
  data() {
    return {
      selling: false,
      seatSelectedClass:[],
    };
  },
  props: {
    cell: {
      type: Number,
      default: 3,
    },
    form: {
      type: Array,
    },
    item: {
      type: Object,
      default: [],
    },
  },
  computed: {
    computedSeats() {
      return this.item.chairs_number;
    },
    offset(item) {
      if(item == 0) return 4;
      return null;
    },
    computedCell() {
      let number = this.item.chairs_number - 1;
      if (number % 6 == 0) return 2;
      if (number % 4 == 0) return 3;
      if (number % 3 == 0) return 4;
      if (number % 2 == 0) return 6;
      return 12;
    },
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "ticket";
      if (this.item.status >= 95) cls += " not-in-list";
      else cls += " in-list";
      return cls;
    },
  },
  methods: {
    seatClass(seat_number) {
      var cls = "seat empty";
      if (this.form) {
        let passenger = this.form.find(
          (item) => parseInt(item.seat_number) === seat_number
        );
        if (passenger) {
          cls = "";
          if (passenger.sex == 1) cls = "seat taked female";
          else if (passenger.sex == 0) cls = "seat taked male";
          else cls = "seat empty";
          if (passenger.child_number > 0) cls = cls + " child";
          if (passenger.selected > 0) cls = cls + " selected-seat";
        }
      }
      return cls;
    },
    selectSeat(seat_number) {
      var seatInfo = {
        id: this.item.id,
        seat_number: seat_number,
      };
      let passenger = this.item.travel_passengers.find(
        (item) => parseInt(item.seat_number) === seat_number
      );
      if (passenger) seatInfo.passenger = passenger;

      this.$emit("selectSeat", seatInfo);
    },
  },
};
</script>
