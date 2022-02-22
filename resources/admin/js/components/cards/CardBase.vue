<template>
    <v-card
        :elevation="$config.elevation"
        rounded="lg"
        outlined
    >
        <v-card-title class="gap-3 flex-nowrap justify-space-between">
            <span
                class="headline"
                style="width: max-content"
            >{{ title }}</span>
            <slot name="button" />
        </v-card-title>
        <v-card-subtitle
            v-if="$slots.subtitle"
            class="pt-3"
        >
            <slot name="subtitle" />
        </v-card-subtitle>
        <v-card-text :class="{'px-0': noPadding, 'pb-0': !noAction}">
            <slot />
        </v-card-text>
        <v-card-actions v-if="!noAction">
            <l-buttons>
                <slot name="action" />
            </l-buttons>
        </v-card-actions>
    </v-card>
</template>

<script>
    import LButtons from "../../layout/Buttons";

    export default {
        name: "CardBase",

        components: {
            LButtons,
        },

        props: {
            title: {
                required: true,
                type: String
            },

            noAction: {
                type: Boolean,
                default: false
            },

            noPadding: {
                type: Boolean,
                default: false
            },
        }
    }
</script>
