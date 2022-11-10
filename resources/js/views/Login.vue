<template>
<div>
    <h1 class="center">Авторизация</h1>
    <form class="form w-50" @submit.prevent v-if="!access_token">
        <div class="form__input">
            <input type="text" placeholder="E-Mail" v-model="authData.email">
        </div>
        <div class="form__input">
            <input type="text" placeholder="Пароль" v-model="authData.password">
        </div>

        <div class="form__input">
            <input type="submit" value="Войти" class="button btn-primary" @click="submitForm" :disabled="disableFormSubmit">
            <span v-if="errors.form" class="form__input__error">{{errors.form}}</span>
        </div>

    </form>

    <router-link :to="{name: 'auth.signup'}" class="link center">Регистрация</router-link>
</div>
</template>

<script>
export default {
    name: "Login",
    data(){
        return {
            errors: {
                form: null
            },
            authData: {
                email: null,
                password: null,
            },
            access_token: null
        }
    },
    computed: {
      disableFormSubmit(){
          return !(this.authData.email && this.authData.password);
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

            axios
                .post('/api/auth/login', {
                    email: this.authData.email,
                    password: this.authData.password
                })
                .then(response => {
                    let data = response.data
                    if (data.access_token) {
                        localStorage.setItem('access_token', data.access_token)
                        this.access_token = data.access_token
                        this.$emit('update-auth')
                        this.$router.push({name: 'index'})
                    }
                })
                .catch(err => {
                    let errorData = err.response
                    this.authData.password = ""
                    switch (errorData.status){
                        case 401:
                            this.errors.form = errorData.data.error
                            break;
                        default:
                            break;
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
