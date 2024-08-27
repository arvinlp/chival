<template>
  <section class="page">
    <b-alert
      :show="alert.show"
      fade
      :variant="alert.type"
      @dismiss-count-down="countDownChangedAlert"
    >
      <div>{{ alert.content }}</div>
    </b-alert>
    <div class="row row-eq-height">
      <CardProgress
        class="col-4"
        :dynomic="{ name: 'client-record-transfer' }"
        type="success"
        :value="100"
        :striped="false"
        :animated="true"
      >
        <template slot="header">
          <h5 class="mb-3">انتقال صورت وضعیت به کاربر دیگر</h5>
        </template>
      </CardProgress>
      <div class="col-8">
        <div class="inner-main">
          <b-row class="inner-body">
            <b-col cols="4">
              <multiselect
                v-model="record"
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
                @select="onSelectRecord"
                @change="onSelectRecord"
              >
                <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
              </multiselect>
            </b-col>
            <b-col cols="8" v-if="record" class="row text-center">
              <b-col cols="3">
                سری
                <br />
                {{ record.series1 }}/{{ record.series2 }}/{{ record.series3 }}
              </b-col>
              <b-col cols="2">
                از
                <br />
                {{ record.of }}
              </b-col>
              <b-col cols="2">
                تعداد
                <br />
                {{ record.pages }}
              </b-col>
              <b-col cols="2">
                تا
                <br />
                {{ record.to }}
              </b-col>
              <b-col cols="3">
                باقی مانده
                <br />
                {{ record.remnant }}
              </b-col>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="inner-main">
          <div class="inner-header">
            <b-row>
              <b-col cols="11">
                <span>لیست صورت وضعیت</span>
              </b-col>
              <b-col cols="1" class="text-left">
                <b-button class="btn-icon" v-on:click="systemCheck">
                  <i class="fas fa-sync"></i>
                </b-button>
              </b-col>
            </b-row>
          </div>
          <b-row class="inner-body">
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">انتخاب مقصد :</label>
                <div class="col-9">
                  <multiselect
                    v-model="destenation"
                    :customLabel="destenationLabel"
                    track-by="id"
                    placeholder="مقصد را انتخاب کنید."
                    open-direction="bottom"
                    :options="destenationList"
                    :multiple="false"
                    :searchable="true"
                    selectLabel="انتخاب خط"
                    selectedLabel
                    deselectLabel="نمایش همه"
                    @select="onSelectDestenation"
                    @change="onSelectDestenation"
                    @remove="onDeselectDestenation"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
            <b-col cols="6">
              <div class="form-group row align-items-center">
                <label class="col-3 col-form-label">نحوه نمایش :</label>
                <div class="col-9">
                  <multiselect
                    v-model="showType"
                    label="name"
                    placeholder="نوع نمایش را مشخص کنید."
                    open-direction="bottom"
                    :options="showTypes"
                    :multiple="false"
                    :searchable="true"
                    selectLabel
                    selectedLabel
                    deselectLabel
                    @select="onSelectShowType"
                    @change="onSelectShowType"
                  >
                    <span slot="noResult">موردی یافت نشد مجددا بررسی کنید.</span>
                  </multiselect>
                </div>
              </div>
            </b-col>
          </b-row>
          <div class="inner-body" v-if="items">
            <div :class="loading"></div>
            <RecordRow
              v-for="item in items"
              :key="item.id"
              :item="item"
              @clickOnRow="clickOnRow"
            >
              <template slot="action">
                <b-button class="btn-icon" v-on:click="clickOnRow(item)">
                  <i class="fas fa-file-contract"></i>
                </b-button>
              </template>
            </RecordRow>
          </div>
          <b-row class="inner-body" v-else-if="destenation == null">
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <div class="col-12 text-center">
                  خط مورد نظر برای نمایش لیست را انتخاب کنید.
                </div>
              </div>
            </b-col>
          </b-row>
          <b-row class="inner-body" v-else>
            <b-col cols="12">
              <div class="form-group row align-items-center">
                <div class="col-12 text-center text-danger">
                  سفری جهت دریافت صورت وضعیت وجود ندارد!
                </div>
              </div>
            </b-col>
          </b-row>
        </div>
      </div>
    </div>
    <!-- -->
    <b-modal v-model="modalHandler.show" size="xl" centered>
      <template v-slot:modal-header="{ close }">
        <h5>{{ modalHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <div class="modal-form">
          <p v-if="modalHandler.content" v-html="modalHandler.content"></p>
          <b-row
            v-for="row in modalHandler.rows"
            v-bind:key="row.index"
            class="modal-row"
          >
            <b-col v-for="cell in row.cells" v-bind:key="cell.index" :class="cell.class">
              <div v-html="cell.content"></div>
            </b-col>
          </b-row>
          <b-row class="align-items-center" v-if="modalHandler.type == 0">
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
          <b-row class="align-items-center" v-if="modalHandler.btnShowCancel">
            <b-col cols="12" class="text-center">
              <b-button
                v-if="modalHandler.btnCancel"
                variant="danger"
                @click="modalHandlerBtn(2)"
                >{{ modalHandler.btnCancel }}</b-button
              >
            </b-col>
          </b-row>
        </div>
        <PrintRecord
          :ItemHandler="ItemHandler"
        />
      </template>

      <template v-slot:modal-footer="{ cancel }">
        <div>
          <b-row class="datamis-btn-box">
            <b-col cols="4" class="text-right">
              <b-button
                size="sm"
                variant="success"
                v-if="modalHandler.btnOK != null"
                @click="modalHandlerBtn(modalHandler.type)"
                >{{ modalHandler.btnOK }}</b-button
              >
              <b-button
                size="sm"
                variant="success"
                v-if="modalHandler.btnPrint != null"
                @click="ItemHandlerBtn()"
                >{{ modalHandler.btnPrint }}</b-button
              >
            </b-col>
            <b-col cols="4" class="text-center">
              <b-button
                v-if="modalHandler.btnTry"
                size="sm"
                variant="reset"
                @click="modalHandlerBtn(3)"
                >{{ modalHandler.btnTry }}</b-button
              >
            </b-col>
            <b-col cols="4">
              <b-button size="sm" variant="danger" @click="cancel()">{{
                modalHandler.btnClose
              }}</b-button>
            </b-col>
          </b-row>
        </div>
      </template>
    </b-modal>

    <b-modal id="modal" v-model="ItemHandler.show" size="xl" centered>
      <template v-slot:modal-header="{ close }">
        <h5>{{ ItemHandler.title }}</h5>
        <b-button size="sm" variant="outline-danger" @click="close()">
          <i class="fas fa-times"></i>
        </b-button>
      </template>

      <template>
        <p v-if="ItemHandler.content" v-html="ItemHandler.content"></p>
        <textarea
          v-if="ItemHandler.placeholder"
          v-model="form.note"
          :placeholder="ItemHandler.placeholder"
          class="form-control"
        />
      </template>

      <template v-slot:modal-footer="{ cancel }">
        <div>
          <div class="text-right">
            <b-button size="sm" variant="success" @click="ItemHandlerBtn()">{{
              ItemHandler.btnOK
            }}</b-button>
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="cancel()">{{
              ItemHandler.btnCancel
            }}</b-button>
          </div>
        </div>
      </template>
    </b-modal>
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import RecordRow from "../../../components/RecordRow";
import PrintRecord from "../../../components/modal-forms/record/Print";
var moment = require("moment-jalaali");

export default {
  data() {
    return {
      form: {
        status: null,
        move_time: null,
        move_date: null,
        note: null,
      },
      loading: true,
      items: null,
      destenation: null,
      destenationList: [],
      record: null,
      recordModal: null,
      recordList: [],
      showType: {
        id: 0,
        name: "لیست در انتظار دریافت",
        end_point: "?show=pendding",
      },
      showTypes: [
        { id: 0, name: "لیست در انتظار دریافت", end_point: "?show=pendding" },
        { id: 1, name: "چاپ شده", end_point: "?show=done" },
        { id: 2, name: "نمایش همه", end_point: "?show=all" },
      ],
      timer: "",
      counter: 0,
      loading: "overlay d-block",

      api: "api/v1/client/travels/tracking-list",
      api_records: "api/v1/client/travels/tracking-list/records",
      api_destenation: "api/v1/client/routes/destanations",

      alert: {
        show: false,
        content: null,
        type: "success",
        sec: 5,
      },
      modalHandler: {
        show: false,
        title: "عنوان آیتم",
        content: null,
        btnPrint: null,
        btnOK: "بلی",
        btnClose: "بستن",
        btnCancel: "لغو/ابطال",
        btnTry: null,
        loading: false,
        type: null,
        endPoint: null,
        item: null,
        rows: [],
        type: 0,
        btnShowCancel: false,
      },
      ItemHandler: {
        show: false,
        title: "عنوان آیتم",
        content: null,
        btnOK: "بلی",
        btnCancel: "خیر",
        type: null,
        endPoint: null,
        item: null,
        placeholder: null,
        data: [],
      },
    };
  },

  components: {
    Body,
    CardProgress,
    RecordRow,
    PrintRecord
  },

  computed: {
    isType: function () {
      return this.$store.getters.isType;
    },
    calendar: function () {
      return moment().format("jYYYY/jM/jD");
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter((f) => f.sortable)
        .map((f) => {
          return { text: f.label, value: f.key };
        });
    },
  },
  created() {
    this.getAllDestenations();
    this.getRecordList();

    this.timer = setInterval(this.systemCheck, 10 * 1000); //Milisec
  },
  mounted() {},
  methods: {
    systemCheck() {
      this.getRecordList();
    },
    clickOnRow(id, show = true, type = 0) {
      this.ItemHandler = {
        show: false,
        title: "عنوان آیتم",
        content: null,
        btnOK: "بلی",
        btnCancel: "خیر",
        type: null,
        endPoint: null,
        item: null,
        placeholder: null,
        data: [],
      };
      this.ItemHandler.data = id;

      this.form.of = this.recordModal.of;
      this.form.to = this.recordModal.to;
      this.form.series1 = this.recordModal.series1;
      this.form.series2 = this.recordModal.series2;
      this.form.series3 = this.recordModal.series3;
      this.form.mosng = this.recordModal.last_page;
      this.form.move_date = id.travel_record.move_date;
      this.form.move_time = id.travel_record.move_time;
      this.form.travel_id = id.travel_record.id;
      this.form.record_id = this.recordModal.id;

      if (id.record_info == null) {
        this.modalHandler.title = "کنترل صورت وضعیت و دریافت کد رهگیری";

        this.modalHandler.rows = [];
        this.modalHandler.rows.push({
          cells: [
            { class: "col-2", content: id.travel_record.chival_code },
            { class: "col", content: id.route_info.name },
            {
              class: "col",
              content: id.driver_info_record.fname + " " + id.driver_info_record.lname,
            },
            {
              class: "col-2",
              content:
                id.car_info_record.plate_series_3 +
                id.car_info_record.plate_series_2 +
                id.car_info_record.plate_series_1 +
                " | " +
                id.car_info_record.plate_series,
            },
          ],
        });

        this.modalHandler.btnOK = "دریافت کد رهگیری";
        this.modalHandler.btnClose = "انصراف";
      } else {
        this.modalHandler.btnShowCancel = true;
        this.modalHandler.title = "کنترل صورت وضعیت و دریافت کد رهگیری";
        if (id.record_info.status == 10) {
          this.modalHandler.type = 2;
          this.modalHandler.btnTry = "درخواست بررسی صورت وضعیت";
        } else {
          this.modalHandler.type = 1;
          this.modalHandler.btnTry = "درخواست مجدد کد رهگیری";
          this.modalHandler.btnShowCancel = false;
        }

        // this.modalHandler.type = 1;
        // if (id.record_info.status < 0)
        //   this.modalHandler.btnTry = "درخواست مجدد کد رهگیری";
        this.modalHandler.rows = [];
        this.modalHandler.rows.push({
          cells: [
            { class: "col-2", content: id.travel_record.chival_code },
            { class: "col", content: id.route_info.name },
            {
              class: "col",
              content: id.driver_info_record.fname + " " + id.driver_info_record.lname,
            },
            {
              class: "col-2",
              content:
                id.car_info_record.plate_series_3 +
                id.car_info_record.plate_series_2 +
                id.car_info_record.plate_series_1 +
                " | " +
                id.car_info_record.plate_series,
            },
          ],
        });
        this.modalHandler.rows.push({
          cells: [
            { class: "col-2", content: "صورت وضعیت :" },
            { class: "col-10 text-center", content: id.record_info.seri_show },
          ],
        });
        this.modalHandler.rows.push({
          cells: [
            { class: "col-2", content: "کد رهگیری :" },
            {
              class: "col-10 text-center",
              content: id.record_info.system_code,
            },
          ],
        });
        this.modalHandler.rows.push({
          cells: [
            { class: "col-2", content: "توضیحات :" },
            { class: "col-10 text-center", content: id.record_info.note },
          ],
        });

        this.modalHandler.btnOK = null;
        this.modalHandler.btnPrint = "چاپ صورت وضعیت";
        this.modalHandler.btnCancel = "لغو/ابطال صورت وضعیت";
        this.modalHandler.btnClose = "بستن صفحه";

        if (id.record_info.status < 0) {
          this.modalHandler.type = 1;
          // this.modalHandler.btnPrint = null;
          this.modalHandler.title = "کنترل صورت وضعیت و نمایش خطا";
        }
      }
      this.modalHandler.show = show;
    },

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
        .then(() => {
          this.fetchTravelList();
          this.clickOnRow(this.form.id, true);
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
        })
        .finally(() => (this.loading = "overlay"));
    },
    ItemHandlerBtn() {
      this.$htmlToPaper("print");
      this.ItemHandler.show = false;
    },
    onSelectRecord(value) {
      this.record = value;
      this.recordModal = value;
      this.systemCheck();
    },
    onSelectShowType(value) {
      this.showType = value;
      this.systemCheck();
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
    onSelectDestenation(value) {
      if (value != null) this.destenation = value;
      else this.destenation = null;
      this.systemCheck();
    },
    onDeselectDestenation() {
      this.destenation = null;
      this.systemCheck();
    },
    fetchTravelList() {
      var url = this.api + this.showType.end_point + "&record_id=" + this.record.id;
      if (this.destenation != null) {
        url = url + "&destenation=" + this.destenation.id;
      }
      let promise = this.$http.get(this.$api(url));

      this.counter++;
      this.loading = "overlay d-block";

      return promise
        .then((response) => {
          const items = response.data;
          this.items = items;
          return items.data;
        })
        .catch((error) => {
          this.items = null;
          return [];
        })
        .finally(() => (this.loading = "overlay"));
    },
    countDownChangedAlert(dismissCountDown) {
      this.alert.show = dismissCountDown;
    },
    getAllDestenations() {
      let promise = this.$http.get(this.$api(this.api_destenation));
      this.loading = true;

      clearInterval(this.timer);

      return promise
        .then((response) => {
          this.destenationList = response.data;
        })
        .catch((error) => {
          console.error("Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    getRecordList() {
      let promise = this.$http.get(this.$api(this.api_records));
      this.loading = true;

      clearInterval(this.timer);

      return promise
        .then((response) => {
          this.recordList = response.data;
          if (this.record == null) this.record = this.recordList[0];
          if (this.recordModal == null) this.recordModal = this.recordList[0];
          this.fetchTravelList();
        })
        .catch((error) => {
          console.error("Error : " + error);
          return [];
        })
        .finally(() => (this.loading = false));
    },
    destenationLabel(value) {
      return value.name;
    },
    recordLabel(value) {
      return value.travel_type.name + " - " + value.code;
    },
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>
