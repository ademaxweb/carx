<template>
    <div class="item_card">
        <slot></slot>
    </div>
</template>

<script>
import itemCardBlock from "./item-card-block.vue";
export default {
    name: "item-card",
    components: {itemCardBlock}
}
</script>

<style scoped>

</style>
