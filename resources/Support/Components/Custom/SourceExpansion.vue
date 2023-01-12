<template>
    <v-expansion-panels
        flat
        class="text--disabled"
        style="border: 1px solid;"
    >
        <v-expansion-panel>
            <v-expansion-panel-header
                class="px-3 py-2"
                style="min-height: 40px"
            >
                {{ component.content.label }}
            </v-expansion-panel-header>
            <v-expansion-panel-content class="translation">
                <ul>
                    <li
                        v-for="(source, index) in component.data.sources"
                        :key="index"
                    >
                        {{ source }}
                    </li>
                </ul>
            </v-expansion-panel-content>
        </v-expansion-panel>
    </v-expansion-panels>
</template>

<script>
    import ComponentBase from "../Base/ComponentBase";

    export default {
        name: "SourceExpansion",

        extends: ComponentBase
    }
</script>
