<script setup>
import api from "./api";
import {ref, onBeforeMount} from "vue"

const access_token = ref(null)
const user = ref(null)

const getAccessToken = () => {
    access_token.value = localStorage.getItem('access_token')
}
const getMe = () => {
    api
        .me()
        .then(data => {
            user.value = data
        })
        .catch(error => {
            user.value = null
        })
}

const updateAuth = () => {
    getAccessToken()
    getMe()
}

onBeforeMount(() => {
    getAccessToken()
    getMe()
})

const sidebarActive = ref(false)
const showSidebarMainLinks = ref(true)
const showSidebarAdminLinks = ref(true)

const toggleSideBar = () => {
    sidebarActive.value = !sidebarActive.value
}

const offSideBar = () => {
    if (sidebarActive.value) sidebarActive.value = false
}

const toggleSidebarMainLinks = () => {
    showSidebarMainLinks.value = !showSidebarMainLinks.value
}
const toggleSidebarAdminLinks = () => {
    showSidebarAdminLinks.value = !showSidebarAdminLinks.value
}

</script>
<template>
    <div @click="offSideBar" class="wrapper">
        <header class="header">
            <div class="content">
                <div class="header__block">
                    <router-link class="header__logo link" :to="{name: 'index'}">
                        <h1>CarX</h1>
                    </router-link>
                </div>
                <div class="header__block">
                    <span @click.stop="toggleSideBar" class="sidebar__toggler--mobile button"><font-awesome-icon icon="fa-solid fa-bars" /></span>
                </div>
            </div>
        </header>

        <button @click.stop="toggleSideBar" class="sidebar__toggler button btn-danger "><font-awesome-icon icon="fa-solid fa-bars" /></button>
        <transition name="sidebar">
            <div class="sidebar" v-show="sidebarActive" @click.stop>
                <div :class="{'sidebar_links_block_header': true, 'links_block--collapsed': !showSidebarMainLinks}" @click="toggleSidebarMainLinks">
                    <h3>Основное</h3>
                    <font-awesome-icon icon="fa-solid fa-chevron-down" class="sidebar_links_arrow"/>
                </div>

                <transition name="links">
                <div class="sidebar__links" v-show="showSidebarMainLinks">
                    <router-link class="link sidebar__link" :to="{name: 'index'}">
                        <font-awesome-icon icon="fa-solid fa-house" />
                        <span>Главная</span>
                    </router-link>
                    <router-link class="link sidebar__link" :to="{name: 'store'}">
                        <font-awesome-icon icon="fa-solid fa-cart-shopping" />
                        <span>Магазин</span>
                    </router-link>
                    <router-link class="link sidebar__link" :to="{name: 'roulettes'}">
                        <font-awesome-icon icon="fa-solid fa-suitcase" />
                        <span>Кейсы</span>
                    </router-link>

                    <router-link v-if="access_token && user" class="link sidebar__link" :to="{name: 'user.profile', params: {id: user.id}}">
                        <font-awesome-icon icon="fa-solid fa-user" />
                        <span>Профиль</span>
                    </router-link>
                    <span v-if="access_token && user" class="sidebar__link">
                            <font-awesome-icon icon="fa-solid fa-dollar-sign" />
                            <span>{{user.balance.toLocaleString()}} &#8381;</span>
                        </span>
                    <router-link v-else class="link sidebar__link" :to="{name: 'auth.login'}">
                        <font-awesome-icon icon="fa-solid fa-right-to-bracket" />
                        <span>Авторизация</span>
                    </router-link>
                </div>
                </transition>


                <div v-if="access_token && user && user.admin" :class="{'sidebar_links_block_header': true, 'links_block--collapsed': !showSidebarAdminLinks}" @click="toggleSidebarAdminLinks">
                    <h3>Админка</h3>
                    <font-awesome-icon icon="fa-solid fa-chevron-down" class="sidebar_links_arrow"/>
                </div>

                <transition name="links">
                <div class="sidebar__links" v-if="access_token && user && user.admin" v-show="showSidebarAdminLinks">

                    <router-link class="link sidebar__link" :to="{name: 'admin.cars.create'}">
                        <font-awesome-icon icon="fa-solid fa-plus" />
                        <span>Создать авто</span>
                    </router-link>
                    <router-link class="link sidebar__link" :to="{name: 'admin.roulettes.create'}">
                        <font-awesome-icon icon="fa-solid fa-plus" />
                        <span>Создать кейс</span>
                    </router-link>

                </div>
                </transition>

            </div>
        </transition>

        <main>

            <div class="content">

                <router-view
                    @update-auth="updateAuth"
                    :me="user"
                    @update-me="getMe"
                >

                </router-view>
            </div>
        </main>
        <footer>
            <div class="content">

            </div>
        </footer>


    </div>
</template>



<style lang="scss" scoped>

    .wrapper{
        width: 100vw;
        height: 100vh;
    }

    .sidebar-enter-active,
    .sidebar-leave-active {
        transition: all 0.15s ease;
    }

    .sidebar-enter-from,
    .sidebar-leave-to {
        transform: translateX(-100%);
    }

    .links-enter-active,
    .links-leave-active {
        transition: all 0.15s ease;
    }

    .links-enter-from,
    .links-leave-to {
        opacity: 0;
        transform: translateY(-10px);
    }
</style>
