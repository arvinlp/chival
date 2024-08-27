<template>
  <div id="print">
    <div id="ticket">
      <!-- <img src="http://localhost:8000/images/logo.png" alt="Logo" style /> -->
      <table v-if="travel" class="base-ticket">
        <tr class="text-center">
          <td colspan="2">
            <div class="title">{{ travel.starting_company.name }}</div>
            <div v-if="travel.starting_company">
              آدرس : {{ travel.starting_company.address }}
            </div>
            <div v-if="travel.starting_company">
              تلفن : {{ travel.starting_company.tell }}
            </div>
          </td>
        </tr>
        <tr>
          <td class="time">{{ time }}</td>
          <td class="date">{{ calendar }}</td>
        </tr>
        <tr>
          <td>شماره سفر</td>
          <td>{{ travel.chival_code }}</td>
        </tr>
        <tr v-if="seat.fname != null || seat.lname != null">
          <td colspan="2" class="text-center">
            {{ seat.fname }} {{ seat.lname }}
          </td>
        </tr>
        <tr v-if="seat.seat_number != null">
          <td>صندلی</td>
          <td>{{ seat.seat_number }}</td>
        </tr>
        <tr v-if="seat.total_amount != null">
          <td>قیمت صندلی</td>
          <td>{{ seat.total_amount }} ریال</td>
        </tr>
        <tr v-if="travel.starting_city != null">
          <td>مبدا</td>
          <td>
            {{ travel.starting_city.name }}
          </td>
        </tr>
        <tr v-if="travel.destanation_city != null">
          <td>مقصد</td>
          <td>
            {{ travel.destanation_city.name }}
          </td>
        </tr>
        <tr v-if="travel.driver_info != null">
          <td>نام راننده</td>
          <td>{{ travel.driver_info.fname }} {{ travel.driver_info.lname }}</td>
        </tr>
        <tr>
          <td>پلاک خودرو</td>
          <td>
            {{ travel.car_info.plate_series }}|{{
              travel.car_info.plate_series_1
            }}
            {{ travel.car_info.plate_series_2 }}
            {{ travel.car_info.plate_series_3 }}
          </td>
        </tr>
        <tr>
          <td>نوع وسیله نقلیه</td>
          <td v-if="travel.car_type != undefined">
            <span v-if="travel.car_type.car_type != undefined">{{
              travel.car_type.car_type.name
            }}</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-center">با تشکر از شما</td>
        </tr>
      </table>
    </div>
    <div class="pagebreak"></div>
    <div id="ticket">
      <table v-if="travel" class="base-ticket part-2">
        <tr>
          <td colspan="2" class="text-center">این قسمت مربوط به راننده می باشد.</td>
        </tr>
        <tr>
          <td colspan="2">
            <div  class="text-center">{{ travel.starting_company.name }}</div>
            <div class="text-center" v-if="travel.starting_company">
              آدرس : {{ travel.starting_company.address }}
            </div>
            <div class="text-center" v-if="travel.starting_company">
              تلفن : {{ travel.starting_company.tell }}
            </div>
          </td>
        </tr>
        <tr>
          <td class="time">{{ time }}</td>
          <td class="date">{{ calendar }}</td>
        </tr>

        <tr>
          <td>شماره سفر</td>
          <td>{{ travel.chival_code }}</td>
        </tr>
        <tr v-if="seat.seat_number != null">
          <td>صندلی</td>
          <td v-if="seat.seat_number != null">{{ seat.seat_number }}</td>
        </tr>
        <tr v-if="travel.starting_city != null">
          <td>مبدا</td>
          <td v-if="travel.starting_city != null">
            {{ travel.starting_city.name }}
          </td>
        </tr>
        <tr v-if="travel.destanation_city != null">
          <td>مقصد</td>
          <td v-if="travel.destanation_city != null">
            {{ travel.destanation_city.name }}
          </td>
        </tr>
        <tr>
          <td colspan="2" class="text-center">
            راننده محترم صندلی فروخته مطلق به مسافر بوده وبه هیچ عنوان قابل
            تغییر با صندلی دیگری نمی باشد. در صورت مشاهده تخلف سفر شما لغو می
            شود.
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
var moment = require("moment-jalaali");
export default {
  data() {
    return {
      travel: {},
      seat: {},
    };
  },

  components: {},

  computed: {
    calendar: function () {
      var date = new Date();
      return moment(
        date.getFullYear() + "/" + date.getMonth() + "/" + date.getDate(),
        "YYYY/M/D"
      ).format("jYYYY/jM/jD");
    },
    time: function () {
      var date = new Date();
      return moment(date.getHours() + ":" + date.getMinutes(), "HH:mm").format(
        "HH:mm"
      );
    },
  },
  created() {
    this.seat = {
      id: 20,
      travel_id: "6",
      passenger_id: "7",
      seat_number: "3",
      child_number: "0",
      sex: "0",
      package_number: "1",
      package: "10000",
      tax: "11500",
      commission: "34500",
      price: "230000",
      amount: "230000",
      total_amount: "230000",
      discont: null,
      created_at: "2020-11-15 12:07:11",
      updated_at: "2020-11-15 12:07:11",
      fname: "آروین",
      lname: "لری پور",
      nation_code: "2980496413",
      mobile: "09373678851",
    };
    this.travel = {
      id: 6,
      chival_code: "CH1-201113131312-4",
      company_id: "1",
      turn_list_id: "7",
      driver_id: "2",
      car_id: "1",
      route_id: "4",
      driver_book_time_id: "2",
      travel_type: "2",
      driver_card_no: "3051775312",
      car_card_no: "2552133",
      orgin_city: "45310000",
      dest_city: "45340000",
      far_city: "65.00000000",
      chairs_number: "3",
      insurance_body: "0",
      insurance_third: "0",
      car_type: {
        id: 1,
        car_system_id: "1",
        car_type: {
          id: 1,
          name: "پژو",
          type: "8",
          status: "1",
          created_at: null,
          updated_at: null,
          deleted_at: null,
        },
      },
      plaque_number: "28n933",
      plaque_serial: "65",
      coast: "690000",
      tax: "34500",
      price: "690000",
      commission: "103500",
      amount: "230000",
      total_amount: "230000",
      discont: "0",
      child_number: "0",
      package_number: "1",
      package: "10000",
      passenger_number: "1",
      move_date: null,
      move_time: null,
      status: "10",
      note: null,
      created_at: "2020-11-13 13:13:12",
      updated_at: "2020-11-15 12:07:11",
      deleted_at: null,
      travel_passengers: [
        {
          id: 20,
          travel_id: "6",
          passenger_id: "7",
          seat_number: "3",
          child_number: "0",
          sex: "0",
          package_number: "1",
          package: "10000",
          tax: "11500",
          commission: "34500",
          price: "230000",
          amount: "230000",
          total_amount: "230000",
          discont: null,
          created_at: "2020-11-15 12:07:11",
          updated_at: "2020-11-15 12:07:11",
          fname: "آروین",
          lname: "لری پور",
          nation_code: "2980496413",
          mobile: "09373678851",
        },
      ],
      seat_prices: [
        {
          id: 37,
          route_id: "4",
          seat_number: "1",
          price: "230000",
          tax: "11500",
          commission: "34500",
          passenger: "230000",
        },
        {
          id: 38,
          route_id: "4",
          seat_number: "2",
          price: "230000",
          tax: "11500",
          commission: "34500",
          passenger: "230000",
        },
        {
          id: 39,
          route_id: "4",
          seat_number: "3",
          price: "230000",
          tax: "11500",
          commission: "34500",
          passenger: "230000",
        },
      ],
      driver_info: {
        id: 2,
        fname: "محمد",
        lname: "بلوچ حسين اميري",
        mobile: "0",
      },
      car_info: {
        id: 1,
        plate_series: "65",
        plate_series_1: "933",
        plate_series_2: "ع",
        plate_series_3: "28",
      },
      turn_list: {
        id: 7,
        status: "92",
        selling_jalali: "خطا: زمان ورود به فروش بیلط ثبت نشده است",
      },
      starting_city: {
        id: 45310000,
        name: "کرمان",
      },
      destanation_city: {
        id: 45340000,
        name: "بردسیر",
      },
      starting_company: {
        id: 1,
        company_code: "۴۵۰۰۴۵۶",
        name: "مهاجر سفرکرمان",
        slug: "Chival Safar Iran",
        tell: "۰۳۴۳۲۱۲۴۵۲۲",
        mobile: "-",
        postal_code: null,
        address: "کرمان بلوار شهید صدوقی جنب اداره پست",
        province: "21",
        county: "296",
        city: "902",
        rmto_city: "45310000",
        status: "1",
        img: null,
        note: null,
        created_at: null,
        updated_at: "2020-08-20 07:42:56",
        deleted_at: null,
        location: "کرمان - کرمان - کرمان",
        company_manager: null,
        folder: null,
      },
      car_system: {
        id: 1,
        car_type_id: "1",
        car_system: {
          id: 1,
          name: "سواری",
          status: "1",
          capacity: "3",
          created_at: null,
          updated_at: null,
          deleted_at: null,
        },
      },
    };
  },
  mounted() {},
  methods: {},
};
</script>

