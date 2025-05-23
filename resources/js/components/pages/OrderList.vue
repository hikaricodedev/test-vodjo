<template>
    <Main>
        <div class="button-area">
            <label for="date-from">From</label>
            <input type="date" id="date-from" v-model="dateFrom">
            <label for="date-to">To</label>
            <input type="date" id="date-to" v-model="dateTo">
            <button class="button-style" @click="getOrder">Search</button>
        </div>
        <div class="table-style">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="order_data != ''" v-for="(od , k) in order_data">
                        <td>{{ k+1 }}</td>
                        <td><router-link :to="`/order/${od.id}`">{{ od.order_no }}</router-link></td>
                        <td>{{ od.customer_name }}</td>
                        <td>{{ od.order_date }}</td>
                        <td>{{ od.grand_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Main>
</template>
<script>
import Main from '../layouts/Main.vue'
export default {
    components : {
        Main
    },
    data(){
        return {
            order_data : [],
            dateFrom : '',
            dateTo : '',
            order_code : '',
            access_token : localStorage.getItem('token')
        }
    },
    methods : {
        getOrder(){
            const params = `order_date_from=${this.dateFrom}&order_date_to=${this.dateTo}&order_code=${this.order_code}`
            axios.get('/api/order?' + params,{headers : {
                'Authorization' : 'Bearer ' + this.access_token
            }}).then(response => {
                this.order_data = response.data
            }).catch (error => {
                if (error.status == 401){
                    this.$router.push('/login')
                }
            })
        }
    },
    mounted(){
        this.getOrder()
    }
}
</script>
