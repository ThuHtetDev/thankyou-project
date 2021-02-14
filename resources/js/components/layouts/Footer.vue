<template>
    <div class="container" style="margin-top: 100px;" v-if="LoggedIn">
             <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>@2020, All Right Reserved <a href="https://spiceworksmyanmar.com/">SpiceworksMyanmar</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="https://spiceworksmyanmar.playth.com/"  target="_blank">Playth</a></li>
                                <li><a href="http://book-cafe.sitetastingmyanmar.com/" target="_blank">Book Cafe</a></li>
                                <li><a href="https://spiceworksmyanmar.com/blog/" target="_blank">SpiceworksMyanmar Blogs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
        },
        computed:{
            LoggedIn(){
                return this.$store.getters.LoggedIn;
            },
        }
    }
</script>
<style scoped>
ul {
    margin: 0px;
    padding: 0px;
}

.copyright-area{
  /* background:#3A3A3A; */
  /* padding: 25px 0; */
    padding: 25px 0;
    opacity: 0.9;
    background: aliceblue;
}
.copyright-text p {
  margin: 0;
  font-size: 14px;
  color: #878787;
}
.copyright-text p a{
  color: #2FABCD;
}
.footer-menu li {
  display: inline-block;
  margin-left: 20px;
}
.footer-menu li:hover a{
  color: #fff;
}
.footer-menu li a {
  font-size: 14px;
  color: #878787;
}
</style>