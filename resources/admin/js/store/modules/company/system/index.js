import domain from "./domain";
import dns from "./dns";

export default {
    namespaced: true,

    modules: {
        dns: dns,
        domain: domain,
    }
}
