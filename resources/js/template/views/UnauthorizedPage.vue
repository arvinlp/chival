<template>
  <div class="page-404 mb-5 mt-5 pt-5 pb-5 text-center">
    <h1 class="mb-5">401</h1>
    <p class="text-muted">شما سطح دسترسی مجاز به این بخش را ندارید.</p>
    <p>
      <router-link to="/" class="nav-link">&larr; برگشت به صفخه اصلی</router-link>
      <router-link :to="{name: 'logout'}" class="nav-link">&larr; صفحه ورود به پرتال</router-link>
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  created(){
    if(this.$store.getters.isAuthenticated){
      if (this.$store.getters.isType == "admin") {
        this.$router.push("/portal/401");
      }
      if(Date.now() >= parseInt(Date.parse(this.$store.getters.getExpireTime))){
        this.$store.dispatch("logout");
        this.$router.push("/login");
      }
    }
  }
};
</script> 