<template>
        <form role="form" @submit="formSubmit" enctype="multipart/form-data">
            <div class="avatar-wrapper">
                <img class="profile-pic" :src="front_url == '' ? '/storage/profile_images/'+ front_img: front_url" />
                <div class="upload-button" @click="chooseImg">
                    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                </div>
                <input class="file-upload" type="file" @change="handle"/>
            </div>
            <div style="margin:10px auto; text-align:center">
                <button class="btn btn-success text-center">Change Profile Picture</button>
            </div>
        </form>

</template>

<script>
    export default {
        data:function(){
            return {
                front_url: '',
                front_img: '',
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
                    color: 'green',
            });
          this.$store.dispatch('currentAuthUserAction')
          .then(response => {
              this.front_img = this.$store.state.AuthUser.image;
              loader.hide();
          });
        },
        methods:{
            chooseImg(){
                $(".file-upload").click();
            },
        
              handle(e){
                var f = e.target.files[0];
                let reader = new FileReader();
                let that = this;
                reader.onload = function (e) {
                    that.front_url = e.target.result;
                }
                reader.readAsDataURL(f);
             },
            formSubmit(e){
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
                e.preventDefault();
                if(this.front_url == ''){
                    loader.hide();
                    swal.fire('Info', 'Please Select Profile First', 'info');
                }else{
                    this.$store.dispatch('uploadImg',this.front_url)
                    .then(response => {
                        loader.hide();
                        swal.fire('Success', 'Your Profile has been saved', 'success');
                    });
                }
             
            }
        }
    }
</script>
<style scoped>
.avatar-wrapper {
	 position: relative;
	 height: 200px;
	 width: 200px;
	 margin: 50px auto;
	 border-radius: 50%;
	 overflow: hidden;
	 box-shadow: 1px 1px 15px -5px black;
	 transition: all 0.3s ease;
}
 .avatar-wrapper:hover {
	 transform: scale(1.05);
	 cursor: pointer;
}
 .avatar-wrapper:hover .profile-pic {
	 opacity: 0.5;
}
 .avatar-wrapper .profile-pic {
	 height: 100%;
	 width: 100%;
	 transition: all 0.3s ease;
}
 .avatar-wrapper .profile-pic:after {
	 font-family: FontAwesome;
	 content: "\f007";
	 top: 0;
	 left: 0;
	 width: 100%;
	 height: 100%;
	 position: absolute;
	 font-size: 190px;
	 background: #ecf0f1;
	 color: #34495e;
	 text-align: center;
}
 .avatar-wrapper .upload-button {
	 position: absolute;
	 top: 0;
	 left: 0;
	 height: 100%;
	 width: 100%;
}
 .avatar-wrapper .upload-button .fa-arrow-circle-up {
	 position: absolute;
	 font-size: 234px;
	 top: -17px;
	 left: 0;
	 text-align: center;
	 opacity: 0;
	 transition: all 0.3s ease;
	 color: #34495e;
}
 .avatar-wrapper .upload-button:hover .fa-arrow-circle-up {
	 opacity: 0.9;
}
 
</style>