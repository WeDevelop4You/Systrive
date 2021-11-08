<template>
    <div>
        {{ company }}
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Dashboard",

        computed: {
            ...mapGetters({
                company: 'company/data',
            })
        },
    }
</script>
