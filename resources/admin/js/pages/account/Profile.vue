<template>
    <div>
        {{ $auth.user() }}
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        name: "Profile",
    }
</script>
