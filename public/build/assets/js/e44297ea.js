import{m as s}from"./5ecbb865.js";import{n as a}from"./75131b1e.js";import{_ as m}from"./01e285ba.js";import{_ as p}from"./c1698eeb.js";import{_ as l}from"./e0db1d00.js";import{_ as c}from"./4138e54f.js";import{_}from"./f5ffbe96.js";import"./23e0ddc0.js";import"./62678420.js";import"./16a5c7a5.js";import"./a097d4c0.js";import"./4d23891e.js";import"./165252c7.js";import"./00924962.js";import"./8f3521ec.js";import"./f57264bf.js";import"./0e939e68.js";import"./ed6ab0a1.js";import"./89ff418b.js";import"./f72d6ec9.js";import"./0f1ce05e.js";const f={name:"LocaleDropdown",props:{fixed:{type:Boolean,default:!1},arrowUp:{type:Boolean,default:!1}},computed:{getFlag(){return Object.keys(this.items).find(e=>this.items[e]===this.locale)||"us"},...s({locale:"locale",items:"locales/items"})},methods:{async changeLocale(e){await this.$store.dispatch("locales/change",e)}}};var u=function(){var t=this,o=t._self._c;return o(p,{attrs:{top:t.arrowUp,"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function({on:n,attrs:r,value:i}){return[o(m,t._g(t._b({attrs:{right:t.fixed,fixed:t.fixed,bottom:t.fixed,outlined:"",color:"#ffffff"}},"v-btn",r,!1),n),[o("gb-flag",{staticClass:"mx-auto rounded",attrs:{code:t.getFlag,size:"mini"}}),o(l,{attrs:{right:""}},[t._v(" "+t._s((t.arrowUp?i:!i)?"fa-chevron-down":"fa-chevron-up")+" ")])],1)]}}])},[o(c,{attrs:{dense:""}},t._l(t.items,function(n,r){return o(_,{key:r,staticStyle:{"min-height":"28px"},on:{click:function(i){return t.changeLocale(n)}}},[o("gb-flag",{staticClass:"mx-auto rounded",attrs:{code:r,size:"mini"}})],1)}),1)],1)},d=[],g=a(f,u,d,!1,null,null,null,null);const A=g.exports;export{A as default};
