<template>
<div class="container top-menu">
    <div class="row">
        <div class="col-8 text-right">
            <router-link to="/portal"><span class="logo">s</span></router-link>
        </div>
        <div class="col-4">
            <ul>
                <li>
                    <router-link to="/portal/supports">
                        <span class="support"><i class="fa fa-headphones" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/messages">
                        <span class="notification"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/feedbacks">
                        <span class="alarm"><i class="fa fa-bell" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/portal/logout">
                        <span class="logout"><i class="fa fa-power-off" aria-hidden="true"></i></span>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: "AdminTopBar",

  beforeCreate () {
  },
  computed: {
  }
};
</script>

