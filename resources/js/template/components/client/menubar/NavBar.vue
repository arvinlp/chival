<template>
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarMain"
        aria-controls="navbarMain"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >نمایش در نسخه موبایل غیر فعال می باشد</button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link to="/" class="nav-link">
              <i class="fas fa-tachometer-alt fa-2x"></i><br />داشبورد
            </router-link>
          </li>
          <li class="nav-item" v-if="level < 99">
            <router-link to="/" class="nav-link">
              <i class="fas fa-tachometer-alt fa-2x"></i><br />مدیر {{level}}
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import Dropdown from "../../Dropdown.vue";
export default {
    data() {
        return {
            level:this.$store.getters.isLevel
        }
    },
  components: {
    Dropdown
  },
  computed: {}
};
</script>

