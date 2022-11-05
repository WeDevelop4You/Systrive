<template>
    <v-row dense>
        <v-col cols="12">
            <v-text-field
                v-model="data.name"
                :disabled="isEditing"
                :error-messages="errors.name"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
                @input="clearError('name')"
            />
        </v-col>
        <v-col
            v-for="(alias, index) in data.aliases"
            :key="index"
            cols="12"
        >
            <v-text-field
                v-model="alias.value"
                :error-messages="errors.aliases"
                dense
                outlined
                hide-details="auto"
                append-outer-icon="fas fa-minus"
                @keyup.delete="removeAlias(index)"
                @click:append-outer="removeAlias(index)"
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="aliasValue"
                :error-messages="invalidAlies"
                :label="$vuetify.lang.t('$vuetify.word.aliases')"
                dense
                outlined
                hide-details="auto"
                append-outer-icon="fas fa-plus"
                @keydown.enter="addAlias"
                @click:append-outer="addAlias"
                @input="invalidAlies = ''"
            />
        </v-col>
        <v-col cols="12">
            <v-combobox
                v-model="data.template"
                :items="templates"
                :error-messages="errors.template"
                :label="$vuetify.lang.t('$vuetify.word.template.web')"
                hide-details="auto"
                clearable
                dense
                outlined
                @input="clearError('template')"
            />
        </v-col>
    </v-row>
</template>

<script>
    import psl from "psl";
    import {mapGetters} from "vuex";
    import CustomFormProperties from "../../../../mixins/CustomFormProperties";

    export default {
        name: "DomainForm",

        mixins: [
            CustomFormProperties
        ],

        data() {
            return {
                aliasValue: '',
                invalidAlies: ''
            }
        },

        computed: {
            ...mapGetters({
                templates: 'system/template/list',
            })
        },

        created() {
            this.$store.dispatch('system/template/getList', 'web');
        },

        methods: {
            addAlias() {
                let alias = this.aliasValue
                this.invalidAlies = ''

                if (alias) {
                    if (psl.get(alias) === null) {
                        alias += `.${this.data.name}`
                    }

                    if (psl.isValid(alias) || alias.startsWith('*')) {
                        const exist = this.data.aliases.some(element => {
                            if (element.value === alias) {
                                return true;
                            }
                        });

                        if (!exist) {
                            this.data.aliases.push({value: alias});
                            this.aliasValue = '';
                        } else {
                            this.invalidAlies = this.$vuetify.lang.t('$vuetify.text.exist.alias')
                        }
                    } else {
                        this.invalidAlies = this.$vuetify.lang.t('$vuetify.text.in_valid_alies')
                    }
                }
            },

            removeAlias(index) {
                this.data.aliases.splice(index, 1)
            }
        }
    }
</script>
