<template>
    <v-dialog
        v-model="modal"
        persistent
        :elevation="$config.elevation"
        width="340"
    >
        <template #activator="{ on }">
            <v-text-field
                v-bind="component.attributes"
                :value="formatter"
                :disabled="isDisabled"
                :label="component.content.label"
                :error-messages="errorMessages"
                v-on="on"
                @click="open"
                @click:clear="reset"
                @input="clearError($event)"
            />
        </template>
        <v-card
            id="custom-datetime"
            outlined
            :elevation="$config.elevation"
            rounded="lg"
        >
            <v-card-text class="px-0 pb-2">
                <v-date-picker
                    v-model="date"
                    flat
                    scrollable
                    full-width
                    color="primary"
                    header-color="text--primary"
                />
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
                        @click="close"
                        v-text="$vuetify.lang.t('$vuetify.word.cancel.cancel')"
                    />
                    <v-btn
                        :disabled="!isValid"
                        color="primary"
                        @click="save"
                        v-text="$vuetify.lang.t('$vuetify.word.save')"
                    />
                </v-row>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import DatetimeInputComponentBase from "../../Base/Inputs/DatetimeInputComponentBase";

    export default {
        name: "DatePickerInput",

        extends: DatetimeInputComponentBase,

        data() {
            return {
                type: 'date'
            }
        }
    }
</script>
