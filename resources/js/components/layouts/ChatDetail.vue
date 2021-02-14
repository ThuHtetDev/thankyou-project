<template>
    <div class="container">
        <!-- chat box -->
            <h2 class="text-center mb-5">
                <a href="javascript:history.go(-1)">
                    <i class="fa fa-chevron-left mr-3 arrow-back"></i>
                </a>
                {{chatuser}}
                 <hr style="width: 200px; height:5px; background:red;">
            </h2>
            <div class="container-chat" id="containerChat" ref="messagesContainer">
                <div v-if="chatInfos.length > 0"  >
                    <div class="message-hiring-manager center-block" v-for="(info,index) in chatInfos" :key="index">
                        <div class="row">
                        <div class="col-xs-8 col-md-6">
                            <h4 class="message-name"><span style="font-size:14px;">From -</span> {{info.from_user_name}}</h4>
                        </div>
                        <div class="col-xs-4 col-md-6 text-right message-date">{{info.created_at}}
                        </div>
                        </div>
                        <div class="row message-text">
                            {{info.from_user_message}}
                        </div>
                    </div>
                </div>
                 
            </div>
                 <!-- <div v-else>
                    <p style="text-align:center">Be the first Chat For {{chatuser}}</p>
                </div> -->
                <div class="messaging center-block">
                    <div class="row">
                        <div class="col-lg-10 col-md-8 col-sm-6">
                            <div class="input-group">
                            <textarea name=""
                                class="form-control"
                                id=""
                                cols="20"
                                rows="10"
                                v-model="chatMsg"
                                ref="textarea">
                            </textarea>
                            <span class="input-group-btn">
                                <button class="btn btn-success ml-4" type="button" @click="sendMessage"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                            </span>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <span
                            class="emoji-trigger"
                            style="cursor:pointer;"
                            :class="{ 'triggered': showEmojiPicker }"
                            @mousedown.prevent="toggleEmojiPicker"
                            >
                            <svg
                                style="width:40px;height:40px;color: #fff; "
                                viewBox="0 0 24 24"
                            >
                                <path fill="#228B22" d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" />
                            </svg>
                            </span>
                            <picker 
                            v-show="showEmojiPicker"
                            title="Pick your emoji…" 
                            emoji="point_up" 
                            @select="addEmoji"
                            :style="{  }"
                            >
                            </picker>
                        </div>
                    </div>
                </div>
        <!-- end chat box -->
    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                   proId : this.$route.params.id,
                   chatInfos: [],
                   chatuser:'',
                   chatMsg: '',
                   showEmojiPicker: false
            }
        },
        computed:{

        },
        mounted() {
            this.getChatMessages();
        },
        //  updated() {
        //     // whenever data changes and the component re-renders, this is called.
        //     this.$nextTick(() => this.scrollToBottom());
        // },
        methods:{
            addEmoji (emoji) {
                const textarea = this.$refs.textarea
                const cursorPosition = textarea.selectionEnd
                // const start = this.value.substring(0, textarea.selectionStart)
                // const end = this.value.substring(textarea.selectionStart)
                const text =  emoji.native;
                this.chatMsg += emoji.native;
                textarea.focus()
                this.$nextTick(() => {
                    textarea.selectionEnd = cursorPosition + emoji.native.length
                })
            },
            toggleEmojiPicker () {
                this.showEmojiPicker = !this.showEmojiPicker
            },
            // scrollToBottom() {
            //         var content = this.$refs.messagesContainer;
            //         content.scrollTop = content.scrollHeight
            // },
            sendMessage:function(){
                if(this.chatMsg != ''){
                    let data = {
                        'to_user': this.proId,
                        'message': this.chatMsg
                    };
                    this.$store.dispatch('sendMessage',data)
                    .then(response => {
                        this.getChatMessages();
                        this.chatMsg = '';
                    });
                }
            },
            getChatMessages(){
                 let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'red',
                });
                this.$store.dispatch('chatUser',this.proId)
                .then(response => {
                    var chatInfos = this.$store.state.userChats;
                    this.chatuser = chatInfos.to_user
                    if(chatInfos.success == true){
                        this.chatInfos = chatInfos.data;
                    }
                    loader.hide();
                });
            }
        }
    }
</script>
<style scoped>
.container-chat{
    height: 500px;
    overflow-y: auto;
}
.message-candidate {
  background: rgba(223, 229, 121, 0.9);
  padding: 40px;
  max-width: 600px;
  margin-bottom: 10px;
}

.message-hiring-manager {
  background: yellow;
  padding: 40px;
  max-width: 600px;
  margin-bottom: 10px;
  margin: 20px auto;
}

.messaging {
  max-width: 600px;
  margin:20px auto;
}

.message-text {
  margin-top: 10px;
}

.message-photo {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  object-position: center center;
  display: inline-block;
}

.message-name {
  margin-left: 10px;
  display: inline-block;
}
</style>