<template>
    <div>
        <button class="button btn-secondary btn-inline" @click="$router.back()">Назад</button>
        <button class="button btn-secondary btn-inline" @click="$router.push({name: 'store'})">В магазин</button>
        <car-info v-if="car" :car="car"></car-info>
        <button
            v-if="car && user"
            class="button btn-primary btn-full-width"
            @click="buyCar"
            :disabled="user.balance < car.cost"
        >
            {{ car.cost.toLocaleString() || "?"}} &#8381;
        </button>
    </div>
</template>

<script>
import api from "../api";
import carInfo from "../components/car-info.vue";
import swal from "sweetalert";

export default {
    name: "Car",
    components: {carInfo},
    data() {
        return {
            car: null,
            user: null
        }
    },
    methods: {
        getCarInfo(id) {
            api.carById(id)
                .then(car => {
                    this.car = car
                })
                .catch(error => console.log(error))
        },
        buyCar(){
            swal({
                icon: "warning",
                dangerMode: true,
                title: "Внимание!",
                text: `Вы уверены, что хотите купить ${this.car.brand.name} ${this.car.name}?\nОстаток средств на балансе после покупки: ${(this.user.balance - this.car.cost).toLocaleString()}`,
                buttons: {
                    cancel: "Отмена",
                    confirm: "Подтвердить"
                }
            }).then(value => {

                    if (value) {
                        this.user.balance -= this.car.cost
                        this.$emit('update-me')
                        api.buyCar(this.car.id)
                            .then(response => {
                                swal({
                                    title: response.success ? "Успешно" : "Ошибка",
                                    icon: response.success ? "success" : "error",
                                    text: response.message,
                                })
                            })
                    }
                })

        }
    },
    mounted() {
        this.getCarInfo(this.$route.params.id)
        api.me().then(response => this.user = response)
    }
}
</script>

<style scoped>

</style>
