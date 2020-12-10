<template>
        <div class="container">
            <div class="refresh" @click="getUpdateData">
                    <i class="fa fa-refresh fa-2x" aria-hidden="true"></i> 
                    <span>Get Latest</span>
                    <p>{{players == undefined ? 'ဘယ်သူမှမရှိသေးဘူး' : `${players.length} ယောက်ရှိပါပြီ`}} 
                    <span v-if="players != undefined">
                        <span v-if="players.length == users.length" style="font-size:20px; font-weight:bold;">လူစုံပြီ admin!!</span>
                    </span>
                    </p>
            </div>
            <div class="container-all">
                <div class="circle" v-for="(player,index) in players" :key="index"  :style="'background-color:'+player.color_info.type">
                    <div class="aligner">
                        {{player.player_info.name}}
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data:function(){
            return {
                players: [],
                randomColor: '',
                choseColor: '',
                text: '0',
                fullPage: false,
                users: {}
            }
        },
        mounted() {
            this.getMatchData();
        },
        created(){
            this.$store.dispatch('users')
            .then(response => {
                this.users = this.$store.state.users;
            });
        },
        methods:{
            getUpdateData(){
                this.getMatchData();
            },
            getMatchData(){
                let loader = this.$loading.show({
                // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'green',
                });
                this.$store.dispatch('getTodayPlayers')
                .then(response => {
                    var todayPlayers = this.$store.getters.getPlayer;
                    this.players = todayPlayers.data;
                    loader.hide();
                });
            }
        }
    }
</script>
<style scoped>
.refresh{
    margin:0 auto; text-align:center; margin-bottom: 20px;
    cursor: pointer;
}
.refresh:hover i{
    color: green;
}
.dot {
  height: 200px;
  width: 200px;
  background-color: #ccc;
  border-radius: 50%;
  display: inline-block;
}
.selector{
    width:100%;
    height: 20px;
}
div { box-sizing: border-box; }

.container-all {
  display: flex;
  justify-content: center;
  align-content: flex-start;
  -webkit-flex-flow: row wrap;
  flex-flow: row wrap;
  height: 500px;
  border: 1px solid #000000;
}

.circle {
    border: 5px solid #ff0000;
    background: #ccc;
    width: 150px;
    height: 150px;
    border-radius: 1000px; 
    margin: 0.5em;
}

.circle.kitten {
  background-image: url('http://placekitten.com/g/200/200');
  background-size: cover;
  background-repeat: none;
  background-position: center center;
  color: white;
}

.circle:hover {
  background-color: #008000;
  border-style: dotted;
}

.aligner {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  text-align: center;
}

</style>