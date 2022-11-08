<template>
    <div class="info_block">


        <div class="info_block__group group-inline">
            <div class="info_block__group__elem with_image">
                <img :src="car.image" :alt="car.name || 'Изображение неизвестного автомобиля'">
            </div>
        </div>

        <div class="info_block__group group-inline">
            <div class="info_block__group">
                <div class="info_block__group__elem">
                    <h1>{{car.name}}</h1>
                </div>
                <div class="info_block__group__elem">
                    <router-link :to="{name: 'index'}" class="link"><h2>{{car.brand.name}}</h2></router-link>
                </div>
            </div>

            <div class="info_block__group group-align-right">
                <div class="info_block__group__elem">
                    <h2>{{car.cost.toLocaleString()}} &#8381;</h2>
                </div>
            </div>

        </div>

        <div class="info_block__group group-mt">
            <div class="info_block__elem">
                <span>Год выпуска: {{car.realise}}</span>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: "car-info",
    props: {
        car: Object
    }
}
</script>

<style scoped>

</style>
