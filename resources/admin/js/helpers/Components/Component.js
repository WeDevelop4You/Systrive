import { v4 as uuidGenerator } from 'uuid';
import vuetify from "../../plugins/vuetify";

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
        const handler = {
            get(_, property) {
                const value = Reflect.get(...arguments)

                switch (property) {
                    case 'color':
                    case 'headerColor':
                        if (typeof value === "object") {
                            return $vuetify.theme.dark ? value.dark : value.light
                        }
                }

                return value
            }
        }

        this.data = new Proxy(data, handler);
        this.attributes = new Proxy(attributes, handler);

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

    static empty() {
        return new Component({
            componentName: 'EmptyComponent'
        });
    }
}

export default Component
