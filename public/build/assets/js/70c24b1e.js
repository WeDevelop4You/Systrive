import e from"./733b5b82.js";import{T as i}from"./46089149.js";import{l as a}from"./e60bc734.js";import{C as s}from"./97d45361.js";import{n as c}from"./75131b1e.js";import{_ as m}from"./4d8d9605.js";import{_ as p}from"./a86d1ebb.js";import"./10397c83.js";import"./01675ed1.js";import"./4dfd685f.js";import"./f389e713.js";import"./bcd1e32a.js";import"./98dbeb61.js";import"./5b3c2e28.js";import"./b621b831.js";import"./4e148495.js";import"./5eaf0fa2.js";import"./51e51f33.js";import"./9b90040d.js";const l={name:"IconBtn",components:{Tooltip:i,Icon:e},extends:s,data(){return{action:a.exports.debounce(()=>{this.$actions.call(this.component.data.action)},500,{leading:!0,trailing:!1})}},methods:{runAction(){this.$loading||this.action()},runDefaultAction(){this.$actions.call(this.component.data.action)}}};var u=function(){var t=this,o=t._self._c;return o("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:n}){return[o(m,{scopedSlots:t._u([{key:"default",fn:function({hover:r}){return[o(p,t._g(t._b({attrs:{depressed:""},on:{click:t.runAction}},"v-btn",t.component.attributes,!1),n),[o("icon",{attrs:{value:t.component.data.icon,color:r?t.component.data.hoverColor:void 0}})],1)]}}],null,!0)})]}}])})},_=[],f=c(l,u,_,!1,null,null,null,null);const q=f.exports;export{q as default};
