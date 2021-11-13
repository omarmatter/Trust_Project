<template>
    <div class="container">
        <form @submit.prevent="storeProduct" @keydown="form.onKeydown($event)" enctype="multipart/form-data">
            <div class="text-center text-success mt-5">
                <h1>Create Product</h1>
            </div>

            <div v-if="massegeErorr!= '' " class="alert alert-danger" role="alert">
                {{ massegeErorr }}
            </div>
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
            <input type="file" id="image" class="form-control" v-on:change="onFileChange">
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>

</template>

<script>
import Form from "vform";

const token = localStorage.getItem('token');
const header = {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'multipart/form-data'

    }
}
export default {
    data() {
        return {
            form: new Form({
                name: '',
                description: '',
                price: '',
                category_id: '',
                main_image: '',

            }),

            Categories: [],


            massegeErorr: ''


        }
    },

    created() {
        this.getCategories()
    },
    methods: {
        async getCategories() {
            await axios.get('/api/categories', header
            ).then(response => {
                this.Categories = response.data.data.Categories


            }).catch(error => {
                console.log(error)
            })

        },
        onFileChange(e) {
            console.log(e.target.files[0]);
            this.form.main_image = e.target.files[0];
        },


        async storeProduct() {
            console.log(header)
            let formData = new FormData();

            formData.append('main_image', this.form.main_image);
            formData.append('name', this.form.name)
            formData.append('price', this.form.price)
            formData.append('description', this.form.description)
            formData.append('category_id', this.form.category_id)

            await axios.post('http://127.0.0.1:8000/api/products', formData, header)
                .then(response => {
                    this.form.reset()
                    swal(response.data.message);


                }).catch(error => {
                    console.log(error.response.data)
                    this.massegeErorr = error.response.data.data

                })
        }
    }
}

</script>

<style scoped>

</style>
