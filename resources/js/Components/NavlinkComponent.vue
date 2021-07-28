<template>
    <inertia-link :href="href" :class="classes">
        <slot></slot>
    </inertia-link>
</template>

<script>
export default {
    props: ['active', 'href'],
    computed: {
        classes(){
            return this.active ? 'bg-gray-500 p-2 text-xl w-full flex mt-16' : 'p-2 text-xl w-full flex mt-16'
        }
    }
}
</script>

<style scoped>

</style>
