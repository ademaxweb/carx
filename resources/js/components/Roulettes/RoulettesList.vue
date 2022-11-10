<script setup>
    import api from "@/api";
    import {ref, onMounted} from "vue";
    import ItemCard from "@/components/UI/item-card.vue";
    import ItemCardsGroup from "@/components/UI/item-cards-group.vue";
    import ItemCardBlock from "@/components/UI/item-card-block.vue";


    const roulettes = ref(await api.getRoulettes())

</script>

<template>
    <div>
        <item-cards-group class="mt-25">
                    <item-card
                        v-for="roulette in roulettes"
                    >
                        <item-card-block>
                            <div class="item_card__element item_card__image">
                                <img src="https://ademaxweb.ru/storage/images/no_image_1920_x_1080.jpg" alt="">
                            </div>
                        </item-card-block>
                        <item-card-block>
                            <h2 class="item_card__element center">{{roulette.name}}</h2>
                        </item-card-block>

                        <item-card-block>
                            <router-link
                                class="button btn-primary"
                                :to="{
                                    name: 'roulette',
                                    params: {
                                        id: roulette.id
                                    }
                                }"
                            >
                                {{ roulette.price.toLocaleString() }} &#8381;
                            </router-link>
                        </item-card-block>
                    </item-card>
        </item-cards-group>
    </div>
</template>



<style scoped>

</style>
