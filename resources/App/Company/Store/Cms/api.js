import FormBase from "../../../../Support/Store/Base/formBase";

export default {
    namespaced: true,

    modules: {
        form: FormBase({
            isReady: true,
        })
    }
}