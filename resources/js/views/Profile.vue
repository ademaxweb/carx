<script setup>
import userInfo from "@/components/user-info.vue";
import userInfoSkeleton from "@/components/user-info-skeleton.vue";


const emits = defineEmits(['update-auth', 'update-me'])
const props = defineProps({
    me: {
        type: Object,
        default: null
    }
})


</script>

<template>
    <suspense>
        <template #default>
            <user-info
                @update-auth="emits('update-auth')"
                @update-me="emits('update-me')"
                :me="me"
            >

            </user-info>
        </template>
        <template #fallback>
            <user-info-skeleton></user-info-skeleton>
        </template>
    </suspense>
</template>



<style scoped>

</style>
