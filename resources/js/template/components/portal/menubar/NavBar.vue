<template>
<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            نمایش در نسخه موبایل غیر فعال می باشد
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <router-link to="/portal/" class="nav-link">
                        <i class="fas fa-tachometer-alt fa-2x"></i><br>داشبورد
                    </router-link>
                </li>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-users fa-2x"></i><br>پرسنل
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/users/new" class="dropdown-item">کارمند جدید</router-link>
                        <router-link to="/portal/users" class="dropdown-item">لیست پرسنل</router-link>
                        <router-link to="/portal/users/logs" class="dropdown-item">تاریخچه پرسنل</router-link>
                        <router-link to="/portal/users/messages" class="dropdown-item">پیام های پرسنل</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-building fa-2x"></i><br>شرکت ها
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/companies/new" class="dropdown-item">شرکت جدید</router-link>
                        <router-link to="/portal/companies" class="dropdown-item">لیست شرکت ها</router-link>
                        <router-link to="/portal/storges" class="dropdown-item">لیست انبار ها</router-link>
                        <router-link to="/portal/vehicles" class="dropdown-item">لیست وسایل نقلیه</router-link>
                        <router-link to="/portal/drivers" class="dropdown-item">لیست راننده ها</router-link>
                        <router-link to="/portal/contracts" class="dropdown-item">لیست قراردادها</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-cog fa-2x"></i><br>اطلاعات پایه
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/destinations" class="dropdown-item">لیست مقاصد</router-link>
                        <router-link to="/portal/vehicle-types" class="dropdown-item">وسایل نقلیه - نوع</router-link>
                        <router-link to="/portal/vehicle-brand" class="dropdown-item">وسایل نقلیه - برند</router-link>
                        <router-link to="/portal/insurance-companies" class="dropdown-item">شرکت های بیمه</router-link>
                        <router-link to="/portal/travel-types" class="dropdown-item">نوع سفر</router-link>
                        <router-link to="/portal/banks" class="dropdown-item">بانک ها</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-store fa-2x"></i><br>ماژول و اعتبارات
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/modules" class="dropdown-item">لیست ماژول ها</router-link>
                        <router-link to="/portal/credits" class="dropdown-item">لیست اعتبار ها</router-link>
                        <router-link to="/portal/payments" class="dropdown-item">لیست پرداخت ها</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-universal-access fa-2x"></i><br>دسترسی ها
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/roles/new" class="dropdown-item">دسترسی جدید</router-link>
                        <router-link to="/portal/work-times/new" class="dropdown-item">شیف کاری جدید</router-link>
                        <router-link to="/portal/roles" class="dropdown-item">لیست دسترسی ها</router-link>
                        <router-link to="/portal/work-times" class="dropdown-item">لیست شیف های کاری</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-headphones fa-2x"></i><br>پشتیبانی
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/supports/new" class="dropdown-item">ثبت تیکت جدید</router-link>
                        <router-link to="/portal/supports" class="dropdown-item">درخواست های پشتیبانی</router-link>
                        <router-link to="/portal/feedbacks" class="dropdown-item">بازخوردها</router-link>
                        <router-link to="/portal/support-departeman" class="dropdown-item">دپارتمان های پشتیبانی</router-link>
                    </template>
                </dropdown>
                <dropdown>
                    <template slot="button">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-tachometer-alt fa-2x"></i><br>مدیریت سیستم
                        </a>
                    </template>
                    <template slot="dropdown">
                        <router-link to="/portal/setting" class="dropdown-item">تنظیمات پایه سیستم</router-link>
                        <router-link to="/portal/setting/sms" class="dropdown-item">پنل پیامک</router-link>
                        <router-link to="/portal/setting/payments" class="dropdown-item">درگاه های پرداخت</router-link>
                        <router-link to="/portal/setting/web-service-road" class="dropdown-item">تنظیمات وب سرویس راه داری</router-link>
                    </template>
                </dropdown>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
import Dropdown from '../../Dropdown.vue'
export default {
  name: "AdminNavBar",

  components: {
    Dropdown
  },
  beforeCreate () {
  },
  computed: {
  }
};
</script>

