<template>
<div>
    <h1 class="center">Регистрация</h1>
    <form class="form w-50" @submit.prevent v-if="!access_token">

        <div class="form__input">
            <input type="text" placeholder="Имя пользователя" v-model="authData.name">
        </div>
        <div class="form__input">
            <input type="text" placeholder="E-Mail" v-model="authData.email">
        </div>
        <div class="form__input">
            <input type="text" placeholder="Пароль" v-model="authData.password">
        </div>
        <div class="form__input">
            <input type="text" placeholder="Повторите пароль" v-model="authData.password_confirm">
        </div>

        <div class="form__input">
            <input type="submit" value="Войти" class="button btn-primary" @click="submitForm" :disabled="disableFormSubmit">
            <span v-if="errors.form" class="form__input__error">{{errors.form}}</span>
        </div>



    </form>
    <div class="container">
        <router-link :to="{name: 'auth.login'}" class="link center">Уже есть аккаунт</router-link>
    </div>

</div>
</template>

<script>
import api from "../api";

export default {
    name: "Signup",
    data (){
        return {
            authData: {
                name: null,
                email: null,
                password: null,
                password_confirm: null
            },
            access_token: null,
            errors: {
                form: null
            }
        }
    },
    computed: {
        disableFormSubmit(){
            return !(this.authData.email && this.authData.password && this.authData.password === this.authData.password_confirm && this.authData.name);
        }
    },
    mounted() {
        this.access_token = localStorage.getItem('access_token')
    },
    methods: {
        submitForm(){
            if (this.disableFormSubmit) return false;

            this.errors = {
                form: null
            }


            api
                .register({
                    name: this.authData.name,
                    email: this.authData.email,
                    password: this.authData.password
                })
                .then(response => {
                    console.log(response);
                    if (response.success){
                        localStorage.setItem('access_token', response.access_token)
                        this.$emit('update-auth')
                        this.$router.push({name: 'index'})
                    } else {
                        this.errors.form = response.message
                    }
                })
                .catch(error => {
                    this.authData.password = ""
                })
            // axios
            //     .post('/api/auth/login/', {
            //         email: this.authData.email,
            //         password: this.authData.password
            //     })
            //     .then(response => {
            //         let data = response.data
            //         if (data.access_token) {
            //             localStorage.setItem('access_token', data.access_token)
            //             this.access_token = data.access_token
            //             this.$emit('update-auth')
            //             this.$router.push({name: 'index'})
            //         }
            //     })
            //     .catch(err => {
            //         let errorData = err.response
            //         this.authData.password = ""
            //         switch (errorData.status){
            //             case 401:
            //                 this.errors.form = errorData.data.error
            //                 break;
            //             default:
            //                 break;
            //         }
            //     })
        }
    }
}
</script>

<style scoped>

</style>
