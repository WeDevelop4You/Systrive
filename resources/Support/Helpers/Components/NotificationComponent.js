import Vue from "vue"
import Component from "./Component";

const app = Vue.prototype

class NotificationComponent extends Component
{
    constructor(component, loadDefault = false) {
        super(component);

        if (loadDefault) {
            this.setStayable(false)
        }

        this.setDisplayTime(
            component.data?.displayTime || app.$config.notification.displayTime
        )
    }

    setStayable(condition = true) {
        this.addData('stayable', condition)

        return this
    }

    setDisplayTime(time) {
        this.addData('displayTime', time)

        return this
    }

    static createSimple(message, type = 'error') {
        return new NotificationComponent({
            content: {
                text: message
            },
            attributes: {
                type: type
            },
            componentName: 'SimpleNotificationComponent'
        }, true)
    }
}

export default NotificationComponent
