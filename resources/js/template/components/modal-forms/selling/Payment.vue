<template>
  <div>
    <b-button v-b-modal.modal_payment> {{ formatPrice(payment_form.amount) }} ریال </b-button>

    <b-modal id="modal_payment" centered>
      <template v-slot:modal-header>
        <h5>پرداخت با دستگاه پوز</h5>
      </template>

      <template>
        <b-overlay :show="showLoading" variant="transparent" rounded="sm">
          <div class="modal-form">
            <b-row class="inner-body">
              <b-col cols="12">
                <div class="form-group row align-items-center">
                  <label class="col col-form-label">مبلغ قابل پرداخت</label>
                  <div class="col-7">
                    <currency-input
                      v-model="payment_form.amount"
                      placeholder="مبلغ قابل پرداخت را وارد نمایید."
                      class="form-control"
                      lang="fa"
                    />
                  </div>
                </div>
              </b-col>
            </b-row>
            <b-row class="inner-body">
              <b-col cols="12">
                <div class="form-group row align-items-center">
                  <b-col cols="12" class="text-center">{{text}}</b-col>
                </div>
              </b-col>
            </b-row>
          </div>
          <template #overlay>
            <div class="loading">
              <b-icon :icon="loading.icon" font-scale="3" animation="cylon"></b-icon>
              <p id="cancel-label" class="label">
                {{ loading.label }}<span animation="cylon"> ... </span>
              </p>
            </div>
          </template>
        </b-overlay>
      </template>

      <template v-slot:modal-footer="{ onReset }">
        <div>
          <div class="text-right">
            <b-button size="sm" variant="success" @click="onSubmit()">
              ارسال درخواست به دستگاه
            </b-button>
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="onReset()">
              پرداخت نقدی
            </b-button>
          </div>
        </div>
      </template>
    </b-modal>
  </div>
</template>

<script>
export default {
  props: {
    travel: {
      type: Object,
      description: "Travel",
      default: [],
    },
    passenger: {
      type: Object,
      description: "Seat",
    },
  },
  data() {
    return {
      payment_form: {},
      payment_type: [
        { name: "پرداخت نقدی", code: "10" },
        { name: "پرداخت با دستگاه پوز", code: "200" },
      ],
      showLoading: true,
      show: false,
      paymentApi: "api/v1/client/centeral-pcpos/start-payment",
      modalID: "modal_payment",
      loading: {
        label: "در انتظار دریافت اطلاعات پرداخت",
        icon: "stopwatch",
      },
      text:""
    };
  },
  computed: {},
  created() {
    this.payment_form.passenger_id = this.passenger.id;
    this.payment_form.item_id = this.travel.id;
    this.payment_form.item_type = "travel";
    this.payment_form.cheval_code = this.travel.chival_code;
    this.payment_form.amount = this.passenger.total_amount;
    this.showLoading = false;
  },
  methods: {
    formatPrice(value) {
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    onSubmit() {
      this.showLoading = true;
      let promise = this.$http.post(this.$api(this.paymentApi), this.payment_form);
      promise
        .then((response) => {
          if(response.data.original != undefined){
            if(response.data.original.message != undefined)
              this.text = response.data.original.message[0];
          }else{
            this.text = "";
            this.$root.$emit("bv::hide::modal", this.modalID);
          }
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
        })
        .finally(() => (this.showLoading = false));
    },
    onReset() {
      this.$root.$emit("bv::hide::modal", this.modalID);
    },
  },
};
</script>
