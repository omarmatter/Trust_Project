<template>

<div class="container mt-5">
    <vue-confirm-dialog></vue-confirm-dialog>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Order_No</th>
            <th scope="col">price</th>
            <th scope="col">tax</th>
            <th scope="col">status</th>
            <th scope="col">payment_method</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(order, index) in orders" :key="order.id">
            <td>{{ index + 1 }}</td>
            <td>{{ order.id }}</td>
            <td>{{ order.price }}$</td>
            <td>{{ order.tax }}</td>
            <td>{{ order.status }}</td>

            <td>{{ order.payment_method }}</td>

            <td>
                <button class="btn btn-primary" data-toggle="modal" v-bind:data-target="'#show'+ order.id"><i class="far fa-eye"> </i></button>
                <button  class="btn btn-primary" data-toggle="modal" v-bind:data-target="'#edit'+ order.id" ><i class="fa fa-edit"></i></button>
                <div class="modal fade" v-bind:id="'show'+order.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div v-for="(OrderProduct, index) in order.order_product" :key="OrderProduct.id">

                                    <label class="font-weight-bold">Product Name :</label>
                                    <span class="text-secondary">{{OrderProduct.products.name}}</span>
                                    <label class="font-weight-bold  pl-5">Quantity :</label>
                                    <span class="text-secondary">{{OrderProduct.quantity}}</span>
                                    <hr>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade edit" v-bind:id="'edit'+order.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" >Edit Order </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form @submit.prevent="update(order.id)">
                                <label>Status :</label>
                              <select class="form-control"  v-model="form.status">
                                  <option selected v-bind:value="order.status">{{order.status}}</option>
                                  <option  value="processing">processing</option>
                                  <option  value="shipped">shipped</option>
                                  <option value="completed">completed</option>
                                  <option  value="cancelled">cancelled</option>
                              </select>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" >Edit</button>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </td>


        </tr>

        </tbody>
    </table>
</div>
</template>

<script>
import Form from "vform";

const token = localStorage.getItem('token');
const header = {
    headers: {
        'Authorization': `Bearer ${token}`
    }
}
export default {
    data() {

        return {
            form: new Form({
                status: '',
            }),
            orders: [],


        }
    },
    mounted() {
        this.AllOrders()
    },
    methods: {
        async AllOrders() {

            await axios.get(`/api/AllOrder`, header)
                .then(response => {

                this.orders = response.data.data.orders
                    console.log(this.orders[1].order_product.length)



            }).catch(error => {
                console.log(error)

            })
        },

        async update($id){
            this.$confirm(
                {
                    message: `Are you sure delete this item ?`,
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    /**
                     * Callback Function
                     * @param {Boolean} confirm
                     */
                    callback: confirm => {
                        if (confirm) {
                             axios.patch(`/api/orders/${$id}`, this.form, header)
                                .then(response => {
                                    console.log(response.data.message);
                                    swal(response.data.message);
                                    $(`#edit${$id}`).modal('toggle');
                                    setTimeout("location.reload(true);", 2000)
                                });
                        }
                    }
                });

        }

    },
}
</script>

<style scoped>

</style>
