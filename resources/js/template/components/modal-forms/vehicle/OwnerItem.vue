<template>
  <b-row :class="computedClasses" :id="item.id" :data-status="item.status">
    <b-col cols="2" class="text-right">{{ item.owners.name }}</b-col>
    <b-col cols="2" class="text-right">{{ item.owners.tel }}</b-col>
    <b-col cols="2" class="text-right">
      <div class="plate">
        <div class="plate county">
          <span class="county_code">{{ item.old_plate_series }}</span>
        </div>
        <span class="plate part">{{ item.old_plate_series_1 }}</span>
        <span class="plate part">{{ item.old_plate_series_2 }}</span>
        <span class="plate part">{{ item.old_plate_series_3 }}</span>
      </div>
    </b-col>
    <b-col cols="2" class="text-center">
      <span>{{ item.old_capacity }}</span>
    </b-col>
    <b-col cols="2" class="text-center">
      <span>{{ item.old_car_card_no }}</span>
    </b-col>
    <b-col cols="1" class="text-center">
      <span>{{ item.old_vin }}</span>
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
  },
  computed: {
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "inner-row pb-3";
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
