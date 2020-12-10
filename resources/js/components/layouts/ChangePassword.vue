<template>
        <form class="form" id="login" @submit.prevent="changePasswordSubmit">
            <h1 class="form__heading"></h1>
                <div class="" v-if="errors">
                  <label class="" style="color: red !important; font-size: 20px; padding: 10px 0;">{{errMsg}}</label>
                </div>
                <div class="form__group">
                    <input type="password" autocomplete="false" id="password1" v-model="oldPassword" class="form__input" :style="errors ? 'border-bottom:1px solid red !important;' : ''" placeholder="Current Password">
                    <label for="name" class="form__label">password</label>
                </div>
                <div class="form__group">
                    <input type="password" autocomplete="false" id="password2" v-model="newPassword" class="form__input" :style="errors ? 'border-bottom:1px solid red !important;' : ''" placeholder="New Password">
                    <label for="name" class="form__label">password</label>
                </div>
                <div class="form__group">
                    <input type="password" autocomplete="false" id="password3" v-model="confirmPassword" class="form__input" :style="errors ? 'border-bottom:1px solid red !important;' : ''" placeholder="Retype Password Again">
                    <label for="name" class="form__label">password</label>
                </div>
                <button class="btn btn--large btn--green" form_id="login" type="submit" formaction="#" >
                    Change Password
                </button>
               <!-- <p class="" style="color: #3A3A3A; font-size: 16px; padding: 10px 0;">Please Don't Your New Password</p> -->
        </form>
</template>

<script>
    export default {
        data:function(){
            return {
                oldPassword: '',
                newPassword: '',
                confirmPassword: '',
                errors: false,
                errMsg: '',
            }
        },
        mounted() {
            
        },
        methods:{
            changePasswordSubmit:function(){
                if(this.newPassword != "" && this.confirmPassword != "" && this.oldPassword != ""){
                    if(this.newPassword != this.confirmPassword){
                        this.errors = true;
                        this.errMsg = "New Password & Retype Password does not match";
                    }else{
                        this.errors = false;
                        let data = {
                            oldPass: this.oldPassword,
                            newPass: this.newPassword,
                            confirmPass: this.confirmPassword
                        };
                        this.$store.dispatch("changePassword",data)
                        .then(response => {
                            if(response.data.success == true){
                                this.oldPassword = '';
                                this.newPassword = '';
                                this.confirmPassword = '';
                                swal.fire('Success', 'Your Password has been changed', 'success');
                            }else{
                                 this.errors = true;
                                 this.errMsg = "Current Password is wrong!"
                            }
                        });
                    }
                   
                }else{
                    this.errors = true;
                    this.errMsg = "Please Fill Blank";
                }
            }
        }
    }
</script>
<style scoped>
  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-size: 62.5%;
}
.form {
  width: 30rem;
  margin: 2rem auto;
  text-align: center;
  border-radius: 1.5rem;
  border: 1px solid #eee;
  box-shadow: 0 1rem 3rem 0.03rem rgba(0, 0, 0, 0.1);
  font-family: "Balsamiq Sans", cursive;
}
.form__heading {
  padding: 1rem 0;
  color:#3A3A3A;
}
.form__group {
  position: relative;
}
.form__input {
  width: 30rem;
  color: #aaa;
  border: none;
  background-color: transparent;
  border-bottom: 1px solid #eee;
  padding-bottom: 0.5rem;
  margin-bottom: 2rem;
  outline: none;
  text-align: center;
  font-size: 1.5rem;
  font-family: inherit;
}
.form__input:-webkit-autofill, .form__input:-webkit-autofill:hover {
  -webkit-text-fill-color: #aaa !important;
  -webkit-box-shadow: 0 0 0 3rem white inset !important;
}
.form__input::placeholder {
  color: #ccc;
}
.form__input:not(:placeholder-shown) + .form__label {
  opacity: 1;
  color: #ddd;
  position: absolute;
  top: 42px;
  width: 100%;
  font-size: 20px;
}
.form__label {
  display: block;
  color: #ccc;
  transition: all 0.4s ease;
  opacity: 0;
  position: absolute;
  top: 2.8rem;
  width: 100%;
  font-size: 2.4rem;
}
.form__label_error {
  display: block;
  color: red;
  transition: all 0.4s ease;
  opacity: 0;
  position: absolute;
  width: 100%;
  font-size: 2.4rem;
}
.btn {
  margin: 0 auto;
  margin-bottom: 6rem;
  border: none;
  color: #fff;
  font-family: inherit;
  font-size: 20px;
  position: relative;
  width: 15rem;
  align-items: center;
  transition: all 0.3s ease-in;
}
.btn__icon {
  font-size: 25px;
  position: absolute;
  left: 10.5rem;
}
.btn--large {
  border-radius: 25px;
  padding: 10px 35px 10px 40px;
}
.btn--green {
  background-color:#3A3A3A;
  color: white;
}
.btn--green:hover {
  background-color: #28b062;
}
.btn--green:hover .btn__icon {
  position: absolute;
  left: 12rem;
  opacity: 0;
  transition: all 0.5s ease-in;
}
.btn--green:active {
  background-color:#3A3A3A;
  outline: none;
}
</style>