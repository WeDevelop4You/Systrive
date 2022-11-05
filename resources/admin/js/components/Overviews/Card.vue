<template>
    <v-card
        v-bind="component.attributes"
        :loading="isLoading"
        :elevation="$config.elevation"
        :class="{'pb-2': !component.data.hasBody}"
        class="pt-2"
    >
        <v-toolbar
            dense
            :color="component.data.headerColor"
            :elevation="component.data.headerColor === 'transparent' ? 0 : 2"
            :class="{'mb-1': component.data.hasBody}"
            class="pl-4 pr-2"
        >
            <v-toolbar-title>
                {{ component.content.title }}
            </v-toolbar-title>
            <v-spacer />
            <component
                :is="component.data.header.componentName"
                v-if="component.data.header"
                :value="component.data.header"
            />
        </v-toolbar>
        <v-card-subtitle
            v-if="component.data.subtitle"
            class="pt-3"
        >
            <component
                :is="component.data.subtitle.componentName"
                v-if="component.data.subtitle"
                :value="component.data.subtitle"
            />
        </v-card-subtitle>
        <v-card-text
            v-if="component.data.body"
            :class="bodyClasses"
            class="pt-1"
        >
            <component
                :is="component.componentName"
                v-bind="component.attributes"
                v-for="component in component.data.body"
                :key="component.identifier"
                :value="component"
                @defaultAction="runDefaultAction"
            />
        </v-card-text>
        <v-card-actions v-if="component.data.footer">
            <component
                :is="component.data.footer.componentName"
                ref="button"
                :value="component.data.footer"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    import MainComponentBase from "../Base/MainComponentBase";

    export default {
        name: "Card",

        extends: MainComponentBase,

        computed: {
            bodyClasses() {
                return [
                    {'pb-1': this.component.data.hasFooter},
                    ...(this.component.data.additionalBodyClasses || [])
                ]
            },

            isLoading() {
                return this.component.data.hasLoadingBar && this.$loading ? 'primary' : false;
            }
        },

        methods: {
            runDefaultAction() {
                this.$refs.button.runDefaultAction()
            }
        }
    }
</script>
