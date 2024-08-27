<template>
  <form method="POST" @submit.prevent="login">
    <div class="alert alert-danger" :class="{'is-waiting': sending}" v-if="infoError">{{msg}}</div>
    <div class="py-2">
      <input type="username" v-model.trim="username" name="username" placeholder="نام کاربری خود را وارد کنید" class="form-control" tabindex="1" required autofocus autocomplete="username">
    </div>
    <div class="py-2">
      <input type="password" v-model.trim="password" name="password" placeholder="گذرواژه خود را وارد کنید" class="form-control" tabindex="2" required autocomplete="current-password">
    </div>
    <div class="py-2">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember" />
        <label class="form-check-label" for="remember">
          <span></span>
          مرابه خاطر بسپار
        </label>
      </div>
    </div>
    <button class="btn btn-login py-2" tabindex="3" :disabled="sending">ورود</button>
    <router-link to="/password" class="btn btn-link py-2">
      <i class="fa fa-lock" aria-hidden="true"></i>گذرواژه خود را فراموش کرده اید ؟
    </router-link>
  </form>
</template>

<script>
export default {
  name: "LoginPortal",

  data() {
    return {
      sending: false,
      infoError: false,
      msg:null,
      username: "",
      password: ""
    };
  },

  methods: {
    login() {
      this.sending = true;
      this.infoError = false;
      this.msg = null

      this.$http
        .post(this.$api("api/v1/portal/login"), {
          username: this.username,
          password: this.password
        })
        .then(response => {
          if(response.data.status === 250){
            this.infoError = true;
            this.msg = "شیف کاری شما به اتمام رسیده است"
          }else{
            this.$store.dispatch("login", response.data);
            this.$http.defaults.headers.common["Authorization"] =
              "Bearer " + response.data.token;
            this.$router.push(this.$route.query.redirect || "/portal");
          }
        })
        .catch(response => {
          console.error(response)
          this.infoError = true;
          this.msg = "کاربری شما در سیستم پیدا نشد لطفا اطلاعات خود را بررسی کنید"
        })
        .finally(() => (this.sending = false));
    }
  }
};
</script>