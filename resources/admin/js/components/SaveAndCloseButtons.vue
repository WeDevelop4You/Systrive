<template>
    <fragment>
        <v-btn
            small
            text
            :disabled="$loading"
            @click="$emit('close')"
        >
            {{ $vuetify.lang.t('$vuetify.word.cancel.cancel') }}
        </v-btn>
        <v-btn
            small
            color="primary"
            :disabled="$loading"
            @click="$emit('save')"
        >
            {{ $vuetify.lang.t('$vuetify.word.save') }}
        </v-btn>
    </fragment>
</template>

<script>
    import {Fragment} from "vue-fragment";

    export default {
        name: "SaveAndCloseButtons",

        components: {
            Fragment
        }
    }
</script>
