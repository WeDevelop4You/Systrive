export default {
    props: {
        value: {
            required: true,
            type: Object,
        },

        errors: {
            type: Object,
            default: () => {
                return {}
            }
        },

        isEditing: {
            type: Boolean,
            default: false
        }
    }
}
