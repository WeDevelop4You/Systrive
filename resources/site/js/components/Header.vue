<template>
    <section class="overflow-hidden">
        <div class="container" :style="{margin: space + 'px auto'}">
            <h1 class="text-center text-white" style="font-size: 4rem">{{ title }}</h1>
            <h4 class="text-center text-accent-1">{{ subtitle }}</h4>
        </div>
        <Wave class="w-100 h-auto" style="margin-bottom: -2px" line-color="#2f2f2f" fill-color="#ffffff"/>
        <div class="header-img">
            <img class="center-img" :src="picture" alt="header">
        </div>
    </section>
</template>

<script>
    import Wave from './svg/Wave-1'

    export default {
        name: "Header",

        components: {
            Wave,
        },

        props: {
            space: String,
            title: String,
            subtitle: String,
            picture: String,
        }
    }
</script>

<style scoped>

</style>
