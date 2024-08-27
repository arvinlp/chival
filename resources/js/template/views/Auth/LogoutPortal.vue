<template>
  <div></div>
</template>
<script>
export default {
  name: 'LogoutPortal',

  beforeCreate () {
    if (this.$store.getters.isAuthenticated) {
      this.$store.dispatch('logout');
      this.$router.push('/portal')
    } else {
      this.$router.push('/')
    }
  },

};
</script>
