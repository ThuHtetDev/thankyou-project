<template>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        created(){
            if(confirm("Do you really want to Logout?")){
                this.$store.dispatch('deleteToken')
                .then(response => {
                    this.$router.push('/login');
                })
            }else{
                  this.$router.push('/dashboard');
            }
         
        }
    }
</script>
