<template>
    <div :class="amount" style="margin-bottom: 1.5rem; min-width: 285px; max-width: 315px">
        <div class="card card-body align-items-center h-100 bg-accent-1 border-accent-1 text-white p-0">
            <div class="card-img-top overflow-hidden position-relative" style="max-height: 300px">
                <div class="team-img" style="max-height: 145.55px">
                    <img class="card-img rounded-0" :src="image" alt=" ">
                </div>
                <Wave class="position-absolute h-auto" style="bottom: -1px; left: 0; width: 105%; margin-left: -2.5%" line-color="#ffffff" fill-color="#2f2f2f"/>
            </div>
            <a :href="link" class="text-white text-center text-decoration-none" target="_blank">
                <h6 class="m-2">{{ name }}</h6>
            </a>
        </div>
    </div>
</template>

<script>
    import Wave from "../../svg/Wave-1";

    export default {
        name: "Work-card",

        components: {
            Wave,
        },

        props: {
            amount: String,
            image: String,
            name: String,
            link: String,
        }
    }
</script>

<style scoped>

</style>
