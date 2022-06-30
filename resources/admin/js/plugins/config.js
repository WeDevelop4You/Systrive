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

            permissions: {
                ...$permissions,

                companyAdmin: [
                    $permissions.user.view,
                    $permissions.role.view,
                ]
            }
        }

        Vue.mixin({
            computed: {
                genders() {
                    return [
                        {value: 'male', text: $vuetify.lang.t('$vuetify.word.male')},
                        {value: 'female', text: $vuetify.lang.t('$vuetify.word.female')},
                        {value: 'other', text: $vuetify.lang.t('$vuetify.word.other')},
                    ]
                }
            }
        })
    }
}

export const STATE_NEW = 'new'
export const STATE_EDIT = 'edit'
export const STATE_SHOW = 'show'

export const STATE_ALL = [STATE_NEW, STATE_EDIT, STATE_SHOW]
