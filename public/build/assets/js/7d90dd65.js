import{l as a}from"./12a8f78c.js";import{L as r}from"./57b36955.js";import{C as o}from"./e63a8b3a.js";import{n as s}from"./75131b1e.js";import{b as i}from"./dcc38a7c.js";import"./002c896d.js";const l={name:"ConditionInput",components:{LCol:r},extends:o,data(){return{vuexNamespace:this.value.data.vuexNamespace}},computed:{data(){return this.$store.getters[this.vuexNamespace]},cols(){return a.exports.get(this.data,this.value.data.path)}}};var m=function(){var t=this,e=t._self._c;return e(i,{attrs:{dense:""}},t._l(t.cols,function(n){return e("l-col",{key:n.identifier,attrs:{value:n}})}),1)},u=[],p=s(l,m,u,!1,null,null,null,null);const C=p.exports;export{C as default};
