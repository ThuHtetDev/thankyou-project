<template>
    <div class="container">
         <h2 class="text-center title-chat">
            Happiness Chat
            <hr style="width: 200px; height:5px; background:red;">
         </h2>
        
        <div class="happiness-chat">
            <section class="card-container">
                <div class="circle" 
                v-for="(user,index) in users" 
                :key="index" 
                :style="user.image != null ? 
                'background: url(/storage/profile_images/'+user.image +');'+
                'background-position: 50% 50%;'+
                'background-size: cover;'
                :''">
                <router-link :to="{ name: 'chatDetail', params: { id: user.id } }" class="">
                        <h5 class="aligner">{{user.name}}</h5>
                    </router-link>
                </div>
            </section>
        </div>
    </div>
</template>

<script>

    export default {
        data:function(){
            return {
                users: {}
            }
        },
        mounted() {
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
            this.$store.dispatch('users')
            .then(response => {
                this.users = this.$store.state.users;
                loader.hide();
            });
        }
    }
</script>
<style scoped>
body {
	margin: 0 auto;
	max-width: 948px;
}
.container{
    background: yellow;
    padding: 50px;
}
.card-container {
	align-items: start;
	display: grid;
	grid-gap: 16px;
	grid-template-columns: repeat(auto-fit, 300px);
	justify-content: center;
}


.aligner {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  text-align: center;
}
.title-chat{
    margin-bottom: 50px;
}
.circle {
    background: #fff;
    width: 200px;
    height: 200px;
    border-radius: 1000px; 
    margin: 0.5em;
    background-position: 50% 50%;
    background-size: cover;
}
.circle:hover {
  opacity: 0.6;
  cursor: pointer;
}
</style>