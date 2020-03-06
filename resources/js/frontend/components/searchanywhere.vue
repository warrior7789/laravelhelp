<template>
	<div class="homesearch">
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
					<span class="place_error error">{{ place_error }}</span>
				</div>
				<div class="col-md-2 col-4 sr-btn">
					<button class="search-btn" type="button" @click.prevent="searchresult()" >{{ $t("") }}
					<i class="seach-icon fas fa-search"></i></button>
				</div>
			</div>
		</div>
		<div class="col-md-8 offset-md-2" v-if="no_record_error">
			<h5 class="no_record_error alert" v-html="no_record_error" ></h5>
		</div>
	</div>
</template>

<script>
	import Autocomplete from 'vuejs-auto-complete'
	import Multiselect from 'vue-multiselect'
	import {api} from "../../config";

	export default {
		data(){
			return {
				what_error:"",
				place_error:"",
				value: [],
				options: [],
				no_record_error:"",
				initialValue:localStorage.skillid,
				search:{
					skillid:'',
					where:'',
					oldwhere:'',
					street_number:'',
					route:'',
					locality:'', // city
					administrative_area_level_1:'', // state
					country:'',
					postal_code:'',
					lng:'',
					lat:'',
				},
				componentForm : {
					street_number: 'short_name',
					route: 'long_name',
					locality: 'long_name',
					administrative_area_level_1: 'long_name',
					country: 'long_name',
					postal_code: 'short_name'
				},
				apiDomain:api.apiDomain
			}
		},
		created() {
			axios.get(api.allskill).then(response => {
				this.options = response.data.skills;
			}).catch(e => {
				this.errors.push(e)
			})
		},
		mounted() {
			this.search.skillid = '';
			this.search.where = '';
			this.search.oldwhere = '';
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
					vm.search.where = where.join();
					vm.search.oldwhere = where.join();
				});
			}, 2000);

		},
		components: {
			Autocomplete,
			Multiselect,
		},
		methods:{
			addTag (newTag) {
				const tag = {
					name: newTag
				}
				this.options.push(tag)
				this.value.push(tag)
			},
			searchresult(){
				this.no_record_error="";
				this.search.skillid = JSON.stringify(this.value);
				this.what_error = '';
				this.place_error = "";
				if(this.value.length == 0){
					this.what_error = "Please Select what you loking";
					return false;
				}
				else{
					this.search.oldwhere = this.search.where ;
					localStorage.skillid = this.search.skillid;
					localStorage.where = this.search.where ;
					localStorage.oldwhere = this.search.oldwhere ;
					localStorage.street_number = this.search.street_number;
					localStorage.route = this.search.route;
					localStorage.locality = this.search.locality;
					localStorage.administrative_area_level_1 = this.search.administrative_area_level_1;
					localStorage.country = this.search.country;
					localStorage.postal_code = this.search.postal_code;
					localStorage.lng = this.search.lng;
					localStorage.lat = this.search.lat;
					let vm = this;
					axios.post(api.searchsp, this.search).then(response => {
						if(response.data.setting.total > 0){
							window.location.replace('/search');
						}else{
							vm.no_record_error = "Sorry we are not finding any records within mentioned skills and place <b>" + vm.search.where + "</b>";
						}                    
					}).catch(err => {});            
				}
			},
			clearsearch(){
				localStorage.skillid = '';                
				this.search.skillid='';
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