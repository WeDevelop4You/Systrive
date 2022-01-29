export default {
    props: {
        item: {
            required: true,
            type: Object
        },

        isMobile: {
            required: true,
            type: Boolean
        },

        header: {
            required: true,
            type: Object
        },

        index: {
            required: true,
            type: Number
        },

        itemIndex: {
            required: true,
            type: Number,
            default: 0,
        }
    },
};
