import Import from "../helpers/Import";

export default class Config
{
    #vuetify = Import.vuetify()

    constructor() {
        this.elevation = 3
        this.notification = {
            displayTime: 1000 * 10,
        }

        this.permissions = {
            ...Import.permissions(),
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
