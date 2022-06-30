import dns from "./dns";
import domain from "./domain";
import database from "./database";
import mailDomain from "./mail_domain";

export default {
    namespaced: true,

    modules: {
        dns: dns,
        domain: domain,
        database: database,
        mailDomain: mailDomain,
    }
}
