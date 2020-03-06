import '../bootstrap';
import '../plugins';
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import router from './router';
import {language} from '../config';
//import VueJsModal from 'vue-js-modal'
import messages from './lang/en.json';
import VueChatScroll from 'vue-chat-scroll'
import Lightbox from 'vue-pure-lightbox'

window.Vue = Vue;

Vue.use(VueChatScroll)
Vue.use(Lightbox)

Vue.component('homesearch-component', require('./components/homesearch.vue'));
//Vue.component('pagination', require('laravel-vue-pagination'));

const VueUploadComponent = require('vue-upload-component');
Vue.component('file-upload', VueUploadComponent);

Vue.component('PrivateChat', require('./components/PrivateChat.vue'));
// Vue.component('searchanywhere', require('./components/searchanywhere.vue'));
// Vue.component('favsp', require('./components/favserviceProvider.vue'));

// Vue.use(VueJsModal, {
// 	dialog: true,
// 	dynamic: true,
// });

const i18n = new VueI18n({
	locale: 'sv', // set locale
	messages : messages
})

axios.interceptors.request.use(config => {
		config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
		config.headers['X-Requested-With'] = 'XMLHttpRequest';
		return config;
}, error => {
		return Promise.reject(error);
});

const app = new Vue({
	i18n,
	router,
}).$mount('#app');

setTimeout(function(){
	axios.get(Laravel.siteUrl + '/notification').then(response => {
		if(response.data.data.total_notification > 0){
			$(".notitifation").html(response.data.data.total_total_notification_html);
			$(".notitifation_boxmenu").html(response.data.data.html);
		}else{
			$(".notitifation_boxmenu").html(response.data.data.html);
		}
	});
}, 1000);
$(document).on("click", ".check_notification", function(){
	axios.get(Laravel.siteUrl + '/notification').then(response => {
		if(response.data.data.total_notification > 0){
			$(".notitifation").html(response.data.data.total_total_notification_html);
			$(".notitifation_boxmenu").html(response.data.data.html);
		}else{
			$(".notitifation").html("");
			$(".notitifation_boxmenu").html(response.data.data.html);
		}
	});
});