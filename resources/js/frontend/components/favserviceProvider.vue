<template>
	<div class="col-lg-12 col-md-12 favserviceProvider">
		<div class="row favserviceProvider_structure">
			<div class="col-lg-12 col-md-12"></div>
			<div class="col-lg-12 col-md-12">
				<div class="row">
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
									<span><i class="fas fa-map-marker-alt"></i>
										<span class="wdt">{{ item.city}}, {{ item.state}} , {{ item.country }}</span>
									</span>
								</div>
							</div>
							<div class="col-md-12">
								<a class="view-portfolio" v-bind:href="apiDomain+/profile/+item.sp_slug" >{{ $t("message.view_full_portfolio") }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-md-12">
				<pagination :data="laravelData" :limit="3" @pagination-change-page="getResults" />
			</div>
		</div>
		<div id="quickmessage-model" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">{{ $t("message.send") }} {{ $t("message.messages") }} {{ $t("message.to") }} {{ sendmesssage.username}}</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="send-quickmessage">{{ $t("message.messages") }}</label>
							<textarea class="form-control" id="send-quickmessage"  v-model="sendmesssage.message" rows="3"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">{{ $t("message.close") }}</button>
						<button type="button" class="btn btn-default"  @click="sendchat">{{ $t("message.send") }}</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import {api} from "../../config";
	import LaravelVuePagination from './LaravelVuePagination.vue';

	export default {
		data(){
			return {
				what_error:"",
				place_error:"",
				no_record_error:"",
				initialDisplay:localStorage.skillname,
				initialValue:localStorage.skillid,
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
				},
				search:{
					skillid:null,
					skillname:null,
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
					page:1
				},
			}
		},
		created () {},
		
		mounted() {
		   this.getResults(1);},
		components: {
			'pagination': LaravelVuePagination
		},
		methods:{
			openchatmodel(user_to,user_name){
				this.sendmesssage.username =user_name;
				this.sendmesssage.user_to=user_to ;
				$('#quickmessage-model').modal('show');
			},
			sendchat(){
				let vm =this;
				axios.post(Laravel.siteUrl + '/sendQuickMessage/'+vm.sendmesssage.user_to, {
					message: vm.sendmesssage.message,
				})
				.then(function (response) {
					if(response.status===200){
						alert("message Send Successfully");
						$('#quickmessage-model').modal('hide');
						vm.sendmesssage.message ="";
					}
				})
				.catch(function (error) {
				   window.location.replace(Laravel.siteUrl + '/login');
				});
			},
			getResults (page) {
				if (!page) {
					page = 1;
				}
				this.search.page=page;
				let vm = this;
				axios.post(api.favsp ,this.search ).then(response => {
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
				})
				.catch(err => {});
			},
		},
	}
</script>