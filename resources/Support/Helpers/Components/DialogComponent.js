import Component from "./Component";

class DialogComponent extends Component
{
    constructor(component) {
        super(component);
    }

    static createDebugger(html) {
        return new DialogComponent({
            attributes: {
                width: '100%',
                scrollable: true
            },
            data: {
                show: true,
                modal: new Component({
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
                    },
                    componentName: 'CardComponent',
                })
            },
        })
    }
}

export default DialogComponent
