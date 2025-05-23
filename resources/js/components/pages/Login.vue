<template>
    <div style="display: grid; place-items: center;">
        <form method="post" @submit.prevent="doLogin">
            <table class="login-form">
                <tbody>
                    <tr>
                        <td class="login-header">
                            <h2>Login</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ error_message }}</td>
                    </tr>
                    <tr>
                        <td class="username-label">Email</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" placeholder="Email" v-model="email">
                        </td>
                    </tr>
                    <tr>
                        <td class="password-label">Password</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="password" placeholder="Password" v-model="password">
                        </td>
                    </tr>
                    <tr>
                        <td class="button-data">
                            <button type="submit" >
                                Login
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            email : '',
            password : '',
            error_message :''
        }
    },
    methods: {
        doLogin(){
            axios.post('/api/login',{email : this.email , password : this.password} ,{headers: {'Content-Type' :'application/json'}}).then(response => {
                console.log(response)
                if (response.status == 200){
                    const token = response.data.token
                    const user_data = response.data.user

                    localStorage.setItem('token',token)
                    localStorage.setItem('userDetail',JSON.stringify(user_data))
                    this.$store.commit('setUserData' ,{
                        token : token,
                        userDetail : user_data
                    })
                }

                this.$router.push('/')
            }).catch(error => {
                if (error.status == 401){
                    this.error_message = 'Username atau password salah'
                }
            });
        }
    }
}
</script>
<style>
table.login-form {
    margin-top: 200px;
    background-color: beige;
    border-radius: 10px;
    text-align: center;
    width: 400px;

}

table.login-form tbody tr td.login-header {
    background-color: beige;
    text-align: center;
    padding: 10px;
    height: 80px;
}

table.login-form tbody tr td.login-header {
    text-align: center;
    padding: 10px;
    height: 80px;
}

table.login-form tbody tr td.username-label {
    text-align: center;
    padding: 10px;
    height: 50px;
}

table.login-form tbody tr td.password-label {
    text-align: center;
    padding: 10px;
    height: 50px;
}

table.login-form tbody tr td.button-data {
    text-align: center;
    padding: 10px;
    height: 90px;
}

table.login-form tbody tr td input {
    height: 40px;
    border-style: inherit;
    width: 70%;
    border-radius: 10px;
    padding: 10px;
}

table.login-form tbody tr td button {
    height: 40px;
    border-style: inherit;
    background-color: #00a838;
    width: 70%;
    color: #ffffff;
    border-radius: 10px;
    padding: 10px;
}
</style>
