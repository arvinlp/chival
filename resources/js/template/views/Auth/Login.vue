<template>
  <div class="container full-height">
    <div class="row justify-content-center">
      <main class="col-md-5 position-relative zindex-1 py-5">
        <router-link to="/" class="panel-logo"></router-link>
        <div class="login-box">
          <div class="login-box-title">ورود به پرتال Chival</div>
          <login-form></login-form>
          <router-link to="/portal" class="btn btn-link py-2"><i class="fas fa-lock-open"></i> ورود به پرتال مدیریت</router-link>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import LoginForm from "../../components/auth/LoginForm.vue";

export default {
  name: "LoginPage",
  components: {
    LoginForm
  }
};
</script>