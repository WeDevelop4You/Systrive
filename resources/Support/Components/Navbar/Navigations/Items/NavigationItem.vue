<template>
    <tooltip
        v-slot="{tooltip}"
        :value="component.data.tooltip"
    >
        <v-list-item
            v-bind="component.attributes"
            :class="{'pl-2': isHidden}"
            dense
            exact
            @click="$actions.call(component.data.action)"
            v-on="tooltip"
        >
            <template
                v-if="prepend"
            >
                <v-list-item-icon
                    v-if="prepend.componentName === 'IconComponent'"
                    class="mx-auto justify-center"
                    style="min-width: 40px"
                >
                    <IconComponent :value="prepend" />
                </v-list-item-icon>
                <v-list-item-avatar
                    v-else-if="prepend.componentName === 'ImageComponent'"
                    :class="{'mr-2': !isHidden}"
                    :max-width="prepend.attributes.maxWidth"
                    :max-height="prepend.attributes.maxHeight"
                    class="my-0"
                >
                    <ImageComponent
                        class="mx-auto"
                        :value="prepend"
                    />
                </v-list-item-avatar>
            </template>
            <v-list-item-content>
                <v-list-item-title v-text="component.content.title" />
                <v-list-item-subtitle
                    v-if="component.content.description"
                    v-text="component.content.description"
                />
            </v-list-item-content>
        </v-list-item>
    </tooltip>
</template>

<script>
    import Tooltip from "../../../Utils/Tooltip.vue";
    import IconComponent from "../../../Misc/Icons/Icon.vue";
    import ImageComponent from "../../../Misc/Image.vue";
    import ComponentBase from "../../../Base/ComponentBase";
    import Component from "../../../../Helpers/Components/Component";


    export default {
        name: "NavigationItem",

        components: {
            Tooltip,
            IconComponent,
            ImageComponent,
        },

        extends: ComponentBase,

        props: {
            isHidden: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                prepend: new Component(this.value.data.prepend || {})
            }
        },
    }
</script>
