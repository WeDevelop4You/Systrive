<template>
    <div
        :class="{'v-input--is-focused primary--text': focused}"
        class="v-text-field--outlined v-text-field theme--dark"
    >
        <div class="v-input__control">
            <div class="v-input__slot">
                <fieldset />
                <codemirror
                    v-model="data[key]"
                    :options="options"
                    @focus="focused = true"
                    @blur="focused = false"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import { codemirror } from 'vue-codemirror'
    import FormProperties from "../../../mixins/Form/FormProperties";

    // default css
    import 'codemirror/lib/codemirror.css'

    // dark theme
    import 'codemirror/theme/base16-dark.css'

    // color mode
    import 'codemirror/mode/toml/toml.js'

    // active-line.js
    import 'codemirror/addon/selection/active-line.js'

    // styleSelectedText
    import 'codemirror/addon/selection/mark-selection.js'
    import 'codemirror/addon/search/searchcursor.js'

    // highlightSelectionMatches
    import 'codemirror/addon/scroll/annotatescrollbar.js'
    import 'codemirror/addon/search/matchesonscrollbar.js'
    import 'codemirror/addon/search/searchcursor.js'
    import 'codemirror/addon/search/match-highlighter.js'

    // keyMap
    import 'codemirror/mode/clike/clike.js'
    import 'codemirror/addon/edit/matchbrackets.js'
    import 'codemirror/addon/comment/comment.js'
    import 'codemirror/addon/dialog/dialog.js'
    import 'codemirror/addon/dialog/dialog.css'
    import 'codemirror/addon/search/searchcursor.js'
    import 'codemirror/addon/search/search.js'
    import 'codemirror/keymap/sublime.js'

    export default {
        name: "CodeEditorInput",

        components: {
            codemirror
        },

        mixins: [
            FormProperties
        ],

        data() {
            return {
                focused: false,
            }
        },

        computed: {
            options() {
                return {
                    line: true,
                    tabSize: 4,
                    lineNumbers: true,
                    lineWrapping: true,
                    styleActiveLine: true,
                    keyMap: "sublime",
                    mode: 'text/x-toml',
                    theme: this.$vuetify.theme.dark ? 'base16-dark' : 'default',
                }
            }
        },
    }
</script>

<style>
    .vue-codemirror {
        width: calc(100% - 4px);
        margin: 0 2px 2px 2px;
    }

    .CodeMirror {
        border-radius: 4px;
    }

    .CodeMirror-cursor {
        height: 21px !important;
    }

    .CodeMirror-gutters,
    .CodeMirror-linenumber {
        left: 0 !important;
    }

    .CodeMirror-gutter-wrapper,
    .CodeMirror-activeline-gutter {
        left: -30px !important;
    }

    .v-text-field {
        margin-top: 0;
        padding-top: 0;
    }

    .v-input__slot {
        margin-bottom: 0;
    }

    .v-text-field--outlined {
        margin-bottom: 0;
    }

    .v-text-field--outlined fieldset {
        top: -2px;
        padding-left: 0;
    }
</style>
