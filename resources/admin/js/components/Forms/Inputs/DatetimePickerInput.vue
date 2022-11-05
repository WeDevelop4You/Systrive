<template>
    <v-dialog
        v-model="modal"
        persistent
        :elevation="$config.elevation"
        width="340"
    >
        <template v-slot:activator="{ on }">
            <v-text-field
                v-bind="component.attributes"
                :value="formatter"
                :disabled="isDisabled"
                :label="component.content.label"
                :error-messages="errorMessages"
                @click="open"
                @click:clear="reset"
                @input="clearError($event)"
            ></v-text-field>
        </template>
        <v-card
            outlined
            :elevation="$config.elevation"
            rounded="lg"
            id="custom-datetime"
        >
            <v-card-text class="px-0 pb-2">
                <v-tabs
                    v-model="tab"
                    grow
                    :show-arrows="false"

                >
                    <v-tab id="first" v-text="$vuetify.lang.t('$vuetify.word.date')"/>
                    <v-tab id="last" v-text="$vuetify.lang.t('$vuetify.word.time')"/>
                </v-tabs>
                <v-tabs-items v-model="tab">
                    <v-tab-item>
                        <v-date-picker
                            v-model="date"
                            flat
                            scrollable
                            full-width
                            color="primary"
                            header-color="text--primary"
                            @input="next"
                        />
                    </v-tab-item>
                    <v-tab-item>
                        <v-time-picker
                            v-model="time"
                            :use-seconds="component.data.useSeconds"
                            full-width
                            scrollable
                            flat
                            format="24hr"
                            color="primary"
                            header-color="text--primary"
                        />
                    </v-tab-item>
                </v-tabs-items>
            </v-card-text>
            <v-card-actions>
                <v-row
                    no-gutters
                    align="center"
                    justify="end"
                    class="gap-3"
                >
                    <v-btn
                        text
                        v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                        @click="close"
                    />
                    <v-btn
                        :disabled="!isValid"
                        color="primary"
                        v-text="$vuetify.lang.t('$vuetify.word.save')"
                        @click="save"
                    />
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import DatetimeInputComponentBase from "../../Base/Inputs/DatetimeInputComponentBase";

    export default {
        name: "DatetimePickerInput",

        extends: DatetimeInputComponentBase,

        data() {
            return {
                tab: 0,
                type: 'datetime'
            }
        },

        methods: {
            open() {
                if (!this.component.attributes.readonly) {
                    this.init()

                    this.tab = 0
                    this.modal = true
                }
            },

            next() {
                this.tab = 1
            }
        }
    }
</script>
