import CardBase from "../components/cards/CardBase";
import ModalBase from "../components/modals/ModalBase";

export default {
    components: {
        CardBase,
        ModalBase,
    },

    props: {
        value: {
            required: true,
            type: Boolean
        },

        title: {
            required: true,
            type: String,
        },
    },

    computed: {
        show: {
            get () {
                return this.value
            },

            set (value) {
                this.$emit('input', value)
            }
        },
    },

    mounted() {
        this.$refs.modal.$on('opened', this.$emit('opened'))
        this.$refs.modal.$on('closed', this.$emit('closed'))
    },

    methods: {
        open() {
            this.$refs.modal.open();
        },

        close() {
            this.$refs.modal.close()
        }
    }
}
