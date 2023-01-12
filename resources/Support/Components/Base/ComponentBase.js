import Component from "../../helpers/Components/Component";

export default {
    props: {
        value: {
            required: true,
            type: Object,
            default: () => {
                return Component.empty()
            }
        }
    },

    data() {
        return {
            component: {}
        }
    },

    created() {
        if (this.value instanceof Component) {
            this.component = this.value; return;
        }

        const component = {
            data: this.value.data,
            content: this.value.content,
            attributes: this.value.attributes,
            identifier: this.value.identifier,
            componentName: this.value.componentName
        }

        this.component = new Component(component)
    },
}
