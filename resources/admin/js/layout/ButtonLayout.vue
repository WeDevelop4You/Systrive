<template>
    <v-row
        no-gutters
        :class="{'pb-3': !noPadding, 'mx-2': !noMargin}"
        class="gap-3 justify-end"
    >
        <slot />
    </v-row>
</template>

<script>
    export default {
        name: "Buttons",

        props: {
            noPadding: {
                type: Boolean,
                default: false,
            },

            noMargin: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
