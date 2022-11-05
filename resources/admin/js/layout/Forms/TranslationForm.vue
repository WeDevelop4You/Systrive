<template>
    <v-row dense>
        <v-col cols="12">
            <group-badges v-model="data.tags" />
        </v-col>
        <v-col cols="6">
            <v-list-item
                two-line
                class="pl-0"
            >
                <v-list-item-content>
                    <v-list-item-title class="font-weight-bold">
                        {{ $vuetify.lang.t('$vuetify.word.environment') }}
                    </v-list-item-title>
                    <v-list-item-subtitle v-text="data.environment" />
                </v-list-item-content>
            </v-list-item>
        </v-col>
        <v-col cols="6">
            <v-list-item
                two-line
                class="pr-0"
            >
                <v-list-item-content>
                    <v-list-item-title class="font-weight-bold">
                        {{ $vuetify.lang.t('$vuetify.word.group') }}
                    </v-list-item-title>
                    <v-list-item-subtitle v-text="data.group" />
                </v-list-item-content>
            </v-list-item>
        </v-col>
        <v-col cols="12">
            <v-list-item
                two-line
                class="px-0"
            >
                <v-list-item-content>
                    <v-list-item-title class="font-weight-bold">
                        {{ $vuetify.lang.t('$vuetify.word.key') }}
                    </v-list-item-title>
                    <v-list-item-subtitle v-text="data.key" />
                </v-list-item-content>
            </v-list-item>
        </v-col>
        <v-col
            v-for="(translation, index) in data.translations"
            :key="index"
            cols="12"
        >
            <v-text-field
                v-model="translation.translation"
                :label="translation.locale.toUpperCase()"
                dense
                outlined
                hide-details
            />
        </v-col>
        <v-col cols="12">
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
                        {{ $vuetify.lang.t('$vuetify.word.translation.sources') }}
                    </v-expansion-panel-header>
                    <v-expansion-panel-content class="translation">
                        <ul>
                            <li
                                v-for="(source, index) in data.sources"
                                :key="index"
                            >
                                {{ source }}
                            </li>
                        </ul>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-col>
    </v-row>
</template>

<script>
    import CustomFormProperties from "../../mixins/CustomFormProperties";
    import GroupBadges from "../../components/Items/GroupBadges.vue";

    export default {
        name: "TranslationForm",

        components: {
            GroupBadges
        },

        mixins: [
            CustomFormProperties
        ]
    }
</script>
