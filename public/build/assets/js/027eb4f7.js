import{m as i}from"./30fae2fd.js";import{C as s}from"./0d92c212.js";import{n as m}from"./75131b1e.js";import{_ as l}from"./1ddf1442.js";import{_ as u}from"./786fcbb9.js";import{a as d,d as r}from"./8ba31e84.js";import{_ as n}from"./90435b0d.js";import{_ as p}from"./710e1eb2.js";import"./5dd91c54.js";import"./4cf2fa9d.js";import"./10077ee1.js";import"./3fe3f60d.js";import"./bdd01e8a.js";import"./1c949a44.js";import"./24ed13ab.js";import"./039e00f1.js";import"./a5372d14.js";import"./65a60693.js";import"./335df259.js";import"./80e71617.js";import"./a3716e35.js";import"./6eca2908.js";import"./f57264bf.js";import"./64b64aa2.js";import"./0f53b063.js";import"./c244e79d.js";import"./e4b06890.js";import"./39b1c9f1.js";import"./03959f41.js";import"./c09151b9.js";import"./f0a47c82.js";import"./bd206a3a.js";const c={name:"CompanyForm",mixins:[s],data(){return{owner:null}},computed:{showCheckbox(){var a,e;return this.owner?((a=this.owner)==null?void 0:a.value)!==((e=this.data.owner)==null?void 0:e.value):!1},...i({users:"users/list"})},created(){this.$store.dispatch("users/list"),this.isEditing&&(this.owner=this.data.owner)}};var _=function(){var e=this,o=e._self._c;return o(d,{attrs:{dense:""}},[e.$auth.can(e.$config.permissions.superAdmin)?o(r,{attrs:{cols:"12"}},[o(n,{attrs:{"error-messages":e.errors.name,label:e.$vuetify.lang.t("$vuetify.word.name"),dense:"",outlined:"","hide-details":"auto"},on:{input:function(t){return e.clearError("name")}},model:{value:e.data.name,callback:function(t){e.$set(e.data,"name",t)},expression:"data.name"}})],1):e._e(),e.$auth.can(e.$config.permissions.superAdmin)?o(r,{attrs:{cols:"12"}},[o(l,{attrs:{items:e.users,"error-messages":e.errors.owner,label:e.$vuetify.lang.t("$vuetify.word.owner"),"hide-details":e.showCheckbox?!0:"auto",clearable:"",dense:"",outlined:""},on:{input:function(t){return e.clearError("owner")}},model:{value:e.data.owner,callback:function(t){e.$set(e.data,"owner",t)},expression:"data.owner"}})],1):e._e(),e.isEditing&&e.$auth.can(e.$config.permissions.superAdmin)?o(r,{directives:[{name:"show",rawName:"v-show",value:e.showCheckbox,expression:"showCheckbox"}],attrs:{cols:"12"}},[o(p,{staticClass:"mb-2",attrs:{"error-messages":e.errors.owner,label:e.$vuetify.lang.t("$vuetify.text.remove.owner"),dense:"","hide-details":"auto"},model:{value:e.data.remove_owner,callback:function(t){e.$set(e.data,"remove_owner",t)},expression:"data.remove_owner"}})],1):e._e(),e.isEditing?o(r,{attrs:{cols:"12"}},[o(n,{attrs:{"error-messages":e.errors.email,label:e.$vuetify.lang.t("$vuetify.word.email"),dense:"",outlined:"","hide-details":"auto"},on:{input:function(t){return e.clearError("email")}},model:{value:e.data.email,callback:function(t){e.$set(e.data,"email",t)},expression:"data.email"}})],1):e._e(),e.isEditing?o(r,{attrs:{cols:"12"}},[o(n,{attrs:{"error-messages":e.errors.domain,label:e.$vuetify.lang.t("$vuetify.word.domain"),dense:"",outlined:"","hide-details":"auto"},on:{input:function(t){return e.clearError("domain")}},model:{value:e.data.domain,callback:function(t){e.$set(e.data,"domain",t)},expression:"data.domain"}})],1):e._e(),e.isEditing?o(r,{attrs:{cols:"12"}},[o(u,{attrs:{label:e.$vuetify.lang.t("$vuetify.word.information"),dense:"",outlined:"","hide-details":""},model:{value:e.data.information,callback:function(t){e.$set(e.data,"information",t)},expression:"data.information"}})],1):e._e()],1)},f=[],v=m(c,_,f,!1,null,null,null,null);const V=v.exports;export{V as default};