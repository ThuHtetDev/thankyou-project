<template>
        <div class="container">
        <div class="grid">
            <article class="main">
                <h3 class="mb-4 text-center">ThankYou Speakers</h3>
                    <div class="refresh" @click="getUpdateData">
                        <i class="fa fa-refresh fa-2x" aria-hidden="true"></i> 
                        <span>Get Latest</span>
                    </div>
                    <div class="container-all" v-if="!isEmpty(players)">
                        <div class="circle" v-for="(player,index) in players" :key="index"  :style="'background-color:'+player.color_info.type">
                            <div class="aligner">
                            {{player.player_info.name}}
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <p style="text-align: center">No Matched Players Today</p>
                    </div>
            </article>
            <section class="side">
                <h3 class="mb-4 text-center">Positive Thinking</h3>
                <ul v-for="(group,index) in groups" :key="index">
                    <li>
                       <span :class="group.is_selected == '1' ? 'sel' : ''">{{group.name}}  </span> 
                       <span v-if="group.is_selected == 1"><i class="fa fa-hand-o-left fa-2x" aria-hidden="true"></i> </span> 
                    </li>
                </ul>
                <div class="mt-5" v-if="this.$store.getters.isAdmin">
                    <button class="btn btn-outline-success btn-block" @click="doneWeek">Done For This Week</button>
                </div>
            </section>
            </div>
        </div>
</template>

<script>
    export default {
        data:function(){
            return {
                players: [],
                groups: [],
            }
        },
        mounted() {
           this.getTodayMatch();
           this.getPositiveThinking();
        },
        methods:{
            getUpdateData(){
                this.getTodayMatch();
            },
            isEmpty(obj) {
              for(var prop in obj) {
                  if(obj.hasOwnProperty(prop))
                      return false;
              }
              return true;
            },
            getTodayMatch(){
                this.$store.dispatch('getTodayMatchedPlayers')
                .then(response => {
                    this.players = this.$store.state.matchedListInfo;
                });
            },
            getPositiveThinking(){
                let loader = this.$loading.show({
                    // Optional parameters
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'green',
                    backgroundColor: '#222',
                });
                this.$store.dispatch('getPositiveThinking')
                .then(response => {
                    this.groups = response.data;
                    loader.hide();
                });
            },
            doneWeek(){
                 let loader = this.$loading.show({
                    // Optional parameters
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'green',
                    backgroundColor: '#222',
                });
                  this.$store.dispatch('doneForThisWeek')
                  .then(response => {
                      loader.hide()
                  })
            }
        }
    }
</script>
<style scoped>
.sel {
    font-size: 25px;
    color: green;
}
.grid {
  display: grid;
  gap: 10px;
  grid-template-columns: 2fr 1fr;
}
.main {
  background: #fcc;
}
.side {
  background: #fea;
}
.main,
.side {
  padding: 2%;
  border-radius: 10px
}

@media(max-width: 400px){
  .grid {
    grid-template-columns: 1fr;
  }
}

/* end */
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