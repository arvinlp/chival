<template>
  <div class="container full-height">
    <div class="row justify-content-center">
      <main class="col-md-5 position-relative zindex-1 py-5">
        <router-link to="/portal" class="panel-logo"></router-link>
        <div class="login-box">
          <div class="login-box-title">ورود به پرتال مدیریت Chival</div>
          <login-form></login-form>
          <router-link to="/login" class="btn btn-link py-2">ورود به پرتال کاربران</router-link>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import LoginForm from "../../components/auth/LoginFormPortal.vue";

export default {
  name: "LoginPortalPage",
  components: {
    LoginForm
  }
};
</script>