import {get as _get} from "lodash";


class Logic {
    constructor({key, type, values, returnValue}) {
        this.key = key;
        this.type = type;
        this.values = values;
        this.returnValue = returnValue;
    }

    call(data) {
        const value = _get(data, this.key)

        switch (this.type) {
            case 'contain': return this.#contain(value)
            case 'condition': return this.#condition(value)
        }
    }

    #condition(value) {
        if (this.values.includes(value)) {
            return this.returnValue.trueValue
        }

        return this.returnValue.falseValue
    }

    #contain(value) {
        return this.values.includes(value) === this.returnValue
    }
}

export default Logic
