<template>
    <div class="container">
        <div style="width: 500px; margin:0 auto; text-align:center;">
            <span class="dot" :style="'background-color:'+selectedBg"></span>

                <select @change="onChange($event)"  v-model="chosenColor" class="selector">
                    <option selected="selected"></option>
                    <option v-for="(color,index) in getColors" :key="index" v-bind:value="{ id: color.id, text: color.name, type: color.type }">
                        {{color.name}}
                    </option>
                </select>
                <div style="margin-top: 50px;" >
                    <button @click="sendColor" class="btn btn-secondary btn-block text-white">Send</button>
                </div>
        </div>
     
        
    </div>
</template>

<script>
    export default {
        data:function(){
            return {
                chosenColor: '',
                selectedBg : '',
                message: '',
            }
        },
        mounted() {
            this.getCurrentAvailableColors();
        },
        computed:{
            getColors(){
                return this.$store.getters.getAvailableColors;
            }
        },
        methods: {
            getCurrentAvailableColors(){
                let loader = this.$loading.show({
                    // Optional parameters
                    loader: 'dots',
                    canCancel: true,
                    onCancel: this.onCancel,
                    width: 64,
                    height: 64,
                    color: 'green',
                });
                this.$store.dispatch('currentAvailableColors')
                .then(response => {
                    loader.hide();
                });
            },
            onChange(event){
                switch(this.chosenColor.type){
                    case "green":
                    this.selectedBg = "green";
                    break;

                    case "red":
                    this.selectedBg = "red";
                    break;

                     case "blue":
                    this.selectedBg = "blue";
                    break;

                    case "orange":
                    this.selectedBg = "orange";
                    break;

                    case "yellow":
                    this.selectedBg = "yellow";
                    break;
                }
            },
            sendColor(){
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
                if(this.chosenColor == '') return;
                let data = {
                    color_id: this.chosenColor.id
                };
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.token;
                    axios.post("/send",{
                        color_id: data.color_id
                    })
                    .then((response) => {
                        loader.hide()
                        if(response.data.success == true){
                            this.send = true;
                            swal.fire('Success', 'Go To Dashboard', 'success');
                             this.$router.push('/dashboard');
                        }else{
                            swal.fire('Attention', response.data.message, 'info');
                            this.chosenColor = '';
                            this.selectedBg = "";
                            this.getCurrentAvailableColors();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
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