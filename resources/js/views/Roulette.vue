<script setup>
    import RouletteInfo from "@/components/Roulettes/roulette-info.vue"
    const emits = defineEmits(['update-auth', 'update-me'])
    const props = defineProps({
        me: {
            type: Object,
            default: null
        }
    })
</script>
<template>
<div>
    <button class="button btn-secondary mt-25" @click="$router.back()">Назад</button>
    <suspense class="mt-25">
        <template #default>
            <roulette-info @update-me="emits('update-me')" :me="me"></roulette-info>
        </template>
        <template #fallback>
            <div>Загрузка</div>
        </template>
    </suspense>
</div>
</template>


<style scoped>

</style>
