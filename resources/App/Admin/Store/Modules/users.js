// import Vue from 'vue';
import dataTableBase from "../../../../Support/Store/Base/dataTableBase";

// const app = Vue.prototype

export default {
    namespaced: true,

    actions: {
        edit(_, route) {
            console.log(route)
        },

        update(_, route) {
            console.log(route)
        }
    },

    modules: {
        dataTable: dataTableBase()
    }
}
