<template>
  <b-modal id="modal" v-model="ItemHandler.show" centered>
    <template v-slot:modal-header="{ close }">
      <h5>{{ ItemHandler.title }}</h5>
      <b-button size="sm" variant="outline-danger" @click="close()">
        <i class="fas fa-times"></i>
      </b-button>
    </template>

    <template v-if="seat != undefined">
      <p v-if="ItemHandler.content" v-html="ItemHandler.content"></p>
      <textarea
        v-if="ItemHandler.placeholder"
        v-model="form.note"
        :placeholder="ItemHandler.placeholder"
        class="form-control"
      />
      <div id="print">
        <div class="ticket">
          <table v-if="travel" class="base-ticket">
            <tr class="text-center">
              <td colspan="2" v-if="travel.starting_company">
                <div v-if="travel.starting_company">
                  {{ travel.starting_company.name }}
                </div>
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
              <td colspan="2" class="text-center">{{ seat.fname }} {{ seat.lname }}</td>
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
                {{ travel.car_info.plate_series }}|{{ travel.car_info.plate_series_1 }}
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
        <div class="ticket">
          <table v-if="travel" class="base-ticket part-2">
            <tr>
              <td colspan="2" class="text-center">این قسمت مربوط به راننده می باشد.</td>
            </tr>
            <tr>
              <td colspan="2" v-if="travel.starting_company">
                <div v-if="travel.starting_company">
                  {{ travel.starting_company.name }}
                </div>
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
                راننده محترم صندلی فروخته مطلق به مسافر بوده وبه هیچ عنوان قابل تغییر با
                صندلی دیگری نمی باشد. در صورت مشاهده تخلف سفر شما لغو می شود.
              </td>
            </tr>
          </table>
        </div>
      </div>
    </template>

    <template v-slot:modal-footer="{ cancel }">
      <div>
        <div class="text-right">
          <b-button
            size="sm"
            variant="success"
            @click="ItemHandlerBtn(ItemHandler.type)"
            >{{ ItemHandler.btnOK }}</b-button
          >
        </div>
        <div>
          <b-button size="sm" variant="danger" @click="cancel()">{{
            ItemHandler.btnCancel
          }}</b-button>
        </div>
      </div>
    </template>
  </b-modal>
</template>
<script>
var moment = require("moment-jalaali");

export default {
  props: {
    travel: {
      type: Object,
      description: "Travel",
      default: [],
    },
    seat: {
      type: Object,
      description: "Seat",
    },
    ItemHandler: {
      type: Object,
      description: "ItemHandler",
      default: [],
    },
  },
  data() {
    return {
    };
  },
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
      return moment(date.getHours() + ":" + date.getMinutes(), "HH:mm").format("HH:mm");
    },
  },
  methods: {
    ItemHandlerBtn() {
      this.$htmlToPaper("print");
    },
  },
};
</script>
