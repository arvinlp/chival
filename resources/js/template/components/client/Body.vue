<template>
  <main>
    <TopBar />
    <NavBar />
    <main class="container" style="padding-bottom:2rem">
      <router-view name="header" />
      <router-view />
    </main>
    <!-- -->
    <b-modal v-model="modalShow" centered>
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
        <div>
          <div class="text-right">
            <b-button size="sm" variant="success" @click="ok()">{{modalBtnOk}}</b-button>
          </div>
          <div>
            <b-button size="sm" variant="danger" @click="cancel()">{{modalBtnCancel}}</b-button>
          </div>
        </div>
      </template>
    </b-modal>
  </main>
</template>

<script>
import TopBar from "./menubar/TopBar";
import NavBar from "./menubar/NavBar";

export default {
  components: {
    TopBar,
    NavBar
  },

  data() {
    return {
      modalShow: false,
      modalTitle: "پایان شیفت کاری",
      modalContent:
        "کاربر محترم،<br>شیفت کاری شما به اتمام رسیده است.<br>در صورت نیاز به تمدید شیفت کاری خود به مدت یک ساعت گزینه مورد نظر را انتخاب کنید.",
      modalBtnOk: "تمدید شیفت کاری",
      modalBtnCancel: "خروج از سیستم"
    };
  },

  beforeCreate() {
    if (!this.$store.getters.isAuthenticated) {
      this.$router.push("/login");
    } else {
      if (this.$store.getters.isType != "client") {
        this.$store.dispatch("logout");
        this.$router.push("/login");
      }
    }
  },
  created() {
    this.$http.interceptors.response.use(
      function(response) {
        if (response.status === 250) {
          this.modalShow = true;
        }
        return response;
      },
      function(err) {
        return Promise.reject(err);
      }
    );
  }
};
</script>

