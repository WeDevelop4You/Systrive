<template>
    <div
        v-show="isHidden"
        :class="{'active': isActive}"
    >
        <editor
            :init="options"
            :disabled="component.attributes.readonly"
            :initial-value="getValue"
            cloud-channel="6"
            model-events="change keydown blur paste"
            api-key="4mucpk15n7x2rj2rvd1s4hi4rtoilzvknnv52ts7tclhl0i3"
            @input="setValue($event)"
            @onblur="active"
            @onfocus="active"
            @onInit="setDefaultColor"
        />
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'
    import FormComponentBase from "../../Base/FormComponentBase";

    export default {
        name: "RichTextareaInput",


        components: {
            Editor
        },

        extends: FormComponentBase,

        data() {
            return {
                isActive: false,
                options: {
                    statusbar: false,
                    min_height: 500,
                    plugins: 'lists advlist image link table fullscreen help searchreplace charmap emoticons autolink anchor autoresize', // image
                    toolbar: [
                        'undo redo | blocks fontsize anchor | numlist bullist | outdent indent | fullscreen',
                        'pastetext removeformat | bold italic strikethrough subscript superscript | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | link charmap table emoticons'
                    ],
                    menu: {
                        file: { title: 'File', items: 'newdocument restoredraft | preview | export print | deleteallconversations' },
                        edit: { title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace' },
                        view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments' },
                        insert: { title: 'Insert', items: 'image link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime' },
                        format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | styles blocks fontsize align lineheight | forecolor backcolor | language | removeformat' },
                        table: { title: 'Table', items: 'inserttable | cell row column | advtablesort | tableprops deletetable' },
                        help: { title: 'Help', items: 'help' }
                    },
                    help_tabs: ['shortcuts', 'keyboardnav'],
                    skin_url: '/build/assets/css/tinymce',
                }
            }
        },

        watch: {
            '$vuetify.theme.dark'()  {
                this.setDefaultColor()
            }
        },

        methods: {
            active(event) {
                this.isActive = event.type === 'focus'
            },

            setDefaultColor() {
                const color = this.$vuetify.theme.dark ? '#fff' : '#000'
                const $iframe = this.$el.querySelector('iframe')

                $iframe.contentDocument.documentElement.style.color = color
            }
        }
    }
</script>
