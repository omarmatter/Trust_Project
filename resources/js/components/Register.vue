<template>
    <div style="margin-top: 100px">


        <form @submit.prevent="saveForm" @keydown="form.onKeydown($event)" class="container">

            <div class="text-center" style="color: green ; font-size: 20px; font-family: monospace; font-weight: bold">
                Register
            </div>
            <span class="text-danger" v-if="errors.length>0">{{ errors }}</span>
            <div v-if="massegeSuccess!= '' " class="alert alert-success" role="alert">
                {{ massegeSuccess }}
            </div>

            <div class="form-group">
                <input v-model="form.name" type="text" name="name" placeholder="Username" class="form-control m-2">


            </div>
            <div class="form-group">
                <input v-model="form.email" type="email" name="email" placeholder="Email" class="form-control  m-2">
            </div>
            <div class="form-group">
                <input v-model="form.phone_number" type="text" name="phone_number" placeholder="Phone"
                       class="form-control  m-2">
            </div>
            <div class="form-group">
                <input v-model="form.password" type="text" name="password" placeholder="Password"
                       class="form-control  m-2">

            </div>
            <div class="form-group ">
                <input type="radio" name="gender" value="M" class="m-1 " v-model="form.gender"><label>Male</label>
                <input type="radio" name="gender" value="F" class="m-1" v-model="form.gender"><label>Female</label>
            </div>
            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-success  w-25 ">
                    Register
                </button>

            </div>
        </form>
    </div>
</template>

<script>
import Form from "vform";

export default {


    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                phone_number: '',
                gender: '',
                password: '',


            }),
            errors: [],


        }
    },
    methods: {
        async saveForm() {
            console.log(this.form)

            axios.post('http://127.0.0.1:8000/api/auth/register', this.form).then((res) => {
                this.massegeSuccess = res.data.message
                setTimeout(() => {
                    this.$router.push({name: "Login"})
                }, 2000);

            }).catch((error) => {

                this.errors = error.response.data.data
                console.log(this.errors)
            })
        }
    }
}
</script>

