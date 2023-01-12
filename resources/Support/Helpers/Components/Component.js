import { v4 as uuidGenerator } from 'uuid';
import vuetify from "../../Plugins/Vuetify";

const $vuetify = vuetify.framework

class Component
{
    constructor({
        data = {},
        content = {},
        attributes = {},
        identifier = uuidGenerator(),
        componentName = 'ComponentError'
    }) {
        this.data = new Proxy(data, this.#proxyHandler());
        this.attributes = new Proxy(attributes, this.#proxyHandler());

        this.content = content;
        this.identifier = identifier;
        this.componentName = componentName;
    }

    addData(key, data, isArray = false) {
        if (isArray) {
            if (!Object.prototype.hasOwnProperty.call(this.data, key)) {
                this.data[key] = []
            }

            this.data[key].push(data);
        } else {
            this.data[key] = data;
        }

        return this
    }

    addContent(key, content) {
        this.content[key] = content;

        return this
    }

    addAttributes(key, value) {
        this.attributes[key] = value;

        return this
    }

    #proxyHandler() {
        return {
            get(_, property) {
                const value = Reflect.get(...arguments)

                switch (property) {
                    case 'color':
                    case 'headerColor':
                        if (value instanceof Object) {
                            return $vuetify.theme.dark ? value.dark : value.light
                        }
                }

                return value
            }
        }
    }

    static empty() {
        return new Component({
            componentName: 'EmptyComponent'
        });
    }
}

export default Component
