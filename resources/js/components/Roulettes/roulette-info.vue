<script setup>
import api from "@/api";
import {reactive, ref, watchEffect} from "vue";
import {useRouter, useRoute} from "vue-router";
import ItemCardBlock from "@/components/UI/item-card-block.vue";
import ItemCardsGroup from "@/components/UI/item-cards-group.vue";
import ItemCard from "@/components/UI/item-card.vue";
import swal from "sweetalert";

const router = useRouter();
const route = useRoute();

const emits = defineEmits(['update-me', 'update-auth'])
const props = defineProps({
    me: {
        type: Object,
        default: null
    }
})


const rouletteID = ref(route.params.id)



const roulette = ref(await api.getRoulette(rouletteID.value))

const buyRouletteButtonDisabled = ref(props.me.balance < roulette.value.price)//

watchEffect(()=>{
    buyRouletteButtonDisabled.value = props.me.balance < roulette.value.price
})

const openRoulette = async () => {
    console.log(props.me)
    if (buyRouletteButtonDisabled.value) return swal({
        icon: 'error',
        title: "Ошибка!",
        text: "Этот кейс Вам недоступен"
    })

    try {
        const response = await api.openRoulette(rouletteID.value)
        if (response.success) {
            swal({
                title: `${response.data.item.brand.name} ${response.data.item.name}`,
                icon: response.data.item.image
            })
            return emits('update-me')
        } else return throwErr ({data: {message: "Неизвестная ошибка!"}})
    } catch (error) {
        const data = error.data
        return swal({
            icon: 'error',
            title: "Ошибка!",
            text: data.message
        })
    }
    // swal({
    //     title: `${roulette.value.cars[1].brand.name} ${roulette.value.cars[1].name}`,
    //     icon: roulette.value.cars[1].image
    // })
}

</script>

<template>
    <div>
        <div class="info_block">


            <div class="info_block__group group-inline">

            </div>

            <div class="info_block__group group-inline">
                <div class="info_block__group">
                    <div class="info_block__group__elem">
                        <h1>{{roulette.name}}</h1>
                    </div>
                </div>

                <div class="info_block__group group-align-right">
                    <div class="info_block__group__elem">
                        <h2>{{roulette.price.toLocaleString()}} &#8381;</h2>
                    </div>
                </div>

            </div>

            <div class="info_block__group group-mt">
                <div class="info_block__elem">
                    <button
                        @click="openRoulette"
                        class="button btn-primary btn-full-width" :disabled="buyRouletteButtonDisabled">Открыть</button>
                </div>
            </div>


        </div>

        <h2 class="block_header">Возможные награды:</h2>
        <item-cards-group class="mt-25">
            <item-card
                v-for="car in roulette.cars"
                class="item_card"
            >
                <item-card-block>
                    <div class="item_card__element item_card__image">
                        <img :src="car.image" alt="">
                    </div>
                    <item-card-block class="item_card__block--inline">

                        <h1 class="item_card__element">{{car.name}}</h1>
                        <span class="item_card__element">{{car.realise}}</span>

                    </item-card-block>

                    <item-card-block class="item_card__block--inline">
                        <span class="item_card__element">{{car.brand.name}}</span>
                        <span class="item_card__element">{{car.cost.toLocaleString()}} &#8381;</span>
                    </item-card-block>

                </item-card-block>

                <item-card-block>
                    <router-link class="button btn-tertiary item_card__element" :to="{name: 'cars.info', params: {id: car.id}}">Подробнее</router-link>
                </item-card-block>
            </item-card>
        </item-cards-group>
    </div>
</template>


<style scoped>

</style>
