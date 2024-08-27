<template>
  <b-modal id="record-model-check" v-model="show" size="xl" centered>
    <template v-slot:modal-header="{ close }">
      <h5>{{ title }}</h5>
      <b-button size="sm" variant="outline-danger" @click="close()">
        <i class="fas fa-times"></i>
      </b-button>
    </template>

    <template>
      <div class="modal-form">
        <p v-if="content" v-html="content"></p>
        <b-row v-for="row in rows" v-bind:key="row.index" class="modal-row">
          <b-col v-for="cell in row.cells" v-bind:key="cell.index" :class="cell.class">
            <div v-html="cell.content"></div>
          </b-col>
        </b-row>
        <b-row class="align-items-center" v-if="type == 0">
          <b-col cols="12">
            <div class="form-group row align-items-center justify-content-center">
              <label class="col-2 col-form-label">صورت وضعیت</label>
              <div class="col-5">
                <multiselect
                  v-model="recordModal"
                  :customLabel="recordLabel"
                  track-by="id"
                  placeholder="صورت وضعیت مربوطه را انتخاب کنید."
                  open-direction="bottom"
                  :options="recordList"
                  :multiple="false"
                  :searchable="true"
                  :allow-empty="false"
                  selectLabel
                  selectedLabel
                  deselectLabel
                  @select="onSelectRecordModal"
                  @change="onSelectRecordModal"
                >
                  <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                </multiselect>
              </div>
            </div>
          </b-col>
          <b-col cols="12">
            <div class="form-group row align-items-center justify-content-center">
              <label class="col-2 col-form-label">سری</label>
              <div class="col-5 row">
                <div class="col">
                  <input
                    type="text"
                    v-model.trim="form.series1"
                    placeholder="الف"
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
                <label class="w-auto text-center col-form-label">/</label>
                <div class="col">
                  <input
                    type="number"
                    v-model.number="form.series2"
                    placeholder="۱"
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
                <label class="w-auto text-center col-form-label">/</label>
                <div class="col">
                  <input
                    type="number"
                    v-model.number="form.series3"
                    placeholder="۹۹"
                    class="form-control"
                    lang="fa"
                    min="1"
                  />
                </div>
              </div>
            </div>
          </b-col>
          <b-col cols="12">
            <div class="form-group row align-items-center justify-content-center">
              <label class="col-2 col-form-label">شماره</label>
              <div class="col-5">
                <input
                  type="text"
                  v-model.trim="form.mosng"
                  placeholder="100200"
                  class="form-control"
                  lang="fa"
                  min="1"
                />
              </div>
            </div>
          </b-col>
          <b-col cols="12">
            <div class="form-group row align-items-center justify-content-center">
              <label class="col-2 col-form-label">ساعت حرکت</label>
              <div class="col-5">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.move_time"
                  id="moveTime"
                  placeholder="ساعت حرکت را انتخاب کنید."
                />
                <date-picker
                  type="time"
                  v-model="form.move_time"
                  format="HH:mm"
                  element="moveTime"
                />
              </div>
            </div>
          </b-col>
          <b-col cols="12">
            <div class="form-group row align-items-center justify-content-center">
              <label class="col-2 col-form-label">تاریخ حرکت</label>
              <div class="col-5">
                <input
                  type="text"
                  class="form-control"
                  v-model="form.move_date"
                  id="moveDate"
                  placeholder="تاریخ حرکت را انتخاب کنید."
                />
                <date-picker
                  type="date"
                  v-model="form.move_date"
                  view="day"
                  display-format="jYYYY/jMM/jDD"
                  element="moveDate"
                />
              </div>
            </div>
          </b-col>
        </b-row>
        <b-row class="align-items-center" v-if="btnShowCancel">
          <b-col cols="12" class="text-center">
            <b-button v-if="btnCancel" variant="danger" @click="modalHandlerBtn(2)">{{
              btnCancel
            }}</b-button>
          </b-col>
        </b-row>
      </div>
      <PrintRecord :data="recordData" />
    </template>

    <template v-slot:modal-footer="{ cancel }">
      <div>
        <b-row class="datamis-btn-box">
          <b-col cols="4" class="text-right">
            <b-button
              size="sm"
              variant="success"
              v-if="btnOK != null"
              @click="modalHandlerBtn(type)"
              >{{ btnOK }}</b-button
            >
            <b-button
              size="sm"
              variant="success"
              v-if="btnPrint != null"
              @click="printHandler()"
              >{{ btnPrint }}</b-button
            >
          </b-col>
          <b-col cols="4" class="text-center">
            <b-button
              v-if="btnTry"
              size="sm"
              variant="reset"
              @click="modalHandlerBtn(3)"
              >{{ btnTry }}</b-button
            >
          </b-col>
          <b-col cols="4">
            <b-button size="sm" variant="danger" @click="cancel()">{{
              btnClose
            }}</b-button>
          </b-col>
        </b-row>
      </div>
    </template>
  </b-modal>
</template>

