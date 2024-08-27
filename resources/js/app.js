/*
 * @Author: arvinlp 
 * @Date: 2020-01-10 20:11:39 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-09-05 23:04:09
 */

import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueAxios from 'vue-axios'
import axios from 'axios'
import store from './store'
import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import './registerServiceWorker'
import Multiselect from 'vue-multiselect'
import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
// import FarsiType from '../js/persianType';
import { abilitiesPlugin } from '@casl/vue'
import { Can } from '@casl/vue'
import Notifications from 'vue-notification';
import VueHtmlToPaper from 'vue-html-to-paper';
import VueBarcode from 'vue-barcode';
import VueCurrencyInput from 'vue-currency-input';
import MapIr from "mapir-vue";


import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);

// import BankCredit from './bankCredit';

const pluginOptions = {
  /* see config reference */
  globalOptions: { currency: {prefix:'', suffix:' ریال'}, locale: 'fa', precision: 0, }
}
Vue.use(VueCurrencyInput, pluginOptions)
Vue.component('barcode', VueBarcode);
Vue.component('date-picker', VuePersianDatetimePicker);
Vue.component('multiselect', Multiselect);
Vue.component('mapir',MapIr);
Vue.component('mapMarker',MapIr);
// Vue.component('mapir',MapIr);

// Vue.use(FarsiType)
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)
Vue.use(VueAxios, axios)
Vue.use(abilitiesPlugin, store.getters.ability)
Vue.component('Can', Can)
Vue.use(Notifications)


const printOptions = {
  name: '_blank',
  specs: [
    'fullscreen=no',
    'titlebar=no',
    'scrollbars=no'
  ],
  styles: [
    'http://localhost:8000/css/print-panel.css',
    // 'https://portal.cpapp.ir/css/print-panel.css',
  ]
}

Vue.use(VueHtmlToPaper, printOptions);

Vue.config.productionTip = false

Vue.prototype.$api = function (endpoint) {
  // return "http://localhost:8000/"+ endpoint

  return 'https://cpapp.iran.liara.run/'+ endpoint
  // return "https://api.cpapp.ir/" + endpoint
}
Vue.prototype.$asestUrl = function (endpoint) {
  // return "http://localhost:8000/assest/"+ endpoint
  return 'https://cpapp.iran.liara.run/'+ endpoint
  // return "https://api.cpapp.ir/" + endpoint
}

Vue.prototype.validateImageSquare = function (image) {

  var t = image.type.split('/').pop().toLowerCase();
  if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
    return -2;
  }
  // validation image resolution
  let img = new Image();
  img.src = window.URL.createObjectURL(image);
  var imgStatus = 0
  img.onload = function () {
    let width = img.naturalWidth,
      height = img.naturalHeight;

    window.URL.revokeObjectURL(img.src);
    if (width != height) {
      imgStatus = -1;
    } else {
      imgStatus = 1;
    }
  };
}

// set auth token if presen
const token = localStorage.getItem('token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
  // axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
}
Vue.prototype.setAuthorize = function () {
  return { Authorization: axios.defaults.headers.common['Authorization'] }
}


new Vue({
  router,
  store,
  render: h => h(App),

  created() {
    this.$http.interceptors.response.use(function (response) {
      return response
    }, function (err) {
      if (err.response.status === 401) {
        router.push('/401')
      }

      return Promise.reject(err)
    })
  }
}).$mount('#app')
