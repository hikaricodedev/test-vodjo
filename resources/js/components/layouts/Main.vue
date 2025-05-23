<template>
    <nav>
        <ul>
            <li><router-link to="/">Order</router-link></li>
            <li><router-link to="/order-list">Order List</router-link></li>
            <li style="float:right"><a class="" href="javascript:void(0)" @click="doLogout">Logout</a></li>
        </ul>
    </nav>
    <div class="contents">
        <slot/>
    </div>

    <div :class="`popup ${popup_data.class_show}`">
        <div class="popup-window">
            <h2>Sukses</h2>
            <div class="popup-content">
                {{ popup_data.message }}
                <div class="popup-content-footer">
                    <button class="button-style" @click="closePopup">Oke</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import { mapState } from 'vuex/dist/vuex.cjs.js'
export default {
    name : 'Main',
    computed : {
        ...mapState(['popup_data'])
    },
    data() {
        return {
            access_token : localStorage.getItem('token')
        }
    },
    methods : {
        doLogout(){
            console.log(this.access_token)
            axios.post('/api/logout',{},{headers:{'Authorization' : `Bearer ${this.access_token}`}})
            localStorage.setItem('token',null)
            this.$store.commit('setUserData',{
                token : null,
                userDetail:null
            })
            this.$router.push('/login')
        },
        closePopup(){
            this.$store.commit('setPopupData',{
                class_show : 'hide',
                message : '-'
            })
        }
    }
}
</script>
