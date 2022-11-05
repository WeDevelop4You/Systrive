import Component from "./Component";

class ModalComponent extends Component
{
    constructor(component) {
        super(component);
    }

    static createDebugger(html) {
        return new ModalComponent({
            attributes: {
                width: '100%',
                scrollable: true
            },
            data: {
                show: true,
                card: new Component({
                    attributes: {
                        rounded: 'lg',
                        outlined: true
                    },
                    content: {
                        title: 'Debugging'
                    },
                    data: {
                        hasBody: true,
                        hasFooter: false,
                        headerColor: 'transparent',
                        additionalBodyClasses: ['pa-0', 'mx-2', 'mb-2', 'w-auto', 'rounded-lg'],
                        body: [
                            new Component({
                                content: {
                                    html: html,
                                },
                                componentName: 'RawHtmlComponent'
                            })
                        ]
                    }
                })
            },
        })
    }
}

export default ModalComponent
