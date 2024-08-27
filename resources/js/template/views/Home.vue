<template>
  <div class="container full-height">
    <div class="row justify-content-center">
      <main class="col-md-5 position-relative zindex-1 py-5">
        <router-link to="/" class="panel-logo"></router-link>
        <div class="login-box">
          <div class="login-box-title">پرتال شرکت</div>
          <div class="login-box-body">
              <h1>باشه وارد شدی !!!</h1>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: "DashboardPortal",

  beforeCreate () {
    if (!this.$store.getters.isAuthenticated) {
      this.$router.push('/login')
    }else{
      if(this.$store.getters.isType != "client"){
        this.$store.dispatch('logout');
        this.$router.push('/login')
      }
    }
  },
  computed: {
  }
};
</script>