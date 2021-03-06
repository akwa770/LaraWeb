
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform';

import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = toast;

window.Fire = new Vue();

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})


let routes = [
    { path: '/', component: require('./components/front/Blog.vue').default},
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/posts', component: require('./components/Posts.vue').default },
    { path: '/single-post', component: require('./components/front/SinglePost.vue').default },
    { path: '/blog', component: require('./components/front/Blog.vue').default, props: { id: ''}},
    { path: '/blog/post/:id', component: require('./components/front/SinglePost.vue').default },//ניסיון
    { path: '*', component: require('./components/404.vue').default }
  ]


const router = new VueRouter({
  // mode: 'history',
  // base: __dirname,
  routes // short for `routes: routes`
})

// Filters
Vue.filter('upperCase', text =>  text.charAt(0).toUpperCase() + text.slice(1));
Vue.filter('myDate', date =>  moment(date).format('MMMM Do YYYY'));
Vue.filter('truncate', value => {
  if(value.length > 20){
    value = value.substring(0, 20) + '...';
  }
  return value

});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('slider', require('./components/partials/Slider.vue').default);
Vue.component('header-image', require('./components/partials/HeaderImage.vue').default);
Vue.component('not-found', require('./components/404.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
      search: ''
    },
    methods:{
      searchit:_.debounce(()=>{
        
        Fire.$emit('searching');
      }, 1000),
      printMe(){
        window.print();
      }
      
    }
});
