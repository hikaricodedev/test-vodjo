<template>
    <Main>
        <div class="heading" style="float:right; padding: 20px;">
                <router-link class="button-style" :to="`/order/${order_id}/edit`">Edit</router-link>
        </div>
        <div class="split-content">
            <div class="split1" style="width: 70%; ">
                <div class="form-input">
                    <label for="customer">Customer Name</label>
                    <input type="text" id="customer" v-model="order_data.cust_name" disabled>
                </div>
                <div class="form-input">
                    <label for="order-date">Order Date</label>
                    <input type="text" id="order-date" v-model="order_data.order_date" disabled>
                </div>
                <div class="button-area">

                </div>
                <div class="table-style">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(oi , k) in order_item">
                                <td>{{ k+1 }}</td>
                                <td><input type="text" v-model="oi.prod_name" disabled></td>
                                <td><input type="number" v-model="oi.qty" disabled></td>
                                <td><input type="number" v-model="oi.price" disabled></td>
                                <td>{{ oi.price * oi.qty }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="split2" style="width:25%;">
                <div class="table-style">
                    <table>
                        <tbody>
                            <tr>
                                <td>Total</td>
                                <td style="width:30%; text-align: right;">{{ order_data.total_order }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </Main>
</template>
<script>
import Main from '../layouts/Main.vue';
export default {
    components : {
        Main
    },
    data() {
        return {
            access_token : localStorage.getItem('token'),
            order_data : {
                cust_name : '',
                order_date : null,
                total_order : 0
            },
            order_item : [
                {
                    prod_name : '',
                    qty: 0,
                    price: 0
                }
            ],
            order_id : this.$route.params.id
        }
    },
    watch : {


    },
    methods :{
        addItem(){
            let current_item = this.order_item
            current_item.push({
                prod_name : '',
                qty: 0,
                price: 0
            })

            this.order_item = current_item
        },
        getOrder(){
            axios.get(`/api/order/${this.order_id}/show`,{headers: {
                'Authorization' : 'Bearer ' + this.access_token
            }}).then(response => {
                this.order_data = {
                    cust_name : response.data.customer_name,
                    order_date : response.data.order_date,
                    total_order : response.data.grand_total
                }
                if (response.data.order_items){
                    let new_order_item = []
                    for (const oi of response.data.order_items){
                        new_order_item.push({
                            prod_name : oi.product_name,
                            qty : oi.qty,
                            price : oi.price
                        })

                    }
                    this.order_item = new_order_item
                }

            })
        }
    },
    mounted(){
        this.getOrder()
    }
}
</script>
