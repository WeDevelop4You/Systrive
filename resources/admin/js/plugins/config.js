import Vuetify from "./vuetify"
import Permissions from "../config/permissions"

const $vuetify = Vuetify.framework
const $permissions = Permissions

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
            ],

            permissions: {
                ...$permissions,

                companyAdmin: [
                    $permissions.user.view,
                    $permissions.role.view,
                ]
            }
        }
    }
}
