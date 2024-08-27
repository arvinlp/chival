<template>
  <section class="page">
    <b-alert
      :show="isAlert"
      fade
      :variant="variant"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div>{{ isAlertMessage }}</div>
    </b-alert>
    <div class="row">
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-vehicles' }"
        type="primary"
        :value="(1000 - items.company_car) / 100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">ناوگان</h5>
          <span>{{ items.company_car }} وسیله نقلیه از ۱۰۰۰</span>
          <h5 class="numbers">{{ 1000 - items.company_car }} عدد</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-drivers' }"
        type="primary"
        :value="(500 - items.company_driver) / 100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">رانندگان</h5>
          <span>{{ items.company_driver }} راننده از ۵۰۰</span>
          <h5 class="numbers">{{ 500 - items.company_driver }} عدد</h5>
        </template>
      </CardProgress>
    </div>
    <div class="row">
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-records' }"
        type="primary"
        :value="travelLeftPercent"
        v-if="travelLeftValue"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">صورت وضعیت عادی</h5>
          <span>از اعتبار {{ travelValue }} صورت وضعیت</span>
          <h5 class="numbers">{{ travelLeftValue }} عدد</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-partnear-vehicles' }"
        :value="carPercent"
        :striped="false"
        :animated="true"
        v-if="carValue"
      >
        <template slot="header">
          <h5 class="mb-3">وسایل نقلیه بدون کد</h5>
          <span>از {{ items.partner_car }} وسیله نقلیه شرکت‌های همکار طرف قرارداد</span>
          <h5 class="numbers">{{ carValue }} وسیله نقلیه</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-drivers' }"
        type="primary"
        :value="driverPercent"
        v-if="driverValue"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">رانندگان بدون کد</h5>
          <span>از {{ items.partner_driver }} راننده شرکت‌های همکار طرف قرارداد</span>
          <h5 class="numbers">{{ driverValue }} راننده</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-credits' }"
        type="primary"
        :value="travelChivalLeftPercent"
        v-if="travelChivalLeftValue"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">اعتبار فروش بیلط</h5>
          <span>از اعتبار {{ travelChivalValue }} اعتبار فروش بیلط شیوال</span>
          <h5 class="numbers">{{ travelChivalLeftValue }} سفر</h5>
        </template>
      </CardProgress>
      <!-- -->
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-credits' }"
        type="success"
        :value="storageChivalLeftPercent"
        :striped="false"
        :animated="true"
        v-if="storageChivalLeftValue"
      >
        <template slot="header">
          <h5 class="mb-3">اعتبار انبار</h5>
          <span>غیر فعال می باشد.</span>
          <h5 class="numbers">{{ storageChivalLeftValue }} عدد</h5>
        </template>
      </CardProgress>
      <!-- -->
    </div>
  </section>
</template>

<script>
import Body from "../../components/client/Body";
import CardProgress from "../../components/CardProgress";

export default {
  data() {
    return {
      items: [],
      carValue: 0,
      carPercent: 100,
      driverValue: 0,
      driverPercent: 100,
      travelChivalValue: 0,
      travelChivalLeftValue: 0,
      travelChivalLeftPercent: 100,
      storageChivalValue: 0,
      storageChivalLeftValue: 0,
      storageChivalLeftPercent: 100,

      travelValue: 0,
      travelLeftValue: 0,
      travelLeftPercent: 100,

      dismissSecs: 5,
      isEdited: 0,
      isAlert: 0,
      isAlertMessage: "",
      variant: "danger",
    };
  },

  components: {
    Body,
    CardProgress,
  },

  computed: {
    isUserData: function () {
      return this.$store.getters.user;
    },
  },

  beforeCreate() {
    let promise = this.$http.get(this.$api("api/v1/client"));

    return promise
      .then((response) => {
        this.items = response.data;
        if (response.data.car) {
          this.carValue = response.data.car;
          this.carPercent = (this.carValue * 100) / response.data.partner_car;
        }
        if (response.data.travel_credit) {
          this.travelChivalValue = parseInt(response.data.travel_credit.total_credit);
          this.travelChivalLeftValue = parseInt(response.data.travel_credit.credit);
          this.travelChivalLeftPercent =
            (this.travelChivalLeftValue * 100) / this.travelChivalValue;
        }
        if (response.data.storage_credit) {
          this.storageChivalValue = parseInt(response.data.storage_credit.total_credit);
          this.storageChivalLeftValue = parseInt(response.data.storage_credit.credit);
          this.storageChivalLeftPercent =
            (this.storageChivalLeftValue * 100) / this.storageChivalValue;
        }
        if (response.data.driver) {
          this.driverValue = response.data.driver;
          this.driverPercent = (this.driverValue * 100) / response.data.partner_driver;
        }
        if (response.data.record_normal) {
          this.travelValue = parseInt(response.data.record_normal.pages);
          this.travelLeftValue =
            parseInt(response.data.record_normal.to) -
            parseInt(response.data.record_normal.of);
          this.travelLeftPercent = (this.travelLeftValue * 100) / this.travelValue;
        }
      })
      .catch((error) => {
        const items = [];
      })
      .finally(() => (this.loading = false));
  },
  mounted() {},
  methods: {
    myProvider() {
      let promise = this.$http.get(this.$api("api/v1/client/dashboard"));

      return promise
        .then((response) => {
          this.items = response.data;
          console.error(response.data);
          return this.items;
        })
        .catch((error) => {
          const items = [];
          return [];
        })
        .finally(() => (this.loading = false));
    },
    countDownChangedAlert(dismissCountDown) {
      this.isAlert = dismissCountDown;
    },
    countDownChangedDateAlert(dismissCountDown) {
      this.isDateAlert = dismissCountDown;
    },
  },
};
</script>