<script>
var moment = require("moment-jalaali");
import PrintRecord from "../../../components/modal-forms/record/Print";
export default {
  props: {
    show: { default: false },
    recordData: { default: null },
  },
  data() {
    return {
      form: {},
      recordList: [],
      recordModal: null,
      api: "api/v1/client/travels/tracking-list",
      api_records: "api/v1/client/travels/tracking-list/records",
      content: null,
      rows: [],
      type: 0,
      btnShowCancel: null,
      title: "درخواست صدور صورت وضعیت",
      btnPrint: null,
      btnOK: "بلی",
      btnClose: "بستن",
      btnCancel: "لغو/ابطال",
      btnTry: null,
      loading: false,
      endPoint: null,
      item: null,
    };
  },
  components: {
    PrintRecord,
  },
  computed: {
    calendar: function () {
      return moment().format("jYYYY/jM/jD");
    },
  },
  methods: {
    modalHandlerBtn(type) {
      var promise = null;

      if (type === 1) {
        promise = this.$http.put(this.$api(this.api + "/" + this.form.id), this.form);
      } else if (type === 3) {
        promise = this.$http.get(
          this.$api(this.api + "/" + this.form.travel_id + "/try")
        );
      } else if (type === 2) {
        promise = this.$http.post(this.$api(this.api + "/cancel"), this.form);
      } else {
        promise = this.$http.post(this.$api(this.api), this.form);
      }

      return promise
        .then((response) => {
          const items = response.data;
          this.loadData(items);
          return items;
        })
        .catch((error) => {
          let e = error.response;
          if (e != undefined) {
            if (e.status === 422 || e.status === 209) {
              let er = e.data;
              if (er) {
                this.$notify({
                  group: "error",
                  text: er["message"],
                  type: "error",

                  duration: 10000,
                });
              }
            }
          }
          return [];
        });
    },
    printHandler() {
      this.$htmlToPaper("print");
    },
    onSelectRecordModal(value) {
      this.recordModal = value;
      this.form.of = value.of;
      this.form.to = value.to;
      this.form.series1 = value.series1;
      this.form.series2 = value.series2;
      this.form.series3 = value.series3;
      this.form.mosng = value.last_page;
      this.form.record_id = value.id;
    },
    getRecordList() {
      let promise = this.$http.get(this.$api(this.api_records));

      return promise
        .then((response) => {
          this.recordList = response.data;
          if (this.record == null) this.record = this.recordList[0];
          if (this.recordModal == null) this.recordModal = this.recordList[0];
        })
        .catch((error) => {
          console.error("Error : " + error);
          return [];
        });
    },
    recordLabel(value) {
      return value.travel_type.name + " - " + value.code;
    },
    loadData(recordData) {
      console.error(recordData);

      this.form.of = this.recordModal.of;
      this.form.to = this.recordModal.to;
      this.form.series1 = this.recordModal.series1;
      this.form.series2 = this.recordModal.series2;
      this.form.series3 = this.recordModal.series3;
      this.form.mosng = this.recordModal.last_page;
      this.form.move_date = recordData.travel_record.move_date;
      this.form.move_time = recordData.travel_record.move_time;
      this.form.travel_id = recordData.travel_record.id;
      this.form.record_id = this.recordModal.id;

      if (recordData.record_info == null) {
        this.title = "کنترل صورت وضعیت و دریافت کد رهگیری";

        this.rows = [];
        this.rows.push({
          cells: [
            { class: "col-2", content: recordData.travel_record.chival_code },
            { class: "col", content: recordData.route_info.name },
            {
              class: "col",
              content:
                recordData.driver_info_record.fname +
                " " +
                recordData.driver_info_record.lname,
            },
            {
              class: "col-2",
              content:
                recordData.car_info_record.plate_series_3 +
                recordData.car_info_record.plate_series_2 +
                recordData.car_info_record.plate_series_1 +
                " | " +
                recordData.car_info_record.plate_series,
            },
          ],
        });

        this.btnOK = "دریافت کد رهگیری";
        this.btnClose = "انصراف";
      } else {
        this.btnShowCancel = true;
        this.title = "کنترل صورت وضعیت و دریافت کد رهگیری";
        if (recordData.record_info.status == 10) {
          this.type = 2;
          this.btnTry = "درخواست بررسی صورت وضعیت";
        } else {
          this.type = 1;
          this.btnTry = "درخواست مجدد کد رهگیری";
          this.btnShowCancel = false;
        }

        // this.type = 1;
        // if (recordData.record_info.status < 0)
        //   this.btnTry = "درخواست مجدد کد رهگیری";
        this.rows = [];
        this.rows.push({
          cells: [
            { class: "col-2", content: recordData.travel_record.chival_code },
            { class: "col", content: recordData.route_info.name },
            {
              class: "col",
              content:
                recordData.driver_info_record.fname +
                " " +
                recordData.driver_info_record.lname,
            },
            {
              class: "col-2",
              content:
                recordData.car_info_record.plate_series_3 +
                recordData.car_info_record.plate_series_2 +
                recordData.car_info_record.plate_series_1 +
                " | " +
                recordData.car_info_record.plate_series,
            },
          ],
        });
        this.rows.push({
          cells: [
            { class: "col-2", content: "صورت وضعیت :" },
            { class: "col-10 text-center", content: recordData.record_info.seri_show },
          ],
        });
        this.rows.push({
          cells: [
            { class: "col-2", content: "کد رهگیری :" },
            {
              class: "col-10 text-center",
              content: recordData.record_info.system_code,
            },
          ],
        });
        this.rows.push({
          cells: [
            { class: "col-2", content: "توضیحات :" },
            { class: "col-10 text-center", content: recordData.record_info.note },
          ],
        });

        this.btnOK = null;
        this.btnPrint = "چاپ صورت وضعیت";
        this.btnCancel = "لغو/ابطال صورت وضعیت";
        this.btnClose = "بستن صفحه";

        if (recordData.record_info.status < 0) {
          this.type = 1;
          // this.btnPrint = null;
          this.title = "کنترل صورت وضعیت و نمایش خطا";
        }
      }
    },
  },
};
</script>
