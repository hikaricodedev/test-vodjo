<template>
    <Main>
        <div class="split-content">
            <div class="split1" style="width: 70%; ">
                <div class="form-input">
                    <label for="customer">Customer Name</label>
                    <input type="text" id="customer" v-model="order_data.cust_name">
                </div>
                <div class="form-input">
                    <label for="order-date">Order Date</label>
                    <input type="date" id="order-date" v-model="order_data.order_date">
                </div>
                <div class="button-area">
                    <button class="button-style" @click="addItem">Tambah Item</button>
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
                                <td><input type="text" v-model="oi.prod_name"></td>
                                <td><input type="number" v-model="oi.qty"></td>
                                <td><input type="number" v-model="oi.price"></td>
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
                <button class="button-style" style="width: 100%;" @click="submitOrder">Order</button>
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
            ]
        }
    },
    watch : {
        'order_item' :{
            handler(order_item_old ,order_item_new){
                console.log(order_item_new)
                let new_total = 0
                for (const item of order_item_new){
                    new_total += item.price * item.qty
                }
                this.order_data.total_order = new_total
            },
            deep : true
        }

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
        submitOrder(){
            const order = {
                cust_name : this.order_data.cust_name,
                order_date : this.order_data.order_date,
                item : this.order_item
            }

            axios.post('/api/order',order,{headers : {'Authorization' : `Bearer ${this.access_token}`}}).then(response => {
                this.$store.commit('setPopupData',{
                    class_show : '',
                    message : 'Order Berhasil ditambahkan'
                })
                this.$router.push('/order-list')
            })
        }
    }
}
</script>
