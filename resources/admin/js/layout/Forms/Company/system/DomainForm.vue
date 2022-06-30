<template>
    <fragment>
        <v-col cols="12">
            <v-text-field
                v-model="value.name"
                :disabled="isEditing"
                :error-messages="errors.name"
                :label="$vuetify.lang.t('$vuetify.word.domain')"
                dense
                outlined
                hide-details="auto"
            />
        </v-col>
        <v-col cols="12">
            <v-combobox
                v-model="value.template"
                :items="templates"
                :error-messages="errors.template"
                :label="$vuetify.lang.t('$vuetify.word.template.web')"
                :hide-details="isEditing ? true : 'auto'"
                clearable
                dense
                outlined
            />
        </v-col>
        <v-col cols="12">
            <v-text-field
                v-model="aliasValue"
                :error-messages="inValidAlies"
                :label="$vuetify.lang.t('$vuetify.word.aliases')"
                dense
                outlined
                hide-details="auto"
                append-outer-icon="fas fa-plus"
                @keydown.enter="addAlias"
                @click:append-outer="addAlias"
            />
        </v-col>
        <v-col
            v-for="(alias, index) in value.aliases"
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
    </fragment>
</template>

<script>
    import psl from "psl";
    import {mapGetters} from "vuex";
    import FromProps from "../../../../mixins/Form/FormProperties";

    export default {
        name: "DomainForm",

        mixins: [
            FromProps
        ],

        data() {
            return {
                aliasValue: '',
                inValidAlies: ''
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
                this.inValidAlies = ''

                if (alias) {
                    if (psl.get(alias) === null) {
                        alias += `.${this.value.name}`
                    }

                    if (psl.isValid(alias) || alias.startsWith('*')) {
                        const exist = this.value.aliases.some(element => {
                            if (element.value === alias) {
                                return true;
                            }
                        });

                        if (!exist) {
                            this.value.aliases.push({value: alias});
                            this.alias = '';
                        } else {
                            this.inValidAlies = this.$vuetify.lang.t('$vuetify.text.exist.alias')
                        }
                    } else {
                        this.inValidAlies = this.$vuetify.lang.t('$vuetify.text.in_valid_alies')
                    }
                }
            },

            removeAlias(index) {
                this.value.aliases.splice(index, 1)
            }
        }
    }
</script>
