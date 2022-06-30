export default {
    props: {
        value: {
            required: true,
            type: Object,
            default: () => {
                return {
                    data: {},
                    content: {},
                    attributes: {},
                    identifier: '',
                    componentName: '',
                }
            }
        }
    }
}
