import{C as s}from"./dfc93a5e.js";import{n as a}from"./75131b1e.js";import"./feafbc55.js";const o={name:"PasswordRequirements",extends:s,computed:{error(){const t=this.errors;return t.characters||t.mixedCase||t.number||t.symbol},errors(){return this.$store.getters[`${this.component.data.vuexNamespace}/errors`]}}};var i=function(){var e=this,r=e._self._c;return r("div",{staticClass:"subtitle-2 font-weight-regular"},[r("div",{class:[e.error?"error--text":"text--disabled"]},[e._v(" "+e._s(e.$vuetify.lang.t("$vuetify.text.password.requirements"))+" ")]),r("ul",{staticClass:"text--disabled"},[r("li",{class:{"error--text":e.errors.characters}},[e._v(" "+e._s(e.$vuetify.lang.t("$vuetify.text.password.list.characters"))+" ")]),r("li",{class:{"error--text":e.errors.mixedCase}},[e._v(" "+e._s(e.$vuetify.lang.t("$vuetify.text.password.list.mixed_case"))+" ")]),r("li",{class:{"error--text":e.errors.number}},[e._v(" "+e._s(e.$vuetify.lang.t("$vuetify.text.password.list.number"))+" ")]),r("li",{class:{"error--text":e.errors.symbol}},[e._v(" "+e._s(e.$vuetify.lang.t("$vuetify.text.password.list.symbol"))+" ")])])])},n=[],l=a(o,i,n,!1,null,null,null,null);const _=l.exports;export{_ as default};