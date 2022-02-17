<template>
    <v-row
        no-gutters
        :class="{'pb-3': !noPadding}"
        class="gap-3 justify-end px-2"
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
            }
        }
    }
</script>
