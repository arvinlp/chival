<template>
  <main>
    <TopBar />
    <NavBar />
    <main class="container" style="padding-bottom:2rem">
      <router-view name="header" />
      <router-view />
    </main>
    <!-- -->
    <b-sidebar
      id="sidebar-user-info"
      title="اطلاعات کاربر"
      bg-variant="dark"
      text-variant="cheval-main-color"
      shadow
    >
      <div class="px-3 py-2">
        <ul>
          <li v-if="getUserData['img']">
            <img :src="getUserData['img']" class="img-circle w-50" />
          </li>
          <li>{{getUserData['company']}}</li>
          <li>{{getUserData['fname']}} {{getUserData['lname']}}</li>
          <li>سطح کاربری : {{getUserData['role']}}</li>
          <li v-if="getUserData['note']">یادداشت : {{getUserData['note']}}</li>
          <li>
            پایان دسترسی شما برای این شیفت کاری به شرح زیر می باشد :
            <br />
            {{dateTime}}
          </li>
        </ul>
      </div>
    </b-sidebar>
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
import NavBar from "./menubar/NavBar-Manager";
var moment = require("moment-jalaali");

export default {
  components: {
    TopBar,
    NavBar
  },

  data() {
    return {
      errorData:[],

      dismissSecs: 5,
      dismissCountDown: 0,
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
  notifications: {
    showLoginError: {
      // You can have any name you want instead of 'showLoginError'
      title: "Login Failed",
      message: "Failed to authenticate",
      type: "error" // You also can use 'VueNotifications.types.error' instead of 'error'
    }
  },
  created() {
    if (!this.$store.getters.isAuthenticated) {
      this.$router.push("/login");
    } else {
      if (this.$store.getters.isType != "client") {
        this.$store.dispatch("logout");
        this.$router.push("/login");
      }
    }

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
  },
  computed: {
    dateTime: function() {
      try {
        var date = new Date(this.$store.getters.getExpireTime);
        let d = moment(
          date.getFullYear() + "/" + date.getMonth() + "/" + date.getDate(),
          "YYYY/M/D"
        ).format("jYYYY/jM/jD");
        if (date.getHours() == "00") {
          return "تا ساعت ۱۲ امشب دسترسی شما آزاد است، بعد از این زمان باید مجددا وارد سیستم شوید.";
        }
        let t = moment(
          date.getHours() + ":" + date.getMinutes(),
          "HH:mm"
        ).format("HH:mm");
        return d + " - " + t;
      } catch (Exception) {
        return "-";
      }
    },
    getUserData: function() {
      return this.$store.getters.user;
    },
    getChevalErrors: function() {
      console.error(this.$store.getters.cheval_error);
      return this.$store.getters.cheval_error;
    }
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    }
  }
};
</script>

