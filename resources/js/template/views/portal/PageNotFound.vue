<template>
  <div class="page-404 mb-5 mt-5 pt-5 pb-5 text-center">
    <h1 class="mb-5">404</h1>
    <p class="text-muted">صفحه مورد نظر یافت نشد</p>
    <p>
      <router-link to="/" class="nav-link">&larr; برگشت به صفخه اصلی</router-link>
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
      if (this.$store.getters.isType == "client") {
        this.$router.push("/404");
      }
    }
  }
};
</script>