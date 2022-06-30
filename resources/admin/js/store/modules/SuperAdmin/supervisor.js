import Vue from "vue";
import OverviewBase from "../Base/overviewBase";
import FormBase from "../Base/formBase";

const app = Vue.prototype

export default {
    namespaced: true,

    actions: {

    },

    modules: {
        processForm: FormBase(),
        overview: OverviewBase
    }
}
