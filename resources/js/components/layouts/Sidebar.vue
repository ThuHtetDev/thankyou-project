<template>
    <div class="container-wrapper" v-if="LoggedIn">
    <div class="navbar-container">
        <ul>
            <li class="nav-link active-link">
                <router-link to="/play" class="nav-link">
                    <a href="#">Play
                    </a>
                    <div class="underline"></div>
                </router-link>
            </li>
            <li class="nav-link">
                <router-link to="/dashboard" class="nav-link">
                        <a href="#">Match</a>
                        <div class="underline"></div>
                </router-link>
            </li>
            <li class="nav-link">
                <router-link to="/today/match-list" class="nav-link">
                        <a href="#">Today Speakers</a>
                        <div class="underline"></div>
                </router-link>
            </li>
            <li class="nav-link" v-if="IsAdmin">
                <router-link to="/random" class="nav-link">
                        <a href="#">Pick Random</a>
                        <div class="underline"></div>
                </router-link>
            </li>
            <li class="nav-link">
                <router-link to="/chat" class="nav-link">
                        <a href="#">Chat</a>
                        <div class="underline"></div>
                </router-link>
            </li>
             <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navDropDownLink" 
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{this.$store.state.AuthUser.name}}
                </a>
                <div class="dropdown-menu" aria-labelledby="navDropDownLink">
                    <router-link to="/profile" class="dropdown-item">
                        <a href="#">Profile</a>
                    </router-link>
                    <router-link to="/change-password" class="dropdown-item">
                        <a href="#">Change Password</a>
                    </router-link>
                    <router-link to="/logout" class="dropdown-item">
                        <a href="#">Logout</a>
                    </router-link>
                </div>
               
            </li>
        </ul>
    </div>
</div>
</template>

<script>
    export default {
        data:function(){
            return {
                auth_user: ''
            }
        },
        mounted() {
            this.getAuth();
        },
        computed:{
            LoggedIn(){
                return this.$store.getters.LoggedIn;
            },
            IsAdmin(){
                return this.$store.getters.isAdmin;
            }
        },
        methods:{
            getAuth(){
                this.auth_user =  this.$store.state.user;
            }
        }
    }
</script>
<style>
body, html {
	margin: 0;
     font-family: "Balsamiq Sans", cursive;
}

a {
	outline: none;
}

.navbar-container {
	text-align: center;
	padding: 10px;
	font-size: 0;
}

.navbar-container ul {
	margin: 0;
	padding: 0;
	width: 100%;
	display: inline-block;
	vertical-align: middle;
}

.navbar-container ul li {
	display: inline-block;
	font-size: 16px;
}

.navbar-container ul li a {
	/* color: black;
	text-decoration: none;
	display: inline-block;	
	padding: 10px;
	transition: color 0.5s; */
    color: #fff;
    cursor: pointer;
    font-family: monospace;
    font-weight:bold;
    text-decoration: none;
	display: inline-block;	
	padding: 10px;
    font-size: 20px;
    text-shadow: 0 0 3px #fff, 0 0 5px #fff, 0 0 8px red, 0 0 10px red, 0 0 15px red;
    transition: all 1s;
}

.navbar-container ul li .underline {
	height: 3px;
	background-color: transparent;
	width: 0%;
	transition: width 0.2s, background-color 0.5s;
	margin: 0 auto;
}

/* .navbar-container ul li.active-link .underline {
	width: 100%;
	background-color: black;
} */

.navbar-container ul li:hover .underline {
	background-color: red;
	width: 100%;
    text-shadow: 0 0 3px #fff, 0 0 5px #fff, 0 0 8px red, 0 0 10px red, 0 0 15px red, 0 0 20px red, 0 0 25px red, 0 0 30px red;
}

.navbar-container ul li:hover a {
}

.navbar-container ul li:active a {
	transition: none;
	color: rgba(255,255,255,0.76);
}

.navbar-container ul li:active .underline {
	transition: none;
	background-color: red;
}
/* .router-link-exact-active{
  background: black;
} */
.navbar-container ul li a.router-link-exact-active .underline {
	width: 100%;
	background-color: red;
}
</style>
