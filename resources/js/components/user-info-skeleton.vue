<template>
    <div>
        <h1 class="skeleton"></h1>
        <div class="info_block info_block--skeleton">
            <div class="info_block__group">
                <span class="info_block__group__elem--skeleton"></span>
                <span class="info_block__group__elem--skeleton"></span>
                <span class="info_block__group__elem--skeleton"></span>
            </div>
        </div>

        <div class="actions_group">
            <button class="button btn-info btn-inline" @click="updateUserInfo">Обновить</button>
            <button class="button btn-danger btn-inline" @click="logout">Выйти</button>
        </div>




        <!--    <span v-if="!user.cars.length">машин пока нет</span>АВЫФАФЫВ-->

    </div>
</template>

<style scoped>

</style>
