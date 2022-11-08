<template>
    <div>
        <form class="form w-50" @submit.prevent>
            <div class="form__input">
                <input type="text" placeholder="Название" v-model="car.name">
            </div>
            <div class="form__input">
                <input type="text" placeholder="Марка" v-model="car.brand">
            </div>
            <div class="form__input">
                <input type="text" placeholder="Цена" v-model="car.cost">
            </div>
            <div class="form__input">
                <input type="text" placeholder="Год выпуска" v-model="car.release">
            </div>
            <div class="form__input">
                <input type="text" placeholder="Изображение" v-model="car.image">
            </div>
            <div class="form__input">
                <input type="submit" value="Создать" class="button btn-primary" @click="submitForm">
                <span v-for="err in errors" class="form__input__error">{{err}}</span>
            </div>
        </form>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "Create-car",
    data(){
        return {
            car: {
                name: '',
                brand: '',
                cost: '',
                release: '',
                image: ''
            },
            errors: []
        }
    },
    methods: {
        submitForm(){
            if (this.car.name && this.car.brand && this.car.cost && this.car.release){
                this.errors = []

                const data = {
                    name: this.car.name,
                    brand: this.car.brand,
                    cost: parseInt(this.car.cost, 10),
                    realise: parseInt(this.car.release, 10),
                    image: this.car.image || 'no_image_1920_x_1080.jpg'
                }

                axios.post("/api/cars/create", data)
                    .then(res => {
                        this.car = {
                            name: '',
                            brand: this.car.brand,
                            cost: '',
                            release: this.car.release,
                            image: this.car.image
                        }
                        console.log(res);
                    })
                    .catch(err => {
                        if (err.response.status === 404) return this.addFormError(`Марка "${this.car.brand}" не найдена.`)
                        console.log(err);
                    })
            }
            else return this.addFormError("Не все поля заполнены")
        },
        deleteFormError()
        {
            return this.errors.shift()
        },
        addFormError(text){
            if (this.errors.length >= 3) this.errors.shift()
            this.errors.push(text)
            setTimeout(this.deleteFormError, 5000)
        }
    }
}
</script>

<style scoped>

</style>
