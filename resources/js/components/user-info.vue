<script setup>
import api from "@/api";
import ItemCardsGroup from "@/components/UI/item-cards-group.vue";
import ItemCard from "@/components/UI/item-card.vue";
import ItemCardBlock from "@/components/UI/item-card-block.vue";
import swal from "sweetalert";
import {reactive, ref, watch, watchEffect} from "vue";
import {useRoute, useRouter} from 'vue-router'

const emits = defineEmits(['update-auth', 'update-me'])
const props = defineProps({
    me: {
        type: Object,
        default: {
            id: 0
        }
    }
})


const router = useRouter()
const route = reactive(useRoute())
const userID = ref(route.params.id)



const getUserInfo = () => {
    return new Promise(resolve => {
        setTimeout(()=>{
            resolve(api.userById(userID.value))
        }, 1000)
    })
}

const user = ref(await getUserInfo())

const updateUserInfo = async () => {
    user.value = await getUserInfo()
}

const logout = async () => {
    const success_logout = await api.logout()
    emits('update-auth')
    router.push({
        name: 'auth.login'
    })
}

const sellcar = (index) => {
    const car = user.value.cars[index]

    api
        .sellCar(car.id)
        .then(response => {
            if (response.success) {
                user.value.balance += car.model.cost * 0.5
                user.value.cars.splice(index, 1)
                user.value.owning_cars--
                emits('update-me')
            }
            swal({
                title: response.success ? 'Успешно!' : 'Ошибка!',
                icon: response.success ? 'success' : 'error',
                text: response.message
            })
        })
        .catch(error => {
            console.log(error);
            swal({
                title: 'Ошибка!',
                icon: 'error',
                text: `Перезагрузите страницу и попробуйте еще раз.\nКод ошибки: ${error.status}.`
            });
        })
}

const isMyProfile = ref(user.value.id === props.me.id)

const userActions = reactive([
    {
        name: 'update',
        label: 'Обновить',
        icon: ['fa-solid', 'fa-rotate-right'],
        show: true,
        callback: updateUserInfo,
        classes: {
            'button': true,
            'btn-info': true,
        },
        disabled: false,
    },
    {
        name: 'logout',
        label: 'Выйти',
        icon: ['fa-solid', 'fa-right-from-bracket'],
        show: isMyProfile,
        callback: logout,
        classes: {
            'button': true,
            'btn-danger': true,
        },
        disabled: isMyProfile,
        disabledReverse: true
    },
])

watch(route, async (newValue, oldValue) => {
    if (newValue.name === 'user.profile'){
        userID.value = newValue.params.id
        await updateUserInfo()
        isMyProfile.value = user.value.id === props.me.id
    }
});

</script>

<template>
    <div>
        <h1>Профиль пользователя {{ user.name }}</h1>
        <div class="info_block">
            <div class="info_block__group">
                <span class="info_block__group__elem">Почта: {{ user.email }}</span>
                <span class="info_block__group__elem">Баланс: {{ user.balance.toLocaleString() }} &#8381;</span>
                <span class="info_block__group__elem">Машин в собственности: {{ user.owning_cars }} </span>
            </div>
        </div>

        <div class="actions_group">
<!--            <button class="button btn-info btn-inline" @click="updateUserInfo">Обновить</button>-->
<!--            <button class="button btn-danger btn-inline" @click="logout">Выйти</button>-->
            <button
                v-for="action in userActions"
                :key="action.name"
                @click="action.callback"
                :class="action.classes"
                :disabled="action.disabledReverse ? !action.disabled : action.disabled"
                v-show="action.show"
            >
                <font-awesome-icon v-if="action.icon" :icon="action.icon" />
                <span>{{ action.label }}</span>
            </button>
        </div>

        <h1 class="block_header" v-if="user.cars.length">Гараж:</h1>
        <h2 class="block_header" v-else>Гараж пока пуст</h2>



        <ItemCardsGroup>
            <ItemCard
                v-for="(car, index) in user.cars"
            >
                <item-card-block>
                    <div class="item_card__element item_card__image">
                        <img :src="car.model.image" alt="">
                    </div>
                </item-card-block>
                <item-card-block>
                    <item-card-block class="item_card__block--inline">
                        <h1 class="item_card__element">{{car.model.name}}</h1>
                        <span class="item_card__element">{{car.model.brand.name}}</span>
                    </item-card-block>

                    <item-card-block class="item_card__block--inline">
                        <span class="item_card__element">{{car.model.realise}}</span>
                    </item-card-block>

                </item-card-block>

                <item-card-block>
                    <button
                        class="button btn-primary item_card__element btn-full-width"
                        @click="sellcar(index)"
                        v-if="isMyProfile"
                    >
                        {{car.model.cost.toLocaleString()}} &#8381;
                    </button>
                    <router-link class="button btn-tertiary item_card__element" :to="{name: 'cars.info', params: {id: car.model.id}}">Подробнее</router-link>
                </item-card-block>
            </ItemCard>
        </ItemCardsGroup>

    </div>
</template>



<style scoped>

</style>
