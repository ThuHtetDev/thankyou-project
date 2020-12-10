<template>
    <div class="container">
            <!-- only admin div -->
            <div style="width: 500px; margin:0 auto; text-align:center;">
                <span class="dot" :style="'background:'+ randomColor">
                    <div id="shiva">
                        <span class="count" v-if="randomColor == ''" style="font-size:30px;">{{text}}</span>
                    </div>
                </span>
                <div style="margin-top: 10px;" v-if="randomColor == ''">
                    <button @click="randomClick" class="btn btn-warning btn-block text-green">Random</button>
                </div>
                 <hr>
            </div>
            <!-- end only admin div -->
    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                randomColor: '',
                text: '0',
            }
        },
        mounted() {
            this.$store.dispatch('TodaySelectedColor')
                    .then(response => {
                              this.randomColor = this.$store.state.randomType
            });
        },
        computed:{
        },
        methods: {
                randomClick(){
                $('.count').each(function () {
                    $(this).prop('Counter',0).animate({
                        Counter: 3
                    }, {
                        duration: 5000,
                        easing: 'swing',
                        step: function (now) {
                            $(this).text(Math.ceil(now));
                        }
                    });
                });
                let loader = this.$loading.show({
                    // Optional parameters
                    container: this.fullPage ? null : this.$refs.formContainer,
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'green',
                    backgroundColor: '#222',
                });
                setTimeout(()=>{
                    this.getRandom();
                    loader.hide();
                },5000);
            },
            getRandom(){
                this.$store.dispatch('getRandomColor')
                .then(response => {
                    // this.choseColor  = this.$store.state.randomType;
                    this.randomColor = this.$store.state.randomType
                });
            }
        }

    }
</script>
<style scoped>
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
</style>