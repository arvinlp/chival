<template>
<section class="page">
  <div class="row">
    <CardProgress class="col-3" url="/portal" type="default" :value="100" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر سیستم</h5>
        <span>از 1 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="success" :value="50" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر فنی</h5>
        <span>از 2 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="danger" :value="20" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>پشتیبانی</h5>
        <span>از 5 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="primary" :value="10" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>مالی</h5>
        <span>از 10 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
  </div>
  <div class="row">
    <CardProgress class="col-3" url="/portal" type="success" :value="100" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر سیستم</h5>
        <span>از 1 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="danger" :value="50" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر فنی</h5>
        <span>از 2 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="primary" :value="20" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>پشتیبانی</h5>
        <span>از 5 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="default" :value="10" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>مالی</h5>
        <span>از 10 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
  </div>
  <div class="row">
    <CardProgress class="col-3" url="/portal" type="primary" :value="100" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر سیستم</h5>
        <span>از 1 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="danger" :value="50" :striped="false" :animated="true">
      <template slot="header">
        <h5>مدیر فنی</h5>
        <span>از 2 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="default" :value="20" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>پشتیبانی</h5>
        <span>از 5 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
    <CardProgress class="col-3" url="/portal" type="success" :value="10" :striped="false" :animated="true">
      <template slot="header">
        <h5><i class="fas fa-users"></i>مالی</h5>
        <span>از 10 کاربر</span>
        <h5 class="numbers">1</h5>
      </template>
    </CardProgress><!-- -->
  </div>
</section>
</template>

<script>
import Body from "../../components/portal/Body";
import CardProgress from "../../components/CardProgress";

export default {
  name: "DashboardPortal",

  data() {
    return {
    }
  },

  components: {
    Body,
    CardProgress,
  },

  computed: {
    isType: function () {
      return this.$store.getters.isType
    },
  },
  mounted () {
  },
  methods: {
  },
  created(){
    
  }
};
</script>

