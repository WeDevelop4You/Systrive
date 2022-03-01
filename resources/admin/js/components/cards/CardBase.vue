<template>
    <v-card
        :color="color"
        :outlined="!noOutlined"
        :elevation="$config.elevation"
        :rounded="noRounded ? '0' : 'lg'"
        :loading="isLoading ? 'primary' : undefined"
    >
        <v-toolbar
            dense
            :color="headerColor"
            :elevation="headerColor === 'transparent' ? 0 : 2"
            class="px-2"
        >
            <v-toolbar-title>
                {{ title }}
            </v-toolbar-title>
            <v-spacer />
            <div>
                <slot name="button" />
            </div>
        </v-toolbar>
        <v-card-subtitle
            v-if="$slots.subtitle"
            class="pt-3"
        >
            <slot name="subtitle" />
        </v-card-subtitle>
        <v-card-text
            :class="{'px-0': noPadding, 'pb-0': $slots.actions}"
            class="pt-0"
        >
            <slot />
        </v-card-text>
        <v-card-actions v-if="$slots.actions">
            <l-buttons>
                <slot name="actions" />
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

            color: {
                type: String,
                default: undefined
            },

            headerColor: {
                type: String,
                default: "transparent"
            },

            isLoading: {
                type: Boolean,
                default: false,
            },

            noPadding: {
                type: Boolean,
                default: false
            },

            noRounded: {
                type: Boolean,
                default: false,
            },

            noOutlined: {
                type: Boolean,
                default: false,
            }
        }
    }
</script>
