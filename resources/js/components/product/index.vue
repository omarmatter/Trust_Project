<template>


    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <router-link class="btn btn-success m-5" to="StoreProduct">Add product</router-link>

            <select  v-model="category_id">
                <option :value='""'>Show All </option>

                <option v-for='categorey in Categories' :value='categorey.id'>{{ categorey.name }}</option>
            </select>


            <input placeholder="Search product by name" v-model="name_product" >
        </div>
        <div class="table-responsive">

            <table class="table table-bordered" id="my-table" >
                <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>Category</th>
                    <th>price</th>
                    <th>option</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, index) in products" :key="product.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.category }}</td>
                    <td>{{ product.price }}</td>
                    <td>
                        <button class="btn btn-danger" @click.prevent="deleteItem(product.id)">Delete</button>
                        <button class="btn btn-warning" @click.prevent="edit(product)">Edit</button>
                    </td>
                </tr>
                </tbody>

            </table>

            <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                v-on:change="AllProducts"
                aria-controls="my-table"
                class="justify-content-center pt-5"
            ></b-pagination>
            </div>




        <!-- Modal -->
        <div class="modal fade" id="edit-product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form @submit.prevent="update" @keydown="form.onKeydown($event)" enctype="multipart/form-data">


                            <div class="mb-3">
                                <label for="name" class="form-label">Product name</label>
                                <input v-model="form.name" type="text" class="form-control" id="name">

                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea v-model="form.description" class="form-control" id="Description"/>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input v-model="form.price" type="number" class="form-control" id="price">

                            </div>
                            <div class="mb-3">
                                <select class=" form-control" v-model="form.category_id">
                                    <option selected>Open this select menu</option>
                                    <option v-for='categorey in Categories' :value='categorey.id'>{{ categorey.name }}</option>
                                </select>
                            </div>
                            <strong>File:</strong>
                            <input type="file" id="image" class="form-control" >
                            <div>
                                <img id="img">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
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
            products: [],
                    form: new Form({
                        name: '',
                        description: '',
                        price: '',
                        category_id: '',
                        main_image: '',

                    }),

                    Categories: [],
                    perPage: 100,
                    category_id:'',
                    name_product :'',
                    currentPage: 1,
                    rows:'',


        }
    },
    watch: {
        name_product(after, before) {
            this.AllProducts();
        },
        category_id(after, before) {
            this.AllProducts();
        }
    },
    mounted() {
        this.AllProducts()
        this.getCategories()
    },

    methods: {
        async AllProducts(currentPage) {
            console.log(this.name_product)
            await axios.get(`http://127.0.0.1:8000/api/products?page=${currentPage}
            &name=${this.name_product}&category_id=${this.category_id}`, header
            ).then(response => {
                this.products = response.data.data.products
                this.rows = response.data.data.pagination.total


            }).catch(error => {
                console.log(error)
                this.products = []
            })
        },
        async getCategories() {
            await axios.get('/api/categories', header
            ).then(response => {
                this.Categories = response.data.data.Categories


            }).catch(error => {
                console.log(error)
            })

        },
        async deleteItem(id) {


            axios.delete(`http://127.0.0.1:8000/api/products/${id}`, header).then((response) => {
                console.log(response)
                swal(response.data.message);
                setTimeout("location.reload(true);", 2000)

            });




        },




        edit(item){
            this.form.name = item.name
            this.form.description =item.description
            this.form.price =item.price
            this.form.category_id = item.category_id
            console.log(document.querySelector('#img').src= item.images)

            $("#edit-product").modal('show');

        }
    }
}
</script>

<style scoped>

</style>
