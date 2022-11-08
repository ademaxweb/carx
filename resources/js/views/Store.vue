<template>
<div>
    <h1 class="block_header">Магазин</h1>
    <item-cards-group class="mt-25">

        <item-card v-for="car in cars">
            <item-card-block>
                <div class="item_card__element item_card__image">
                    <img :src="car.image" alt="">
                </div>
            </item-card-block>
            <item-card-block>
                <item-card-block class="item_card__block--inline">
                    <h1 class="item_card__element">{{car.name}}</h1>
                    <span class="item_card__element">{{car.brand.name}}</span>
                </item-card-block>

                <item-card-block class="item_card__block--inline">
                    <span class="item_card__element">{{car.realise}}</span>
                </item-card-block>

            </item-card-block>

            <item-card-block>
                <button @click="buyCar(car.id)" class="button btn-primary item_card__element btn-full-width">{{car.cost.toLocaleString()}} &#8381;</button>
                <router-link class="button btn-tertiary item_card__element" :to="{name: 'cars.info', params: {id: car.id}}">Подробнее</router-link>
            </item-card-block>
        </item-card>

    </item-cards-group>
</div>
</template>

<script>
import api from "../api";
import swal from "sweetalert"
import itemCard from "../components/UI/item-card.vue";
import itemCardsGroup from "../components/UI/item-cards-group.vue";
import itemCardBlock from "../components/UI/item-card-block.vue";


export default {
    name: "Store",
    components: {itemCardsGroup, itemCard, itemCardBlock},
    data(){
        return {
            cars: []
        }
    },
    mounted() {
        api.cars().then(cars => this.cars = cars)
    },
    methods: {
        buyCar(carID){
            api.buyCar(carID)
                .then(response => {
                    swal({
                        title: response.success ? "Успешно" : "Ошибка",
                        icon: response.success ? "success" : "error",
                        text: response.message,
                    })
                    this.$emit('update-me')
                })

        }
    },
    props: {
        me: {
            type: Object,
            default: null
        }
    }
}
</script>

<style scoped>

</style>
