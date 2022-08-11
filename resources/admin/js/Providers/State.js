import {STATE_EDIT, STATE_NEW, STATE_SHOW} from "./Config";
import Helper from "./Helper";

export default class State
{
    #params = {}
    #router = Helper.getRouter()

    setForm(isEdit, parameters) {
        let params = {
            state: isEdit ? STATE_EDIT : STATE_NEW,
            ...parameters
        }

        this.setParams('form', params).#setRoute()
    }

    setShow(parameters) {
        const params = {
            state: STATE_SHOW,
            ...parameters
        }

        this.setParams('show', params).#setRoute()
    }

    resetForm() {
        delete this.#params.form

        this.#setRoute()
    }

    resetShow() {
        delete this.#params.show

        this.#setRoute()
    }

    setParams(type, params) {
        Object.assign(this.#params, {[type]: params})

        return this
    }

    #setRoute() {
        let chapters = []
        let currentRoute = this.#router.currentRoute

        for (let parameter of Object.entries(this.#params)) {
            chapters = chapters.concat(Object.values(parameter[1]))
        }

        currentRoute.params.chapters = chapters

        this.#router.replace(currentRoute).catch(() => {})
    }
}
