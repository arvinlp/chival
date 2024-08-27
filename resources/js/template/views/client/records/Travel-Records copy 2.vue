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
              @showModal="clickOnRow"
            />
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
    <Modalhandler />
  </section>
</template>

<script>
import Body from "../../../components/client/Body";
import CardProgress from "../../../components/CardProgress";
import RecordRow from "../../../components/RecordRow";
import Modalhandler from "../../../components/modal-forms/record/Modalhandler";

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
        data:[],
      },
    };
  },

  components: {
    Body,
    CardProgress,
    RecordRow,
    Modalhandler,
  },

  created() {
    this.getAllDestenations();
    this.getRecordList();

    this.timer = setInterval(this.systemCheck, 10 * 1000); //Milisec
  },
  mounted() {
  },
  methods: {
    systemCheck() {
      this.getRecordList();
    },
    clickOnRow(item) {
      this.modalHandler.show = true;
      this.modalHandler.data = item;
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
