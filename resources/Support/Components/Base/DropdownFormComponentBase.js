import FormComponentBase from "./FormComponentBase";

export default {
    extends: FormComponentBase,

    mounted() {
        if (this.isset(this.component.attributes, 'return-object')) {
            if (!(this.getValue instanceof Object)) {
                this.setValue(this.component.data.items.find(item => item.value === this.getValue))
            }
        }
    },
}
