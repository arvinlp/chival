<template>
  <form method="POST" @submit.prevent="register">
    <div class="py-2">
      <input type="mobile" v-model.trim="mobile" name="mobile" placeholder="تلفن همراه خود را وارد کنید" :class="['form-control', {'is-invalid': hasError('mobile') }]" tabindex="1" required autofocus/>
    </div>
    <div class="py-2">
      <input type="password" v-model.trim="password" name="password" placeholder="گذرواژه خود را وارد کنید" :class="['form-control', {'is-invalid': hasError('password') }]" tabindex="2" required/>
    </div>
    <div class="py-2">
      <input type="password_confirmation" v-model.trim="password_confirmation" name="password_confirmation" placeholder="گذرواژه خود را تکرار کنید" :class="['form-control', {'is-invalid': hasError('password_confirmation') }]" tabindex="2" required/>
    </div>
    <button class="btn btn-login py-2" tabindex="30" :disabled="sending">قوانین ارائه سرویس را خوانده ام و تایید می کنم</button>
    <router-link to="/login" class="btn btn-link py-2">
      <i class="fa fa-lock" aria-hidden="true"></i>ورود به پرتال
    </router-link>
  </form>
</template>
<script>
import formError from '../../../mixins/formError'

export default {

  name: 'RegisterForm',

  mixins: [formError],

  data () {
    return {
      sending: false,
      form: {
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },

  methods: {

    signup() {
      this.sending = true
      this.errors = {}

      this.$http.post(this.$api('/api/v1/register'), this.form)
      .then(response => {
        this.$store.dispatch('login', response.data)
        this.$http.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.api_token
        this.$router.push(this.$route.query.redirect || '/dashboard')
      })
      .catch(err => {
        this.errors = err.response.data
      })
      .finally(() => this.sending = false)
    }
  }
};
</script>

<style lang="less">
</style>
