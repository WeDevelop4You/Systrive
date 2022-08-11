<template>
    <v-card
        v-bind="value.attributes"
        :loading="isLoading"
        :elevation="$config.elevation"
        :class="{'pb-2': !value.data.hasBody}"
        class="pt-2"
    >
        <v-toolbar
            dense
            :color="value.data.headerColor"
            :elevation="value.data.headerColor === 'transparent' ? 0 : 2"
            :class="{'mb-1': value.data.hasBody}"
            class="pl-4 pr-2"
        >
            <v-toolbar-title>
                {{ value.content.title }}
            </v-toolbar-title>
            <v-spacer />
            <component
                :is="value.data.header.componentName"
                v-if="value.data.header"
                :value="value.data.header"
            />
        </v-toolbar>
        <v-card-subtitle
            v-if="value.data.subtitle"
            class="pt-3"
        >
            <component
                :is="value.data.subtitle.componentName"
                v-if="value.data.subtitle"
                :value="value.data.subtitle"
            />
        </v-card-subtitle>
        <v-card-text
            v-if="value.data.body"
            :class="bodyClasses"
            class="pt-0"
        >
            <component
                :is="component.componentName"
                v-for="component in value.data.body"
                :key="component.identifier"
                :value="component"
                @defaultAction="runDefaultAction"
            />
        </v-card-text>
        <v-card-actions v-if="value.data.footer">
            <component
                :is="value.data.footer.componentName"
                ref="button"
                :value="value.data.footer"
            />
        </v-card-actions>
    </v-card>
</template>

<script>
    import ComponentProperties from "../../mixins/ComponentProperties";
    import ComponentError from "../ComponentError.vue";
    import SkeletonList from "../../layout/Skeletons/SkeletonList.vue";
    import SkeletonDataTable from "../../layout/Skeletons/SkeletonDataTable.vue";

    export default {
        name: "Card",

        components: {
            Btn: () => import('../Buttons/Btn.vue'),
            IconBtn: () => import('../Buttons/IconBtn.vue'),
            MultipleBtn: () => import('../Buttons/MultipleBtn.vue'),

            Content: () => import('../Items/Text.vue'),
            List: () => ({
                component: import('./List.vue'),
                loading: SkeletonList,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
            Table: () => ({
                component: import('../Overviews/Table.vue'),
                loading: SkeletonDataTable,
                delay: 0,
                error: ComponentError,
                timeout: 10000
            }),
            Chart: () => import('./Chart.vue'),
            FormLayout: () => import('../Forms/Form.vue'),
            Navbar: () => import('../Navbar/Navbar.vue'),
            CustomFormLayout: () => import('../Forms/CustomForm.vue'),

            Row: () => import('../Layouts/Row.vue')
        },

        mixins: [
            ComponentProperties
        ],

        computed: {
            bodyClasses() {
                return [
                    {'pb-0': this.value.data.hasFooter},
                    ...(this.value.data.additionalBodyClasses || [])
                ]
            },

            isLoading() {
                return this.value.data.hasLoadingBar && this.$loading ? 'primary' : false;
            }
        },

        methods: {
            runDefaultAction() {
                this.$refs.button.runDefaultAction()
            }
        }
    }
</script>
