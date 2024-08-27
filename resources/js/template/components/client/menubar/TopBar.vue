<template>
<div class="container top-menu">
    <div class="row">
        <div class="col-8 text-right">
            <router-link to="/"><span class="logo">s</span></router-link>
        </div>
        <div class="col-4">
            <ul>
                <li>
                    <a v-b-toggle.sidebar-user-info>
                        <span class="user"><i class="fa fa-user" aria-hidden="true"></i></span>
                    </a>
                </li>
                <li>
                    <router-link to="/supports">
                        <span class="support"><i class="fa fa-headphones" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/messages">
                        <span class="notification"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/feedbacks">
                        <span class="alarm"><i class="fa fa-bell" aria-hidden="true"></i></span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/logout">
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
  name: "ClientTopBar",

  beforeCreate () {
  },
  computed: {
  }
};
</script>

