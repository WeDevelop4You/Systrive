import dataTableBase from "../../../../Support/Store/Base/dataTableBase";
import OverviewBase from "../../../../Support/Store/Base/overviewBase";

export default {
    namespaced: true,

    modules: {
        overview: OverviewBase,
        dataTable: dataTableBase
    }
}
