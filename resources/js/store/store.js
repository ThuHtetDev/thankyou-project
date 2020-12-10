
export default {
	state: {
        token: localStorage.getItem('access_token') || null,
        AuthUser: {},
        currentAvailableColors: {},
        todayPlayers: [],
        randomType: '',
        matchedListInfo: [],
        matchedListUsesr: {},
        users: {},
        userChats: {},
        positive: {}
	},

	getters: {
        LoggedIn:function(state){
            if(state.token != null) return true;
            return false
        },
        isAdmin:function(state){
            if(state.AuthUser.type != "member") return true;
            return false;
        },
        getAvailableColors(state){
            return state.currentAvailableColors;
        },
        getPlayer(state){
            return state.todayPlayers
        }
	},

	actions: {
        currentAuthUserAction:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/user")
                .then((response) => {
                    var authUser = response.data;
                    context.commit('retrieveAuthUserMutate',authUser);
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
            });
        },
        retrieveToken:function(context,data){
            return new Promise((resolve,reject) => {
                axios.post("/login",{
                    email: data.email,
                    password: data.password
                })
                .then((response) => {
                    var authUser = response.data;
                    const token = response.data.bearToken;
                    localStorage.setItem('access_token',token);
                    context.commit('retrieveTokeMutate',token);
                    context.commit('retrieveAuthUserMutate',authUser);
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
            });
        },
        deleteToken:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/logout")
                .then((response) => {
                    localStorage.removeItem('access_token');
                    context.commit('deleteTokenMutate');
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    context.commit('deleteTokenMutate');
                    reject(error);
                });
            });
        },
        currentAvailableColors:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/current-available-colors")
                .then((response) => {
                 context.commit('retrieveAvailableColorMutate',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        getTodayPlayers:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/players")
                .then((response) => {
                 context.commit('getTodayPlayersMutate',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });

        },
        getRandomColor:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/random/send")
                .then((response) => {
                    context.commit('getMatchColorMutate',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        TodaySelectedColor:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("today/selected-color")
                .then((response) => {
                    context.commit('TodaySelectedColor',response.data.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        getTodayMatchedPlayers:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/today/matched")
                .then((response) => {
                 context.commit('matchedPlayersMutate',response.data);
                 context.commit('matchedListUser',response.data.user);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    context.commit('matchedListUser',response.data.user);
                    reject(error);
                });
            });
        },
        getPositiveThinking:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/positive-thinking")
                .then((response) => {
                 context.commit('getPositiveGroups',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        doneForThisWeek:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/done-positive")
                .then((response) => {
                //  context.commit('usersMutate',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        users:function(context){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.get("/users")
                .then((response) => {
                 context.commit('usersMutate',response.data);
                 resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        chatUser:function(context,chatId){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/user/chat/detail",{
                    id: chatId
                })
                .then((response) => {
                    context.commit('userChatInfo',response.data);
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        sendMessage:function(context,data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/user/chat/send",{
                    to_user: data.to_user,
                    message: data.message
                })
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        changePassword:function(context,data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/setting/change-password",{
                    oldPass: data.oldPass,
                    newPass: data.newPass,
                    confirmPass: data.confirmPass
                })
                .then((response) => {
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        },
        uploadImg:function(context,file){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token;
            return new Promise((resolve,reject) => {
                axios.post("/setting/change-profile-pic",{
                    propic: file,
                })
                .then((response) => {
                    console.log(response.data);
                    resolve(response);
                })
                .catch((error) => {
                    console.log(error);
                    reject(error);
                });
            });
        }
	},

	mutations: {
        userChatInfo:function(state,data){
            state.userChats = data;
        },
        getPositiveGroups:function(state,data){
            state.positive  = data;
        },
        usersMutate:function(state,data){
            state.users = data;
        },
        retrieveAuthUserMutate:function(state,data){
            state.AuthUser = data;
        },
        retrieveTokeMutate:function(state,token){
            state.token = token;
        },
        deleteTokenMutate:function(state){
            state.token = null;
        },
        retrieveAvailableColorMutate:function(state,data){
            state.currentAvailableColors = data;
        },
        getTodayPlayersMutate:function(state,data){
            state.todayPlayers = data;
        },
        getMatchColorMutate:function(state,data){
            state.randomType = data.type;
        },
        TodaySelectedColor:function(state,data){
            state.randomType = data;
        },
        matchedPlayersMutate:function(state,data){
            state.matchedListInfo = data.data;
        },
        matchedListUser:function(state,data){
            state.matchedListUsesr = data;
        }
	}
}