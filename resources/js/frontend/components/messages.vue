<template>
	<div class="container">
		<div class="row">
			<div style="background-color:#fff" class="col-md-3 pull-left">
				<div class="row" style="padding:10px">
					<div class="col-md-4"> </div>
					<div class="col-md-6">Messenger</div>
				</div>
				<div v-for="privsteMsg in privsteMsgs">
					<li v-if="privsteMsg.status==1"  @click="messages(privsteMsg.id)" style="list-style:none;
						margin-top:10px; background-color:#F3F3F3" class="row" :class="{highlight:privsteMsg.id == selected}">
						
						<div class="col-md-9 pull-left" style="margin-top:5px">
							<b>{{privsteMsg.first_name}} {{privsteMsg.last_name}}</b><br>
							<b>{{privsteMsg.email}}</b><br>
						</div>
					</li>
					<li v-else  @click="messages(privsteMsg.id)" style="list-style:none;
						margin-top:10px; background-color:#fff" class="row" :class="{highlight:privsteMsg.id == selected}">
						<div class="col-md-9 pull-left" style="margin-top:5px">
							<b> {{privsteMsg.first_name}} {{privsteMsg.last_name}}</b><br>
							<b>{{privsteMsg.email}}</b><br>
						</div>
					</li>
				</div>
				<hr>
			</div>
			<div class="col-md-6 msg_main">
				<h3 align="center">Messages</h3>
				<p class="alert alert-success">{{ msg }}</p>
				<div style="max-height: 400px !important; min-height: 300px !important;  overflow-y: scroll;">
					<div v-for="singleMsg in singleMsgs" >
						<div v-if="singleMsg.user_from == LOGED_ID" class="row">
							<div class="col-md-12" style="margin-top:10px">
								<div style="float:right; background-color:#0084ff; padding:5px 15px 5px 15px;
									margin-right:10px;color:#333; border-radius:10px; color:#fff;" >
									{{singleMsg.msg}}
								</div>
							</div>
						</div>
						<div v-else class="row">
							<div class="col-md-12 pull-right"  style="margin-top:10px">
								
								<div style="float:left; background-color:#dc9797; padding: 5px 15px 5px 15px;
									border-radius:10px; text-align:right; margin-left:5px ">
									{{singleMsg.msg}}
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<input type="hidden" v-model="conID">
				<textarea class="col-md-12 form-control" v-model="msgFrom" @keydown="inputHandler"
				style="margin-top:15px; border:none"></textarea>
			</div>
			<div class="col-md-3 pull-right msg_right">
				<h3 align="center">User Information</h3>
				<hr>
			</div>
		</div>
	</div>
</template>

<style type="text/css">
	.highlight { background-color: #a2caff !important; }
</style>

<script type="text/javascript">
	export default {
		 data(){
			return {
				selected:'',
				msg: 'Click on user from left side:',
				content: '',
				privsteMsgs: [], 
				singleMsgs: [],
				msgFrom: '',
				conID: '',
				friend_id: '',
				seen: false,
				newMsgFrom: '',
				LOGED_ID : $('meta[name=user-id]').attr('content'),
			}
		},
		ready: function(){
		   this.created();
		},
		created(){
			let app =this;
			axios.get(Laravel.siteUrl+'/getMessages')
				.then(response => {
					app.privsteMsgs = response.data; //we are putting data into our posts array
				}).catch(function (error) {});
		},
		methods:{
			messages: function(id){
				this.selected =id;
				let app =this;
				axios.get(Laravel.siteUrl+'/getMessages/' + id).then(response => {
					app.singleMsgs = response.data; //we are putting data into our posts array
					app.conID = response.data[0].conversation_id
				}).catch(function (error) {});
			},
			inputHandler(e){
				if(e.keyCode ===13 && !e.shiftKey){
					e.preventDefault();
					this.sendMsg();
				}
			},
			sendMsg(){
				if(this.msgFrom){
					let app =this;
					axios.post(Laravel.siteUrl+'/sendMessage', {
						conID: this.conID,
						msg: this.msgFrom
					}).then( (response) => {              
						if(response.status===200){
							app.singleMsgs = response.data;
						}
					}).catch(function (error) {});
				}
			},
			friendID: function(id){
				app.friend_id = id;
			},
			sendNewMsg(){
				let app =this;
				axios.post(Laravel.siteUrl + '/sendNewMessage', {
					friend_id: this.friend_id,
					msg: this.newMsgFrom,
				}).then(function (response) {
					if(response.status===200){
						window.location.replace(Laravel.siteUrl + '/messages');
						app.msg = 'your message has been sent successfully';
					}
				}).catch(function (error) {});
			}
		}
	}
</script>