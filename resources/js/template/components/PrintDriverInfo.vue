<template v-if="item.length > 0">
  <div>
    <div id="driver-info">
      <div class="driver-info">
        <div class="paper">
          <div class="p-row">
            <div class=""><h3 class="title">اطلاعات فردی</h3></div>
            <div class="">نام : {{ item.fname }}</div>
            <div class="">نام خانوادگی : {{ item.lname }}</div>
            <div class="">نام پدر : {{ item.father }}</div>
            <div class="">کدملی : {{ item.nation_code }}</div>
            <div class="">تاریخ تولد : {{ item.birthday }}</div>
            <div class="">جنسیت : {{ item.sex == 0 ? "مرد" : "زن" }}</div>
          </div>
          <div class="p-row img">
            <img v-if="item.picture" :src="item.picture" />
            <span v-else class="no-img"></span>
          </div>
          <div class="border-bottom"></div>
          <div class="p-row">
            <div class=""><h3 class="title">اطلاعات تماس</h3></div>
            <div class="">موبایل : {{ item.mobile }}</div>
            <div class="">تلفن : {{ item.tel }}</div>
            <div class="">استان : {{ item.province_name }}</div>
            <div class="">شهر : {{ item.county_name }}</div>
            <div class="">شهرستان : {{ item.city_name }}</div>
            <div class="">آدرس : {{ item.address }}</div>
          </div>
          <div class="p-row">
            <div class=""><h3 class="title">اطلاعات بانکی</h3></div>
            <div class="">بانک : {{ item.bank_name }}</div>
            <div class="">شماره حساب : {{ item.bank_number }}</div>
            <div class="">کارت : {{ item.bank_card }}</div>
            <div class="">شبا : {{ item.bank_iban }}</div>
          </div>
          <div class="border-bottom"></div>
          <div class="p-row">
            <div class=""><h3 class="title">اطلاعات حرفه ای</h3></div>
            <div class="">کارت گواهینامه : {{ item.driver_license }}</div>
            <div class="">
              انقضا کارت هوشمند : {{ item.driver_license_expire_date_persian }}
            </div>
            <div class="">کارت صحت سلامت : {{ item.driver_health }}</div>
            <div class="">انقضا صحت سلامت : {{ item.health_expire_date_persian }}</div>
            <div class="" v-if="item.book_time">
              شماره دفترچه ثبت ساعت : {{ item.book_time.code }}
            </div>
            <div class="" v-if="item.book_time">
              انقضا دفترچه ثبت ساعت : {{ item.book_time.expire_date_jalali }}
            </div>
          </div>
          <div class="p-row" v-if="item.contract">
            <div class=""><h3 class="title">اطلاعات قرارداد</h3></div>
            <div class="">شماره قرارداد : {{ item.contract.number }}</div>
            <div class="">پایان قرارداد : {{ item.contract.expire_date_jalali }}</div>
          </div>
          <div class="border-bottom"></div>
          <div class="p-row sign">
            <div class="sign-right">امضا راننده</div>
            <div class="sign-left">امضا مسؤل</div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div>
        <div><b-button v-on:click="printPage()">پرینت اطلاعات</b-button></div>
      </div>
    </div>
  </div>
</template>

<script>
// console.error(params)
export default {
  name: "PrintDriverInfo",
  data() {
    return {
      item: [],
    };
  },
  props: {
    itemID: {
      type: Number,
      default: 0,
    },
  },
  computed: {},
  mounted() {
    this.getData();
  },
  methods: {
    getData() {
      let promise = this.$http.get(
        this.$api("api/v1/client/check/driver/print/" + this.itemID)
      );

      return promise
        .then((response) => {
          var data = response.data;
          this.item = data;
        })
        .catch(() => {
          this.item = [];
        });
    },
    printPage() {
      this.$htmlToPaper("driver-info");
    },
  },
};
</script>
