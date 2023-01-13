import {get as _get} from "lodash";


class Logic {
    constructor({type, data}) {
        this.type = type;
        this.data = data;
    }

    call(data) {
        const value = _get(data, this.data.key)

        switch (this.type) {
            case 'contain': return this.#contain(value)
            case 'statement': return this.#statement(value)
            case 'condition': return this.#condition(value)
        }
    }

    #contain(value) {
        return this.data.values.includes(value) === this.data.condition
    }

    #statement(value) {
        return (value === this.data.compressing) === this.data.condition
    }

    #condition(value) {
        if (this.data.values.includes(value)) {
            return this.data.trueValue
        }

        return this.data.falseValue
    }
}

export default Logic
