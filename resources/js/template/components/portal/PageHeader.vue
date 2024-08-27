<template>
    <header class="page">
        <div class="row">
            <div class="col-6 right">
                <h4>{{title}}</h4>
            </div>
            <div class="col-6 left">
                <span class="date">{{calendar}}</span>
                <span class="time">{{time}}</span>
            </div>
        </div>
    </header>
</template>

<script>
var moment = require('moment-jalaali');

export default {
  components: {
  },

  props:{
    title : String
  },
  
  beforeCreate () {
    if (!this.$store.getters.isAuthenticated) {
      this.$router.push('/portal/login')
    }else{
      if(this.$store.getters.isType != "admin"){
        // this.$store.dispatch('logout');
        // this.$router.push('/portal/login')
      }
    }
  },
  computed: {
    isType: function () {
      return this.$store.getters.isType
    },
    calendar: function () {
      return moment().format('jYYYY/jM/jD')
    },
    time: function () {
      return moment().format('HH:mm')
    }
  }
};
</script>

