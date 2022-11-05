import DataTableBase from "../../base/dataTableBase";
import ShowBase from "../../base/showBase";

export default {
    namespaced: true,

    modules: {
        show: ShowBase,
        schedules: DataTableBase,
        processes: DataTableBase
    }
}
