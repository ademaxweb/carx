<script setup>
import RoulettesList from "@/components/Roulettes/RoulettesList.vue";

const emits = defineEmits(['update-auth', 'update-me'])
const props = defineProps({
    me: {
        type: Object,
        default: null
    }
})

</script>

<template>
    <h1 class="block_header">Кейсы</h1>
    <suspense>
        <template #default>
            <roulettes-list></roulettes-list>
        </template>
        <template #fallback>
            <div>Загрузка...</div>
        </template>
    </suspense>
</template>

<style scoped>

</style>
