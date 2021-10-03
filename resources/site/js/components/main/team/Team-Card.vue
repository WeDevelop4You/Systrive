<template>
    <div :class="amount" style="margin-bottom: 1.5rem; min-width: 285px; max-width: 315px">
        <div class="card card-body align-items-center h-100 bg-accent-1 border-accent-1 text-white p-0">
            <span class="badge badge-primary badge-top" v-if="work_function === 'CEO'">Founder</span>
            <div class="card-img-top overflow-hidden position-relative h-100" style="max-height: 300px">
                <div class="team-img">
                    <img class="card-img rounded-0" :src="image" alt=" ">
                </div>
                <Wave class="position-absolute h-auto" style="bottom: -1px; left: 0; width: 105%; margin-left: -2.5%" line-color="#ffffff" fill-color="#2f2f2f"/>
            </div>
            <h5 class="mb-0">{{ name }}</h5>
            <span>{{ work_function }}</span>
            <div class="card-text px-2" v-html="text"></div>
        </div>
    </div>
</template>

<script>
    import Wave from '../../svg/Wave-1'

    export default {
        name: "Team-Card",

        components: {
            Wave,
        },

        props: {
            amount: String,
            work_function: String,
            image: String,
            name: String,
            text: String
        }
    }
</script>

<style scoped>

</style>
