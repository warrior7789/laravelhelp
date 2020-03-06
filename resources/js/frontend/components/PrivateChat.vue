<template>
	<div class="bodypart-msg">
		<div class="container h-100 inbox">
			<div class="col-md-12">
				<div class="row">
					<div id="sidecc" class="col-sm-12 col-md-5 col-lg-4 userlist ">
						<div class="searchbox-user">
							<div class="container">
								<div class="row">
									<i class="fa fa-search"></i>
									<input type="text" v-model="searchuser" :placeholder='$t("message.Search_user")'>
								</div>
							</div>
						</div>
						<div class="row contacts_card left-part">
							<div class="card-body contacts_body">
								<ul class="contacts">
									<li v-for="privsteMsg in friends" :class="{active:privsteMsg.id == selected}" @click="userclick(privsteMsg.id)">
										<div class="d-flex bd-highlight">
											<div class="img_cont">
												<img v-bind:src="privsteMsg.sp_image" class="rounded-circle user_img">
												<span :id="'user_online_id_'+privsteMsg.id">
													<span class="online_icon" v-if="privsteMsg.isOnline"></span>
												</span>
											</div>
											<div class="user_info check_notification">
												<h6>{{privsteMsg.name}}</h6>
												<h6>{{privsteMsg.email}}</h6>
											</div>
											<div>
												<span class="message_notification" :id="'get_live_message_id_'+privsteMsg.id"><span v-if="privsteMsg.unread_message">{{ privsteMsg.unread_message}}</span></span>
												<span :id="'get_live_message_from_'+privsteMsg.id+'_to_' +user.id"></span>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-7 col-lg-8 " id="privateMessageBox" v-if="users.length > 0">
						<div class="row card right-part">
							<div class="card-header msg_head">
								<div class="d-flex bd-highlight">
									<span class="mobile-back" @click="backchat" v-if="767 >= this.window.width " ><i class="fas fa-long-arrow-alt-left"></i></span>
									<div class="img_cont">
										<img v-bind:src="active_user_image" class="rounded-circle user_img">
										<span v-if="active_user_online" class="online_icon"></span>
										<span v-else class="online_icon affline_icon"></span>
									</div>
									<div class="user_info">
										<span>{{ active_user_name }}</span>
										<p>{{ total_message }} {{ $t("message.messages") }}</p>
										<span :class="'clear_all_type user_typing_id_'+selected" ></span>
									</div>
								</div>
								<span id="action_menu_btn" @click="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
								<div class="action_menu">
									<ul>
										<li v-if="active_user_is_sp ==1">
											<i class="fas fa-user-circle"></i>
											<a :href="active_user_profile_link"> {{ $t("message.view_profile") }}</a>
										</li>
										<li>
											<span @click="clearchat" ><i class="fas fa-users" ></i>{{ $t("message.clear_chat") }}</span>
										</li>
									</ul>
								</div>
							</div>
							<div class="card-body msg_card_body">
								<message-list :user="user" :all-messages="allMessages" :active_user_image="active_user_image"></message-list>
							</div>
							<div>
								<div class="floating-div">
									<picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" />
								</div>
							</div>
							<div class="card-footer">
								<div class="input-group">
									<div class="input-group-append">
										<file-upload
										:post-action="'/private-messages/'+activeFriend"
										ref='upload'
										v-model="files"
										@input-file="$refs.upload.active = true"
                                        @input-filter="inputFilter"
										:headers="{'X-CSRF-TOKEN': token}" >
										<span class="input-group-text attach_btn"><i class="fas fa-paperclip"></i></span>
										</file-upload>
									</div>
									<div class="input-group-append">
										<span @click="toggleEmo" class="input-group-text attach_btn"><i class="far fa-grin-beam"></i></span>
									</div>
									<textarea name="" class="form-control type_msg" :placeholder='$t("message.Type_message")' v-model="message" v-on:keyup="onTyping" ></textarea>
									<div class="input-group-append">
										<span class="input-group-text send_btn" @click="sendMessage"><i class="fas fa-location-arrow"></i></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div v-else class="col-sm-12 col-md-8 ">
						<div class="row">
							<div class="welcome_messsage" >
								<h1 class="title_one">{{ $t("message.welcome_to_helpii") }} {{ user.first_name}} {{ user.last_name}}</h1>
								<p class="title_two">
									{{ $t("message.no_conversation") }}
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import MessageList from './_message-list'
	import { Picker } from 'emoji-mart-vue'
    import Lightbox from 'vue-pure-lightbox'

	export default {
		props:['user'],
		components:{
			Picker,
			MessageList
		},
		data () {
			return {
				mobileheight:'auto',
				active_user_online:0,
				total_message:'',
				selected:'',
				searchuser:'',
				active_user_image:'',
				active_user_name:'',
				active_user_is_sp:0,
				active_user_profile_link:'',
				message:null,
				files:[],
				activeFriend:null,
				typingFriend:{},
				onlineFriends:[],
				allMessages:[],
				typingClock:null,
				emoStatus:false,
				users:[],
				token:document.head.querySelector('meta[name="csrf-token"]').content,
				loged_user:document.head.querySelector('meta[name="user-id"]').content,
				window: {
					width: 0,
					height: 0
				},
				sidebar_open:1
			}
		},
		computed:{
			friends(){
				return this.users.filter((user)=>{
					return user.id !==this.user.id;
				})
			}
		},
		watch:{
			files:{
				deep:true,
				handler(){
					let success=this.files[0].success;
						if(success){
						this.fetchMessages();
					}
				}
			},
			activeFriend(val){
				$(".clear_all_type").html("");
				$("#get_live_message_id_"+val).html("");
				this.selected =val;
				this.fetchMessages();
			},
			'$refs.upload'(val){},
			searchuser: function (val) { 
				if(val){
					this.users=[];
					axios.get('/SearchUsers/'+val).then(response => {
						this.users = response.data;
						if(this.friends.length>0){
							this.activeFriend=this.friends[0].id;
						}else{
							$(".title_two").html('No user Found');
						}
					});

				}else{
					axios.get('/getUsers/?page=1').then(response => {
						this.users = response.data;
						if(this.friends.length>0){
							this.activeFriend=this.friends[0].id;
						}
					});
				}
			},
		},
		methods:{
            inputFilter: function (newFile, oldFile, prevent) {                
              if (newFile) {
                // Filter non-image file
                // if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                //     alert('Invalid File');
                //   return prevent()
                // }

                if (/\.(php|sql)$/i.test(newFile.name)) {
                    alert(this.$i18n.t("message.invalid_file"));
                    return prevent()
                }
              }
            },
			userclick(user_id_click){
				this.activeFriend=user_id_click;
				if(767 > this.window.width){
					var effect = 'slide';
					var options = { direction: 'right' };
					var duration = 500;
					$('#privateMessageBox').toggle(effect, options, duration);
				}
			},
			opensidebar(){},
			backchat(){
				var effect = 'slide';
				var options = { direction: 'right' };
				var duration = 500;
				$('#privateMessageBox').toggle(effect, options, duration);
			},
			handleResize() {
				this.window.width = window.innerWidth;
				this.window.height = window.innerHeight;
				if(767 > this.window.width){
					this.mobileheight=this.window.height;
				}
			},
			clearchat(){
				let of_user = this.activeFriend;
				let loged_user = this.user.id;
				let vm =this;
				axios.get('/clearchat/'+this.activeFriend).then(response => {
					if(response.data.status)
						vm.fetchMessages();
				});
			},
			action_menu_btn(){
				$('.action_menu').toggle();
			},
			onTyping(){
				Echo.private('privatechat.'+this.activeFriend).whisper('typing',{
					user:this.user,
					message:this.message
				});
			},
			sendMessage(){
				if(!this.message){
					return alert('Please enter message');
				}
				if(!this.activeFriend){
					return alert('Please select friend');
				}
				var msg = this.message;
				this.message=null;
				axios.post('/private-messages/'+this.activeFriend, {message: msg}).then(response => {
					this.message=null;
                    this.allMessages.push(response.data.message);
                    this.total_message = this.total_message + 1;
                    setTimeout(this.scrollToEnd,150);
				});
			},
			fetchMessages() {
				if(!this.activeFriend){
					return alert('Please select friend');
				}
				axios.get('/private-messages/'+this.activeFriend).then(response => {
					this.allMessages = response.data.privateCommunication;
					this.active_user_name= response.data.user.first_name + " " + response.data.user.last_name ;
					this.active_user_image= response.data.user.imaged;
					this.total_message = response.data.other.total_message;
					this.active_user_online = response.data.other.is_online;
					if(response.data.other.is_sp){
						this.active_user_is_sp = response.data.other.is_sp;
						this.active_user_profile_link = response.data.other.profile_url;
					}
					$("#get_live_message_id_"+this.activeFriend).html("");
				});
			},
			unreadmessage(for_user){
				axios.get('/private-messages-count/'+this.user.id+'/'+for_user).then(response => {
					$("#get_live_message_id_"+for_user).html(response.data);
				});
			},
			makereadstatus(for_user){
				axios.get('/private-messages-read/'+this.user.id+'/'+for_user).then(response => {
					$("#get_live_message_id_"+for_user).html(response.data);
				});
			},
			fetchUsers() {
				axios.get('/getUsers').then(response => {
					this.users = response.data;
					if(this.friends.length>0){
						this.activeFriend=this.friends[0].id;
					}
				});
			},
			scrollToEnd(){
				document.getElementById('privateMessageBox').scrollTo(0,99999);
			},
			toggleEmo(){
				this.emoStatus= !this.emoStatus;
			},
			onInput(e){
				if(!e){
					return false;
				}
				if(!this.message){
					this.message=e.native;
				}else{
					this.message=this.message + e.native;
				}
				this.emoStatus=false;
			},
			onResponse(e){}
		},
		mounted(){},
		created(){
			window.addEventListener('resize', this.handleResize)
			this.handleResize();
			this.fetchUsers();
			Echo.join('plchat')
				.here((users) => {
					this.onlineFriends=users;
				})
				.joining((user) => {
					this.onlineFriends.push(user);
					$("#user_online_id_"+user.id).html("<span class='online_icon'></span>");
				})
				.leaving((user) => {
					this.onlineFriends.splice(this.onlineFriends.indexOf(user),1);
					$("#user_online_id_"+user.id).html("");
				});
			Echo.private('privatechat.'+this.user.id)
				.listen('PrivateMessageSent',(e)=>{
					this.total_message = this.total_message + 1;
					$(".user_typing_id_" + e.message.user_id ).html("");
					if(this.activeFriend == e.message.user_id){
						this.allMessages.push(e.message);
					}else{
						this.unreadmessage(e.message.user_id);
					}
					setTimeout(this.scrollToEnd,100);
				})
				.listenForWhisper('typing', (e) => {
					$(".clear_all_type").html("");
					if(e.user.id==this.activeFriend){
						this.typingFriend=e.user;
						if(this.typingClock){
							clearTimeout();
							$(".user_typing_id_" + e.user.id ).html("Typing ....");
						} 
						this.typingClock=setTimeout(()=>{
							this.typingFriend={};
							$(".user_typing_id_" + e.user.id ).html("");
						},9000);
					}
				});
		},
		destroyed() {
			window.removeEventListener('resize', this.handleResize)
		},
	}
</script>