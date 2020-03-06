<template>
	<div class="homesearch">
		<div class="container">
			<div class="">
				<div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
					<div class="row">
						<div class="col-md-6 col-12 Pdng">
							<multiselect v-model="value" tag-position="bottom" tag-placeholder="Add this as new tag" placeholder="What (plumber,painter,...)" label="name" track-by="name" :options="options" :multiple="true" :taggable="true" :hideSelected="true" @tag="addTag"></multiselect>
							<span class="what_error">{{ what_error }}</span>
						</div>
						<div class="col-md-4 col-8 Pdng1">
							<input ref="WhereAutocomplete"
							placeholder="where"
							class="form-control"
							type="text"
							v-model="search.where"
							/>
							<span class="place_error">{{ place_error }}</span>
						</div>
						<div class="col-md-2 col-4 sr-btn">
							<button class="search-btn" type="button" @click.prevent="searchresult()" >
							<i class="seach-icon fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="main_structure">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-md-4 order-2 order-md-1">
						<div class="row">
							<a class="add-a" :href="ads_banner_link"><img class="sidebar-img" v-bind:src="ads_banner_image"></a>
						</div>
					</div>
					<div class="col-lg-9 col-md-8 order-1 order-md-2">
						<div class="row">
							<div class="col-lg-12">
								<div class="serch_sorting_div d-none d-md-block">
									<p class="sort_title">Sort By</p>
									<span :class="{ active : active_el == 'asc_price' }" @click.prevent="onClick_sort('asc_price')">Low to High Price</span>
									<span :class="{ active : active_el == 'desc_price' }" @click.prevent="onClick_sort('desc_price')">High to Low Price</span>
									<span :class="{ active : active_el == 'asc_rating' }" @click.prevent="onClick_sort('asc_rating')">Low to High Rating</span>
									<span :class="{ active : active_el == 'desc_rating' }" @click.prevent="onClick_sort('desc_rating')">High to Low Rating</span>
								</div>
								<div class="serch_sorting_div form-group d-sm-block d-md-none">
									<label>Sort By: </label>
									<select name="" class="order-by-select" @change="onClick_sort($event.target.value)">
										<option value="asc_price" :selected="active_el == 'asc_price'">Low to High Price</option>
										<option value="desc_price" :selected="active_el == 'desc_price'">High to Low Price</option>
										<option value="asc_rating" :selected="active_el == 'asc_rating'">Low to High Rating</option>
										<option value="desc_rating" :selected="active_el == 'desc_rating'">High to Low Rating</option>
									</select>
								</div>
							</div>
							<div class="col-md-12" v-if="no_record_error">
								<h5 class="no_record_error alert  text-center" v-html="no_record_error" ></h5>
							</div>
							<div class="col-lg-6 col-md-12 profile-view" v-for="(item, index) in laravelData.data" >
								<div class="row boxx">
									<div class="col-md-4">
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="set-profile">
														<img class="rounded-img" v-bind:src="item.sp_image">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="five-stars">
												<span v-for="index2 in 5" :key="index2">
													<i class="star fas fa-star" v-if="index2 <= item.rating"></i>
													<i class="star fas fa-star star-white" v-else></i>
												</span>
											</div>
											<div class="col-md-12">
												<div class="row">
													<div class="settting">
														<ul class="sp_skills_images">
															<li v-for="(sp_skill_img, index) in item.sp_skill_images">
																<img v-bind:src="sp_skill_img" width="20px">
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-8">
										<span class="sp_name"> {{ item.sp_name }} </span>
										<span v-if="item.isOnline" class="text-success">
											<img src="/img/check-mark-icon.png" class="online-image">
										</span>
										<span v-else class="login_time 2222" >
											<span class="time">{{ item.sp_last_login}}</span>
										</span>
										<div class="social-set">
											<i class="fas fa-phone"></i>
											<button v-if="item.able_to_send_message"  @click ="openchatmodel(item.user_id,item.sp_name)"><i class="far fa-comment"></i></button>
											<i class="fas fa-file"></i>
										</div>
										<div class="detail-set">
											<span>{{ item.sp_skill_show_price }} / <span class="dlr">{{ item.final_price}} {{ item.currency}}</span> <span class="dlr" v-if="item.sp_skill_si_offer"><strike>{{ item.normal_price}} {{ item.currency}}</strike></span></span>
											<span><i class="fas fa-map-marker-alt"></i>
												<span class="wdt">{{ item.city}}, {{ item.state}} , {{ item.country }}</span>
											</span>
											<span v-if="item.experience"><i class="fas fa-briefcase"></i><span class="wdt"> {{ item.experience }} years experience</span></span>
											<span class="no-experience" v-else><i class="fas fa-briefcase"></i><span class="wdt"> 0 years experience</span></span>
										</div>
									</div>
									<div class="col-md-12">
										<a class="view-portfolio" v-bind:href="apiDomain+/profile/+item.sp_slug" >{{ $t("message.view_full_portfolio") }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<pagination :data="laravelData" :limit="3" @pagination-change-page="getResults" />
		</div>
		<div id="quickmessage-model" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Send Message  to {{ sendmesssage.username}}</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="send-quickmessage">Message</label>
							<textarea class="form-control" id="send-quickmessage"  v-model="sendmesssage.message" rows="3"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default"  @click="sendchat">Send</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Autocomplete from 'vuejs-auto-complete'
	import Multiselect from 'vue-multiselect'
	import {api} from "../../config";
	import LaravelVuePagination from './LaravelVuePagination.vue';
	const MODAL_WIDTH = 656
	export default {
		data(){
			return {
				ads_banner_link:"",
				ads_banner_image:"",
				what_error:"",
				place_error:"",
				value: JSON.parse(localStorage.skillid),
				options: [],
				active_el:'asc_price',
				no_record_error:"",
				modalWidth: MODAL_WIDTH,
				initialValue:localStorage.skillid,
				search:{
					skillid:null,
					where:null,
					oldwhere:'',
					street_number:null,
					route:null,
					locality:null, // city
					administrative_area_level_1:null, // state
					country:null,
					postal_code:null,
					lng:null,
					lat:null,
					page:1,
					sort_by:'',
				},
				componentForm : {
					street_number: 'short_name',
					route: 'long_name',
					locality: 'long_name',
					administrative_area_level_1: 'long_name',
					country: 'long_name',
					postal_code: 'short_name'
				},
				laravelData: {
					data: null
				},
				laravelResourceData: {},
				apiDomain:Laravel.siteUrl,
				sendmesssage : {
					user_to :'',
					message : '',
					username : '',
				}
			}
		},
		created () {
			this.modalWidth = window.innerWidth < MODAL_WIDTH
			  ? MODAL_WIDTH / 2
			  : MODAL_WIDTH;
			axios.get(api.allskill).then(response => {
				this.options = response.data.skills;
			}).catch(e => {
			  this.errors.push(e)
			});
		},
		mounted() {
			if(this.search == undefined){
				window.location = "/";
			}
			this.getadsbanner();
			this.search.skillid = localStorage.skillid ? localStorage.skillid : '';
			this.search.where = localStorage.where ? localStorage.where : '';
			this.search.sort_by = localStorage.sort_by ? localStorage.sort_by : '';
			this.search.oldwhere = localStorage.oldwhere ? localStorage.oldwhere : '';
			this.search.street_number = localStorage.street_number ? localStorage.street_number : '';
			this.search.route = localStorage.route ? localStorage.route : '';
			this.search.locality = localStorage.locality ? localStorage.locality : '';
			this.search.administrative_area_level_1 = localStorage.administrative_area_level_1 ? localStorage.administrative_area_level_1 : '';
			this.search.country = localStorage.country ? localStorage.country : '';
			this.search.postal_code = localStorage.postal_code ? localStorage.postal_code : '';
			this.search.lng = localStorage.lng ? localStorage.lng : '';
			this.search.lat = localStorage.lat ? localStorage.lat : '';
			let vm = this;
			setTimeout(function(){
				vm.autocomplete = new google.maps.places.Autocomplete(
					(vm.$refs.WhereAutocomplete),
					{types: ['geocode']}
				);
				vm.autocomplete.addListener('place_changed', () => {
					let place = vm.autocomplete.getPlace();
					let ac = place.address_components;
					let lat = place.geometry.location.lat();
					let lon = place.geometry.location.lng();
				  
					vm.search.lat = lat;
					vm.search.lng = lon;
					let city = ac[0]["short_name"]; 
					vm.search.street_number = null;
					vm.search.route = null;
					vm.search.locality = null;
					vm.search.administrative_area_level_1 = null;
					vm.search.country = null;
					vm.search.postal_code = null;
					vm.search.lng = null;
					vm.search.lat = null;
					for (var i = 0; i < place.address_components.length; i++) {
						var addressType = place.address_components[i].types[0];
						if(addressType=='colloquial_area')
							var addressType = place.address_components[i].types[1];
						if (vm.componentForm[addressType]) {
							var val = place.address_components[i][vm.componentForm[addressType]];
							vm.search[addressType] =val;
						}
					}
					let where=[];
					let iii  = 0;
					if(vm.search.locality){
						where[iii++] = vm.search.locality;
					}
					if(vm.search.administrative_area_level_1){
						where[iii++] = vm.search.administrative_area_level_1;
					}
					if(vm.search.country){
						where[iii++] = vm.search.country;
					}
					vm.place_error ="";
					vm.search.where = where.join();
					vm.search.sort_by = sort_by.join();
					vm.search.oldwhere = where.join();
				});
			}, 1000);
			setTimeout(function(){
				vm.getResults();
			}, 500);
		},
		components: {
			Autocomplete,
			Multiselect,
			'pagination': LaravelVuePagination
		},
		methods:{
			onClick_sort(value_sort) {
				this.active_el = value_sort;
				this.search.sort_by = value_sort;
				this.searchresult();
			},
			addTag (newTag) {
				const tag = {
					name: newTag
				}
				this.options.push(tag)
				this.value.push(tag)
			},
			getadsbanner(){
				let vm =this;
				axios.get(Laravel.siteUrl + '/getAdsBanner/search/left').then(response => {
					if(response.data.advtisement.image)
						vm.ads_banner_image="/addvs/"+response.data.advtisement.image;
					if(response.data.advtisement.link)
						if(response.data.advtisement.link.search("://") > -1){
							vm.ads_banner_link=response.data.advtisement.link;
						} else {
							vm.ads_banner_link="http://"+response.data.advtisement.link;
						}
				});
			},
			openchatmodel(user_to,user_name){
				this.sendmesssage.username =user_name;
				this.sendmesssage.user_to=user_to ;
				this.$modal.show('model-quickmessage', {
					show: this.canBeShown
				})
				$('#quickmessage-model').modal('show');
			},
			sendchat(){
				let vm =this;
				axios.post(Laravel.siteUrl + '/sendQuickMessage/'+vm.sendmesssage.user_to, {
					message: vm.sendmesssage.message,
				}).then(function (response) {
					if(response.status===200){
						alert("message Send Successfully");
						$('#quickmessage-model').modal('hide');
					}
				}).catch(function (error) {
				   window.location.replace(Laravel.siteUrl + '/login');
				});
			},
			clearsearch(){
				localStorage.skillid = '';
				this.search.skillid='';
				this.getResults(1);
			},
			searchresult(){
				this.no_record_error="";
				this.search.skillid = JSON.stringify(this.value);
				this.what_error = '';
				this.place_error = "";
				if(this.value.length == 0){
					this.what_error = "Please Select what you loking";
					return false;
				}else{
					localStorage.skillid = this.search.skillid;
					localStorage.sort_by = this.search.sort_by;
					localStorage.where = this.search.where;
					localStorage.oldwhere = this.search.oldwhere;
					localStorage.street_number = this.search.street_number;
					localStorage.route = this.search.route;
					localStorage.locality = this.search.locality;
					localStorage.administrative_area_level_1 = this.search.administrative_area_level_1;
					localStorage.country = this.search.country;
					localStorage.postal_code = this.search.postal_code;
					localStorage.lng = this.search.lng;
					localStorage.lat = this.search.lat;
					this.getResults(1);
				}
			},
			getResults (page) {
				if (!page) {
					page = 1;
				}
				this.search.page=page;
				let vm = this;
				axios.post(api.searchsp, this.search).then(response => {
					vm.laravelData['data'] = response.data.result;
					if(response.data.setting.total > 0){
						let total  = response.data.setting.total;
						let perpage  = response.data.setting.perpage;
						vm.laravelData = {
							current_page: page,
							data: response.data.result,
							from: page,
							last_page: response.data.setting.total/perpage,
							next_page_url: page < response.data.setting.total/perpage ? vm.search.page=2 : null,
							per_page: 1,
							prev_page_url: page > 1 ? vm.search.page=1 : null,
							to: page + 1,
							total: response.data.setting.total
						};
					}else{
						vm.no_record_error = "Sorry we are not finding any records within mentioned skills and place <b>" + vm.search.where + "</b>";
					}
				}).catch(err => {});
			},
		},
		watch: {
			'search.where': function (val) {
				this.no_record_error="";
				if(val != this.search.oldwhere){
					this.search.street_number = "";
					this.search.route = "";
					this.search.locality = "";
					this.search.administrative_area_level_1 = "";
					this.search.country = "";
					this.search.postal_code = "";
					this.search.lng = "";
					this.search.lat = ""; 
				}
			},
		}
	}
</script>