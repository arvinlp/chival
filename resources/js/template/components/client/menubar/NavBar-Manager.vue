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
            <router-link :to="{name: 'manager-dashboard'}" class="nav-link">
              <i class="fas fa-tachometer-alt fa-2x"></i>
              <br />داشبورد
            </router-link>
          </li>
          <dropdown>
            <template slot="button">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-taxi fa-2x"></i>
              <br />ناوگان و رانندگان
              </a>
            </template>
            <template slot="dropdown">
              <router-link :to="{name: 'client-drivers'}" class="dropdown-item">رانندگان</router-link>
              <router-link :to="{name: 'client-vehicles'}" class="dropdown-item">ناوگان</router-link>
            </template>
          </dropdown>
          <dropdown>
            <template slot="button">
              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ticket-alt fa-2x"></i>
              <br />فروش بیلط
              </a>
            </template>
            <template slot="dropdown">
              <router-link :to="{name: 'client-ticket'}" class="dropdown-item">فروش بیلط</router-link>
              <router-link :to="{name: 'client-ticket-add'}" class="dropdown-item">فروش بیلط و افزودن به لیست</router-link>
            </template>
          </dropdown>
          <li class="nav-item">
            <router-link :to="{name: 'client-drivers-waiting-list'}" class="nav-link">
              <i class="fas fa-ticket-alt fa-2x"></i>
              <br />لیست نوبت رانندگان</router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name: 'client-exclusives'}" class="nav-link">
              <i class="fas fa-taxi fa-2x"></i>
              <br />دربستی
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{name: 'client-record-tracking'}" class="nav-link">
              <i class="fas fa-file-contract fa-2x"></i>
              <br />صدور و چاپ صورت وضعیت</router-link>
          </li>
          <dropdown>
            <template slot="button">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fas fa-user-cog fa-2x"></i>
                <br />پرسنل
              </a>
            </template>
            <template slot="dropdown">
              <router-link :to="{name: 'client-user-new'}" class="dropdown-item">کارمند جدید</router-link>
              <router-link :to="{name: 'client-users'}" class="dropdown-item">لیست پرسنل</router-link>
              <router-link :to="{name: 'client-users'}" class="dropdown-item">پیام های پرسنل</router-link>
              <router-link :to="{name: 'client-work-times'}" class="dropdown-item">شیفت کاری پرسنل</router-link>
            </template>
          </dropdown>
          <dropdown>
            <template slot="button">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fas fa-chart-line fa-2x"></i>
                <br />گزارشات
              </a>
            </template>
            <template slot="dropdown">
              <router-link :to="{name: 'client-user-new'}" class="dropdown-item">سفرها</router-link>
              <router-link :to="{name: 'client-users'}" class="dropdown-item">مالی</router-link>
              <router-link :to="{name: 'client-users'}" class="dropdown-item">ناوگان</router-link>
              <router-link :to="{name: 'client-work-times'}" class="dropdown-item">رانندگان</router-link>
              <router-link :to="{name: 'client-record-transfer'}" class="dropdown-item">لیست انتقال ها</router-link>
            </template>
          </dropdown>
          <dropdown>
            <template slot="button">
              <a
                href="#"
                class="nav-link dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="fas fa-cog fa-2x"></i>
                <br />تنظیمات
              </a>
            </template>
            <template slot="dropdown">
              <router-link :to="{name: 'client-partnears'}" class="dropdown-item">شرکت های همکار</router-link>
              <router-link :to="{name: 'client-routes'}" class="dropdown-item">مسیرها و تعرفه ها</router-link>
              <router-link :to="{name: 'client-record-transfer-new'}" class="dropdown-item">انتقال به کاربر دیگر</router-link>
              <router-link :to="{name: 'client-setting'}" class="dropdown-item">تنظیمات پایه سیستم</router-link>
              <router-link :to="{name: 'client-setting-travel'}" class="dropdown-item">تنظیمات سفر</router-link>
              <router-link :to="{name: 'client-users'}" class="dropdown-item">ماژول ها</router-link>
              <router-link :to="{name: 'client-work-times'}" class="dropdown-item">اعتبار</router-link>
              <router-link :to="{name: 'client-passengers'}" class="dropdown-item">مسافران</router-link>
              <router-link :to="{name: 'client-passengers-waiting-list'}" class="dropdown-item">لیست انتظار مسافران</router-link>
              <router-link :to="{name: 'client-passengers'}" class="dropdown-item">تنظیمات لیست نوبت</router-link>
              <router-link :to="{name: 'client-records'}" class="dropdown-item">لیست صورت وضعیت ها</router-link>
            </template>
          </dropdown>
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
      level: this.$store.getters.isLevel
    };
  },
  components: {
    Dropdown
  },
  computed: {}
};
</script>

