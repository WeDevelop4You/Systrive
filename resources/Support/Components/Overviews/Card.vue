<template>
    <v-card
        v-bind="component.attributes"
        :loading="isLoading"
        :elevation="$config.elevation"
        :class="{'pb-2': !component.data.hasBody}"
        class="pt-2"
    >
        <!--        <v-toolbar-->
        <!--            v-if="component.data.hasHeader"-->
        <!--            :color="component.data.headerColor"-->
        <!--            :elevation="component.data.headerColor === 'transparent' ? 0 : 2"-->
        <!--            :class="{'mb-1': component.data.hasBody}"-->
        <!--            dense-->
        <!--            class="pl-4 pr-2"-->
        <!--        >-->
        <!--        </v-toolbar>-->
        <component
            :is="component.data.header.componentName"
            v-if="component.data.hasHeader"
            :value="component.data.header"
        />
        <v-card-subtitle
            v-if="component.data.hasSubBody"
            class="pt-3"
        >
            <component
                :is="component.data.subBody.componentName"
                :value="component.data.subBody"
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
            />
        </v-card-text>
        <v-card-actions
            v-if="component.data.footer"
            class="px-4"
        >
            <component
                :is="component.data.footer.componentName"
                :value="component.data.footer"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    import CardHeaderComponent from "../Misc/CardHeader.vue";
    import MainComponentBase from "../Base/MainComponentBase";

    export default {
        name: "Card",

        components: {
            CardHeaderComponent
        },

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
        }
    }
</script>
