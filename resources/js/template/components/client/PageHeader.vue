<template>
    <header class="page">
        <div class="row">
            <div class="col-6 right">
                <h4>{{title}}</h4>
            </div>
            <div class="col-6 left">
                <span class="date">{{getUserData['company']}}</span>
                <span class="time">{{getUserData['fname']}} {{getUserData['lname']}}</span>
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
      this.$router.push('/login')
    }else{
      if(this.$store.getters.isType != "client"){
        this.$store.dispatch('logout');
        this.$router.push('/login')
      }
    }
  },
  computed: {
    isType: function () {
      return this.$store.getters.isType
    },
    getUserData: function () {
      return this.$store.getters.user
    },
    calendar: function () {
      var date = new Date(this.$store.getters.getExpireTime)
      return moment(date.getFullYear()+"/"+date.getMonth()+"/"+date.getDate(), 'YYYY/M/D').format('jYYYY/jM/jD')
    },
    time: function () {
      var date = new Date(this.$store.getters.getExpireTime)
      return moment(date.getHours()+":"+date.getMinutes(), 'HH:mm').format('HH:mm')
    },
  }
};
</script>

