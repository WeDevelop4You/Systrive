import{D as n}from"./4e440205.js";import{n as i}from"./75131b1e.js";import{_ as s}from"./825c092b.js";import{_ as a}from"./ab36a8de.js";import{_ as m}from"./69c0631b.js";import{_ as l}from"./f6b2f76e.js";import{a as p,b as c}from"./905d948c.js";import{b as u}from"./dcc38a7c.js";import{_ as r}from"./209703eb.js";import"./12a8f78c.js";import"./40b96a79.js";import"./e63a8b3a.js";import"./f55d25f8.js";import"./1b9ea462.js";import"./f57264bf.js";import"./068f7ff1.js";import"./2610d196.js";import"./12d57222.js";import"./0a0e57c8.js";import"./c8f02950.js";import"./517420cd.js";import"./fe993f4a.js";import"./887f6627.js";import"./6dc30b97.js";import"./bda96ba9.js";import"./0f1ce05e.js";import"./4516f3b3.js";import"./4e01a737.js";import"./42aaffeb.js";import"./f03d37af.js";const d={name:"TimePickerInput",extends:n,data(){return{type:"time"}}};var _=function(){var t=this,e=t._self._c;return e(a,{attrs:{persistent:"",elevation:t.$config.elevation,width:"340"},scopedSlots:t._u([{key:"activator",fn:function({}){return[e(m,t._b({directives:[{name:"show",rawName:"v-show",value:t.isHidden,expression:"isHidden"}],class:[{"v-input-hidden":!t.isHidden},t.component.attributes.class],attrs:{value:t.formatter,disabled:t.isDisabled,label:t.component.content.label,"error-messages":t.errorMessages,readonly:!0,"hide-details":t.hideDetails},on:{click:t.open,"click:clear":t.reset,input:function(o){return t.clearError(o)}}},"v-text-field",t.component.attributes,!1))]}}]),model:{value:t.modal,callback:function(o){t.modal=o},expression:"modal"}},[e(l,{attrs:{id:"custom-datetime",outlined:"",elevation:t.$config.elevation,rounded:"lg"}},[e(p,{staticClass:"px-0 pb-2"},[e(s,{attrs:{"use-seconds":t.component.data.useSeconds,"full-width":"",scrollable:"",flat:"",format:"24hr",color:"primary","header-color":"text--primary"},model:{value:t.time,callback:function(o){t.time=o},expression:"time"}})],1),e(c,[e(u,{staticClass:"gap-3",attrs:{"no-gutters":"",align:"center",justify:"end"}},[e(r,{attrs:{text:""},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.cancel.cancel"))},on:{click:t.close}}),e(r,{attrs:{disabled:!t.isValid,color:"primary"},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.save"))},on:{click:t.save}})],1)],1)],1)],1)},f=[],v=i(d,_,f,!1,null,null,null,null);const Q=v.exports;export{Q as default};