import{E as s}from"./e11e0046.js";import{C as e}from"./0d92c212.js";import{n}from"./75131b1e.js";import{_ as a}from"./5a7554aa.js";import{a as m}from"./20f47019.js";import"./5dd91c54.js";import"./4cf2fa9d.js";import"./3b8c775f.js";import"./744bff6b.js";import"./89ae458c.js";import"./3bfe2d76.js";import"./64eb8a9e.js";import"./53ee5cfb.js";import"./64b64aa2.js";import"./f57264bf.js";const i={name:"OneTimePassword",components:{ErrorMessage:s},mixins:[e],created(){this.data.one_time_password=""}};var _=function(){var t=this,o=t._self._c;return o(m,{attrs:{dense:""}},[o(a,{staticClass:"mx-auto",staticStyle:{width:"275px"},on:{finish:function(r){return t.$emit("defaultAction")}},model:{value:t.data.one_time_password,callback:function(r){t.$set(t.data,"one_time_password",r)},expression:"data.one_time_password"}}),o("error-message",{staticClass:"mx-1",attrs:{message:t.errors.one_time_password}})],1)},p=[],c=n(i,_,p,!1,null,null,null,null);const b=c.exports;export{b as default};