<template>
  <b-row :class="computedClasses" :id="item.id" :data-status="item.status">
    <b-col cols="1">
      <span>{{ item.queue }}</span>
    </b-col>
    <b-col cols="2">
      <span>{{ item.driver_info.fname }} {{ item.driver_info.lname }}</span>
    </b-col>
    <b-col cols="1" class="text-left">
      <a :href="'tel:' + item.driver_info.mobile">{{ item.driver_info.mobile }}</a>
    </b-col>
    <b-col cols="2" class="text-right">
      <div class="plate">
        <div class="plate county">
          <span class="county_code">{{ item.car_info.plate_series }}</span>
        </div>
        <span class="plate part">{{ item.car_info.plate_series_1 }}</span>
        <span class="plate part">{{ item.car_info.plate_series_2 }}</span>
        <span class="plate part">{{ item.car_info.plate_series_3 }}</span>
      </div>
    </b-col>
    <b-col cols="3" v-if="item.driver_info.status == 1 && item.car_info.status == 1">
      <p v-if="item.note">{{ item.note }}</p>
    </b-col>
    <b-col
      cols="3"
      class="text-left"
      v-if="$slots.action && item.driver_info.status == 1 && item.car_info.status == 1"
    >
      <slot name="action"></slot>
    </b-col>
    <b-col
      cols="1"
      class="text-center"
      v-else
    >
      <slot name="action-disabled"></slot>
    </b-col>
    <b-col
      cols="5"
      v-if="item.driver_info.status != 1 || item.car_info.status != 1"
    >
      <span v-if="item.driver_info.status != 1">
        دلیل غیرفعال بودن راننده : {{ item.driver_info.driver_note }}
      </span>
      <hr v-if="item.driver_info.status != 1 && item.car_info.status != 1">
      <span v-if="item.car_info.status != 1">
        دلیل غیرفعال بودن وسیله نقلیه : {{ item.car_info.status_note }}
      </span>
    </b-col>
  </b-row>
</template>

<script>
// console.error(params)
export default {
  name: "TurnListRow",

  props: {
    item: {
      type: Object,
    },
    route_number: {
      type: Number,
      default: 3,
      description: "",
    },
  },
  computed: {
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "inner-row";
      if (this.item.pendding) {
        cls += " pendding";
      } else {
        if ((this.item.status >= 50) & (this.item.status < 70)) cls += " rejected";
        else if ((this.item.status >= 70) & (this.item.status < 90)) cls += " in-list";
        else if ((this.item.status >= 90) & (this.item.status < 95)) cls += " selling";
        else cls += " default";
      }
      return cls;
    },
  },
};
</script>
