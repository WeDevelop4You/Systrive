export default {
    data() {
        return {
            passwordError: false,
        }
    },

    methods: {
        passwordErrors(errors) {
            let newErrors = {}

            errors.password?.forEach((message) => {
                this.passwordError = true

                if (message.includes('characters')) {
                    newErrors.characters = true
                } else if (message.includes('uppercase')) {
                    newErrors.mixedCase = true
                } else if (message.includes('number')) {
                    newErrors.number = true
                } else if (message.includes('symbol')) {
                    newErrors.symbol = true
                } else {
                    newErrors.password = [
                        ...newErrors.password || [],
                        message
                    ]
                }
            })

            delete errors.password

            return {...errors, ...newErrors}
        },
    }
}
