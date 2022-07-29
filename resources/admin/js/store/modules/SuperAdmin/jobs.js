import DataTableBase from "../Base/dataTableBase";
import ShowBase from "../Base/showBase";

export default {
    namespaced: true,

    modules: {
        show: ShowBase,
        schedules: DataTableBase,
        processes: DataTableBase
    }
}
