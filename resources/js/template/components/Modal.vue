<template>
  <!-- -->
  <b-modal ref="my-modal"  centered>
    <template v-slot:modal-header="{ close }">
      <h5>{{modalTitle}}</h5>
      <b-button size="sm" variant="outline-danger" @click="close()">
        <i class="fas fa-times"></i>
      </b-button>
    </template>

    <template>
      <p v-html="modalContent"></p>
    </template>

    <template v-slot:modal-footer="{ ok, cancel }">
      <div v-if="modalBtnOk">
        <div class="text-right" v-if="modalBtnOk">
          <b-button size="sm" variant="success" @click="ok()">{{modalBtnOk}}</b-button>
        </div>
        <div v-if="modalBtnCancel">
          <b-button size="sm" variant="danger" @click="cancel()">{{modalBtnCancel}}</b-button>
        </div>
      </div>
      <div v-else>
        <div class="text-right" v-if="modalBtnCancel">
          <b-button size="sm" variant="danger" @click="cancel()">{{modalBtnCancel}}</b-button>
        </div>
      </div>
    </template>
  </b-modal>
</template>

<script>
export default {
  name: "Modal",

  props: {
    modalShow: {
      type: Boolean
    },
    modalTitle: {
      type: String,
      default: ""
    },
    modalContent: {
      type: String,
      default: ""
    },
    modalBtnOk: {
      type: String,
      default: null
    },
    modalBtnCancel: {
      type: String,
      default: null
    }
  },
  mounted() {
  },
  methods: {
    // Private method to update the v-model
    updateModel(val) {
      if (val) {
        this.$refs["my-modal"].show();
      }
    },
  }
};
</script>
