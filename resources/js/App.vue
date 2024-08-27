<template>
  <div id="app">
    <router-view></router-view>
    <footer>مونه پردازان آریا - نسخه ۱.۰.۰</footer>
  </div>
</template>

<script>
export default {
  name: "App",

  computed: {
    isAuthenticated: function() {
      return this.$store.getters.isAuthenticated;
    },
  },
  methods: {
  }
};
</script>
