import Vuetify from "./vuetify"

const $vuetify = Vuetify.framework

export default {
    install(Vue) {
        Vue.prototype.$config = {
            elevation: 3,

            notification: {
                displayTime: 1000 * 10,
            },

            genders: [
                {value: 'male', text: $vuetify.lang.t('$vuetify.word.male')},
                {value: 'female', text: $vuetify.lang.t('$vuetify.word.female')},
                {value: 'other', text: $vuetify.lang.t('$vuetify.word.other')},
            ]
        }
    }
}
