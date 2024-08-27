<template v-if="item">
  <b-col cols="12" class="ticket-row mb-4 px-0" :id="item.id" :data-status="item.status">
    <div :class="computedClasses">
      <b-row align-v="center">
        <div v-if="seatInSelling()" class="overlay selling d-block"></div>
        <b-col cols="3" class="label">
          <span>{{ item.driver_info.fname }} {{ item.driver_info.lname }}</span>
          <hr />

          <b-button class="btn-success w-100" :to="url"> فروش بیلط </b-button>
        </b-col>
        <b-col cols="2" class="label">
          <div class="plate">
            <div class="plate county">
              <span class="county_code">{{ item.car_info.plate_series }}</span>
            </div>
            <span class="plate part">{{ item.car_info.plate_series_1 }}</span>
            <span class="plate part">{{ item.car_info.plate_series_2 }}</span>
            <span class="plate part">{{ item.car_info.plate_series_3 }}</span>
          </div>
          <hr />
          <a :href="`tel:` + item.driver_info.mobile">{{ item.driver_info.mobile }}</a>
        </b-col>
        <b-col v-if="item.status >= 90" cols="3" class="label">
          <span>
            مسافران
            <b class="px-2"
              ><u>{{ item.travel_passengers_count }}</u></b
            >
            <i class="fas fa-users"></i>
          </span>
          <hr />
          <span v-if="(item.status == 93) | (item.status == 98)">
            ظرفیت این وسیله نقلیه تکمیل است.
          </span>
          <span v-if="(item.status == 92) | (item.status == 97)"
            >همکاری دیگر در حال فروش بیلط می باشد.
          </span>
          <span v-if="(item.status == 91) | (item.status == 96)">
            در انتظار تکمیل ظرفیت
          </span>
          <span v-if="(item.status == 90) | (item.status == 95)">در انتظار مسافر</span>
        </b-col>
        <b-col cols="2" class="label" v-if="item.selling_jalali">
          <span class="font-size-80">ساعت ورود به فروش بلیط</span>
          <hr />
          <span>{{ item.selling_jalali }}</span>
        </b-col>
        <b-col cols="2">
          <b-row class="btn-actions">
            <b-col cols="12" class="label">
              <b-button class="btn-success w-100" v-on:click="selectRecord()">
                صدور صورت وضعیت
              </b-button>
            </b-col>
            <b-col cols="12" class="label">
              <b-button class="btn-warning w-100" v-on:click="selectRoute()">
                تغییر مسیر
              </b-button>
            </b-col>
            <b-col cols="12" class="label">
              <b-button class="btn-danger w-100" v-on:click="selectCancel()">
                لغو سفر
              </b-button>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </div>
  </b-col>
</template>

<script>
export default {
  name: "SellingCell",
  props: {
    api: {
      type: String,
      default: null,
    },
    cell: {
      type: Number,
      default: 3,
    },
    url: {
      type: Object,
      default: null,
      description: "CardProgress Link",
    },
    item: {
      type: Object,
      default: [],
    },
  },
  data() {
    return {
      selling: false,

      modelHandler: {
        modalApi: null,
        modalType: null,
        modalText: {
          show: false,
          title: "",
          btnOK: "",
          btnCancel: "",
        },
      },
      recodModalHandlerData: {
        show: false,
        id: null,
      },
    };
  },
  computed: {
    computedMainClasses() {
      return [{ [`bg-${this.type}`]: this.type }];
    },
    computedClasses() {
      var cls = "ticket-item";
      if (this.item.status >= 95) cls += " not-in-list";
      else cls += " in-list";
      return cls;
    },
  },
  mounted() {
    // if(this.modalID){
    //   this.modelHandler.modalID = this.modalID;
    // }
  },
  methods: {
    seatInSelling() {
      if (this.item.status == 92) return true;
      else if (this.item.status == 97) return true;
      else if (this.item.status != 92) return false;
      else if (this.item.status != 97) return false;
      else return false;
    },
    selectRecord() {
      var promise = this.$http.post(this.$api(this.api + "/" + this.item.travel_id), {
        status: 3,
      });
      promise
        .then(() => {
          this.$notify({
            group: "error",
            title: "درخواست صورت وضعیت",
            text: "درخواست صورت وضعیت برای وسیله نقلیه ثبت شد.",
            duration: 10000,
          });
        })
        .catch((error) => {
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
          console.error("Error : " + error);
        });
    },
    selectRoute() {
      this.$emit("btnRoute", this.item.id);
    },
    selectCancel() {
      this.$emit("btnCancel", this.item.id);
    },
  },
};
</script>
