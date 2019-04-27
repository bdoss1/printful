/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
const Vue = window.Vue = require('vue')
// import Vue from 'vue';
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default)
Vue.component('Quiz', require('./components/user/Quiz.vue'));
Vue.component('Result', require('./components/user/Result.vue'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueResource from 'vue-resource'
import VueSwal from 'vue-swal'
import VueForm from 'vue-form'
import ElementUI from 'element-ui'
import VueMoment from 'vue-moment'
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css'
import VueRouter from 'vue-router'

Vue.use(ElementUI, { locale })
Vue.use(VueResource)
Vue.use(VueRouter)
Vue.use(VueMoment)
Vue.use(VueSwal)

Vue.use(VueForm, {
  inputClasses: {
    valid: 'form-control-success',
    invalid: 'form-control-danger'
  },
  validators: {
    matches: function(value, attrValue) {
      if (!attrValue) {
        return true
      }
      return value === attrValue
    },
    'password-strength': function(value) {
      // return /(?=^.{6,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/.test(value);
      return /(?=^.{6,}$)(?=.*[a-z]).*$/.test(value)
    }
  }
})

require('./vueMixins')
require('./vueFilters')

import { routes } from './site/routes'

const router = new VueRouter({
  mode: 'history',
  routes
})

new Vue({
  el: '#app',
  router
})
