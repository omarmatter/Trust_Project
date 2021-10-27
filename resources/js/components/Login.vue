<template>
    <div class="container" style="margin-top: 100px">
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
            <div class="form-group">
                <input v-model="form.email" type="email" name="email" placeholder="Email" class="form-control m-2 ">
            </div>
            <div class="form-group">
                <input v-model="form.password" type="password" name="password" placeholder="Password"
                       class="form-control m-2 ">
            </div>
            <div class="text-center p-3"><span class="text-danger" v-if="errors!= '' ">{{ errors }}</span></div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">
                    Log In
                </button>
                <router-link class="btn btn-success" to="Register">Register</router-link>
            </div>
        </form>
    </div>
</template>

<script>
import Form from 'vform'


export default {
    data: () => ({
        form: new Form({
            username: '',
            password: ''
        }),
        errors: ""
    }),

    methods: {
        async login() {
            axios.post('http://127.0.0.1:8000/api/auth/login', this.form).then((res) => {
                localStorage.setItem('token', res.data.data.token);
                this.$router.push({name: "index"});

            }).catch((error) => {
                console.log(error.response.data.message)
                this.errors = error.response.data.message;

            })
        }
    }
}
</script>
