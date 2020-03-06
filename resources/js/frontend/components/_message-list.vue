<template>
    <div class="messages col-md-12" v-chat-scroll>
        <div 
        v-for="(message, index) in allMessages" 
        :key="index" 
        class="d-flex chat-message col-md-12"
        :class="(user.id==message.user_id)?'justify-content-end':'justify-content-start '"
         >
            
            <div v-if="user.id==message.user_id" class="row" >
                <div class="msg_cotainer_send">
                    <span>{{message.message}}</span> 
                    <lightbox
                        v-if="message.image && imagestype.includes(message.image.replace('/chat/','').split('.').pop())"
                        style="width: 20em"
                        :thumbnail="'/storage'+message.image"
                        :images="[
                          '/storage'+message.image,
                        ]"
                    >
                    <lightbox-default-loader slot="loader"/>
                    </lightbox>                   
                    <!-- <img v-if="message.image && imagestype.includes(message.image.replace('/chat/','').split('.').pop())" :src="'/storage'+message.image" alt="" width="200px" height="200px"> -->
                    <div v-if="message.image && videotype.includes(message.image.replace('/chat/','').split('.').pop())">
                        <video :src="'/storage/'+message.image" style="width: 200px;height: auto;" controls ></video>
                    </div>

                    <a v-if="message.image && (imagestype.includes(message.image.replace('/chat/','').split('.').pop()) || videotype.includes(message.image.replace('/chat/','').split('.').pop()))" :href="'/message/download/'+message.image.replace('/chat/','')">{{ $t("message.download") }}</a>
                    <a v-else-if="message.image" :href="'/message/download/'+message.image.replace('/chat/','')">{{message.image.replace('/chat/','')}}</a>

                    <span class="msg_time_send">{{message.created_at}}</span>
                </div>
                <div class="img_cont_msg">
                    <img v-if="user.avatar_location" :src="'/storage/'+user.avatar_location" class="rounded-circle user_img_msg">
                    <img v-else :src="'/storage/avatars/dummy.png'" class="rounded-circle user_img_msg">                     
                </div>
                
            </div>
            <div v-else class="row" >
                <div class="img_cont_msg">
                    <img :src="active_user_image" class="rounded-circle user_img_msg">
                </div>
                <div class="msg_cotainer">
                    <span>{{message.message}}</span>
                    <lightbox
                        v-if="message.image && imagestype.includes(message.image.replace('/chat/','').split('.').pop())"
                        style="width: 20em"
                        :thumbnail="'/storage'+message.image"
                        :images="[
                          '/storage'+message.image,
                        ]"
                    >
                    <lightbox-default-loader slot="loader"/>
                    </lightbox>
                    <!-- <img v-if="message.image && imagestype.includes(message.image.replace('/chat/','').split('.').pop())" :src="'/storage'+message.image" alt="" width="200px" height="200px"> -->
                    <div v-if="message.image && videotype.includes(message.image.replace('/chat/','').split('.').pop())">
                        <video :src="'/storage/'+message.image" style="width: 200px;height: auto;" controls ></video>
                    </div>

                    <a v-if="message.image && (imagestype.includes(message.image.replace('/chat/','').split('.').pop()) || videotype.includes(message.image.replace('/chat/','').split('.').pop()))" :href="'/message/download/'+message.image.replace('/chat/','')">{{ $t("message.download") }}</a>
                    <a v-else-if="message.image" :href="'/message/download/'+message.image.replace('/chat/','')">{{message.image.replace('/chat/','')}}</a>

                    <span class="msg_time">{{message.created_at}}</span>
                </div>
                
            </div>     
        </div>   
        
  </div>
</template>

<script> 
import Lightbox from 'vue-pure-lightbox'
  export default {
    props:['user','allMessages','active_user_image'],
     data(){
            return {              
              LOGED_ID : $('meta[name=user-id]').attr('content'),
              imagestype : ['jpg','jpeg','png','bmp','gif','JPG','JPEG','PNG','BMP','GIF'],
              //videotype : ['webm','mkv','vob','ogg','ogv','avi','mov','mp4','mpg','mpeg','wmv'],
              videotype : ['webm','ogg','mp4'],

            }
        },

  }
</script>

<style scoped>
.chat-card{
  margin-bottom:140px;
}
.floating-div{
    position: fixed;
}
.chat-card img {
    max-width: 300px;
    max-height: 200px;
}

</style>
