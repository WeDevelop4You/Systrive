import{m as i}from"./30fae2fd.js";import{n as r}from"./75131b1e.js";import{_ as c}from"./5d3fcc86.js";import{_ as l}from"./335df259.js";import{_ as p}from"./8ba31e84.js";import{_ as m}from"./03959f41.js";import{_}from"./e4b06890.js";import"./65a60693.js";import"./24ed13ab.js";import"./039e00f1.js";import"./a5372d14.js";import"./80e71617.js";import"./a3716e35.js";import"./6eca2908.js";import"./f57264bf.js";import"./64b64aa2.js";const f={name:"LocaleDropdown",props:{fixed:{type:Boolean,default:!1},arrowUp:{type:Boolean,default:!1}},computed:{getFlag(){return Object.keys(this.items).find(o=>this.items[o]===this.locale)||"us"},...i({items:"locale/items",locale:"locale/locale"})},methods:{async changeLocale(o){await this.$store.dispatch("locale/setLocale",o),this.$route.meta.isAuthenticatedPage&&(this.$store.dispatch("navigation/sub").then(),this.$store.dispatch("navigation/main").then(),this.$store.dispatch("user/auth/settings/refresh","personal").then(),this.$store.dispatch("user/auth/settings/navigation/component",this.$api.route("account.settings.navigation")).then())}}};var u=function(){var t=this,e=t._self._c;return e(l,{attrs:{top:t.arrowUp,"offset-y":""},scopedSlots:t._u([{key:"activator",fn:function({on:s,attrs:n,value:a}){return[e(c,t._g(t._b({attrs:{right:t.fixed,fixed:t.fixed,bottom:t.fixed,outlined:"",color:"#ffffff"}},"v-btn",n,!1),s),[e("gb-flag",{staticClass:"mx-auto rounded",attrs:{code:t.getFlag,size:"mini"}}),e(p,{attrs:{right:""}},[t._v(" "+t._s((t.arrowUp?a:!a)?"fa-chevron-down":"fa-chevron-up")+" ")])],1)]}}])},[e(m,{attrs:{dense:""}},t._l(t.items,function(s,n){return e(_,{key:n,staticStyle:{"min-height":"28px"},on:{click:function(a){return t.changeLocale(s)}}},[e("gb-flag",{staticClass:"mx-auto rounded",attrs:{code:n,size:"mini"}})],1)}),1)],1)},h=[],d=r(f,u,h,!1,null,null,null,null);const j=d.exports;export{j as default};