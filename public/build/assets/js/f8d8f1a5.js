import{C as r}from"./0d92c212.js";import{n as i}from"./75131b1e.js";import{a as m,d as a}from"./20f47019.js";import{_ as n}from"./3b8c775f.js";import{_ as s}from"./83c99da4.js";import"./5dd91c54.js";import"./4cf2fa9d.js";import"./89ae458c.js";import"./744bff6b.js";import"./3bfe2d76.js";import"./64eb8a9e.js";import"./53ee5cfb.js";import"./64b64aa2.js";import"./f57264bf.js";const l={name:"CompanyCompleteForm",mixins:[r]};var d=function(){var t=this,o=t._self._c;return o(m,{attrs:{dense:""}},[o(a,{attrs:{cols:"12"}},[o(n,{attrs:{"error-messages":t.errors.email,label:t.$vuetify.lang.t("$vuetify.word.email"),dense:"",outlined:"","hide-details":"auto"},on:{input:function(e){return t.clearError("email")}},model:{value:t.data.email,callback:function(e){t.$set(t.data,"email",e)},expression:"data.email"}})],1),o(a,{attrs:{cols:"12"}},[o(n,{attrs:{"error-messages":t.errors.domain,label:t.$vuetify.lang.t("$vuetify.word.domain"),dense:"",outlined:"","hide-details":"auto"},on:{input:function(e){return t.clearError("domain")}},model:{value:t.data.domain,callback:function(e){t.$set(t.data,"domain",e)},expression:"data.domain"}})],1),o(a,{attrs:{cols:"12"}},[o(s,{attrs:{label:t.$vuetify.lang.t("$vuetify.word.information"),dense:"",outlined:"","hide-details":""},model:{value:t.data.information,callback:function(e){t.$set(t.data,"information",e)},expression:"data.information"}})],1)],1)},u=[],p=i(l,d,u,!1,null,null,null,null);const z=p.exports;export{z as default};