<template>
    <h1><i class="las la-bars" />{{ $vuetify.lang.t('$vuetify.word.dashboard') }}</h1>
</template>

<script>
    export default {
        name: "Dashboard",

        // created() {
        //     this.$api.call({
        //         url: this.$api.route('git.repositories', 'gitlab'),
        //         method: "GET",
        //     })
        // }
    }
</script>
