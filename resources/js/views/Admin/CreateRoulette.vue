<template>
<div>
    <h1 class="block_header">Создать кейс</h1>
    <form class="form w-50" @submit.prevent>
        <div class="form__input">
            <input type="text" placeholder="Название" v-model="roulette.name">
        </div>
        <div class="form__input">
            <input type="text" placeholder="Цена" v-model="roulette.price">
        </div>


        <div class="form__input">
            <input type="submit" value="Создать" class="button btn-primary" @click="submitForm" :disabled="!formCompleted">
<!--            <span v-for="err in errors" class="form__input__error">{{err}}</span>-->
        </div>
    </form>

    <h2 class="block_header">Выбранные авто:</h2>
    <ItemCardsGroup>
        <span v-if="!selectedCars.length">Пусто</span>
        <ItemCard
            v-for="(car, index) in selectedCars"
            :key="allCars[car].id"
        >
            <item-card-block>
                <div class="item_card__element item_card__image">
                    <img :src="allCars[car].image" alt="">
                </div>
            </item-card-block>
            <item-card-block>
                <item-card-block class="item_card__block--inline">
                    <h1 class="item_card__element">{{allCars[car].name}}</h1>
                    <span class="item_card__element">{{allCars[car].brand.name}}</span>
                </item-card-block>

                <item-card-block class="item_card__block--inline">
                    <span class="item_card__element">{{allCars[car].realise}}</span>
                    <span class="item_card__element">{{allCars[car].cost.toLocaleString()}} &#8381;</span>
                </item-card-block>



            </item-card-block>

            <item-card-block>
                <button @click="deselectCar(index)" class="button btn-danger item_card__element btn-full-width">Убрать</button>
                <router-link class="button btn-tertiary item_card__element" :to="{name: 'cars.info', params: {id: car}}">Подробнее</router-link>
            </item-card-block>
        </ItemCard>
    </ItemCardsGroup>



    <h2 class="block_header">Все авто:</h2>
    <ItemCardsGroup>
        <span v-if="!availableCars.length">Пусто</span>
        <ItemCard
            v-for="(car, index) in availableCars.sort((a,b) => allCars[a].id - allCars[b].id)"
            :key="allCars[car].id"
        >
            <item-card-block>
                <div class="item_card__element item_card__image">
                    <img :src="allCars[car].image" alt="">
                </div>
            </item-card-block>
            <item-card-block>
                <item-card-block class="item_card__block--inline">
                    <h1 class="item_card__element">{{allCars[car].name}}</h1>
                    <span class="item_card__element">{{allCars[car].brand.name}}</span>
                </item-card-block>

                <item-card-block class="item_card__block--inline">
                    <span class="item_card__element">{{allCars[car].realise}}</span>
                    <span class="item_card__element">{{allCars[car].cost.toLocaleString()}} &#8381;</span>
                </item-card-block>

            </item-card-block>

            <item-card-block>
                <button @click="selectCar(index)" class="button btn-primary item_card__element btn-full-width">Добавить</button>
                <router-link class="button btn-tertiary item_card__element" :to="{name: 'cars.info', params: {id: allCars[car].id}}">Подробнее</router-link>
            </item-card-block>
        </ItemCard>
    </ItemCardsGroup>
</div>
</template>

<script setup>
import ItemCard from "@/components/UI/item-card.vue";
import ItemCardsGroup from "@/components/UI/item-cards-group.vue";
import ItemCardBlock from "@/components/UI/item-card-block.vue";

import {ref, onMounted, watchEffect} from "vue";
import {isNumber} from "lodash";
import api from "../../api";

    const roulette = ref({
        name: '',
        price: ''
    })



    const formCompleted = ref(
        roulette.value.name.length > 0 && roulette.value.price.length > 0 && selectedCars.value.length > 0
    )

    watchEffect(()=>{
        formCompleted.value = roulette.value.name.length > 0 && roulette.value.price.length > 0 && selectedCars.value.length > 0
    })

    const submitForm = async () => {
        const data = {
            name: roulette.value.name,
            price: parseInt(roulette.value.price, 10),
            cars: selectedCars.value
        }
        console.log(data);
        try {
            const response = await api.createRoulette(data)
            console.log(response)
        } catch (e) {
            console.log(e)
        }
    }

    const allCars = ref({})
    const selectedCars = ref([])
    const availableCars = ref([])

    onMounted(async ()=>{
        try {
            const response = await api.cars()
            response.forEach(car => {
                allCars.value[car.id] = car
                availableCars.value.push(car.id)
            })
        } catch (e){
            console.log(e);
        }
    })

    const selectCar = (index) => {
        selectedCars.value.push(availableCars.value[index])
        availableCars.value.splice(index, 1)
    }
    const deselectCar = (index) => {
        availableCars.value.push(selectedCars.value[index])
        selectedCars.value.splice(index, 1)
    }

</script>

<style scoped>

</style>
