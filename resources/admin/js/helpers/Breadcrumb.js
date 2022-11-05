class Breadcrumb {
    constructor(label, to, additional = {}) {
        this.to = to;
        this.label = label;
        this.additional = additional;
    }
}

export default Breadcrumb
