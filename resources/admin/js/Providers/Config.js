import Helper from "./Helper";

export default class Config
{
    #vuetify = Helper.getVuetify()

    constructor() {
        this.elevation = 3
        this.notification = {
            displayTime: 1000 * 10,
        }

        this.permissions = {
            ...Helper.getPermissions(),
        }
    }

    genders() {
        return [
            {value: 'male', text: this.#vuetify.lang.t('$vuetify.word.male')},
            {value: 'female', text: this.#vuetify.lang.t('$vuetify.word.female')},
            {value: 'other', text: this.#vuetify.lang.t('$vuetify.word.other')},
        ]
    }
}

export const STATE_NEW = 'new'
export const STATE_EDIT = 'edit'
export const STATE_SHOW = 'show'

export const STATE_ALL = [STATE_NEW, STATE_EDIT, STATE_SHOW]
