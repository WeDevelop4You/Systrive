import{C as o}from"./e63a8b3a.js";import{T as d}from"./77c2c49e.js";import m from"./ab7dd6a0.js";import y from"./bb2da526.js";import{V as I,h as N,f as c,C as _,_ as H}from"./12a8f78c.js";import{n as i}from"./75131b1e.js";import{_ as l}from"./da1824ff.js";import{V as f,a as g,b as w}from"./dd17033c.js";import{_ as B,m as h,C as v,B as A,M as k}from"./dcc38a7c.js";import{R as S}from"./4e01a737.js";import{B as p}from"./41901c56.js";import{B as R}from"./0a0e57c8.js";import{T as V}from"./12d57222.js";import{i as T}from"./517420cd.js";import{r as z}from"./4516f3b3.js";import{V as G}from"./887f6627.js";import{_ as E}from"./6590abf9.js";import{_ as P}from"./3f0873a2.js";import{_ as F}from"./8e2d7f23.js";const r=I.extend({name:"v-list-item-icon",functional:!0,render(n,{data:t,children:e}){return t.staticClass=`v-list-item__icon ${t.staticClass||""}`.trim(),n("div",t,e)}}),L=h(A,R,v,T("list"),V),j=L.extend().extend({name:"v-list-group",directives:{ripple:z},props:{activeClass:{type:String,default:""},appendIcon:{type:String,default:"$expand"},color:{type:String,default:"primary"},disabled:Boolean,group:[String,RegExp],noAction:Boolean,prependIcon:String,ripple:{type:[Boolean,Object],default:!0},subGroup:Boolean},computed:{classes(){return{"v-list-group--active":this.isActive,"v-list-group--disabled":this.disabled,"v-list-group--no-action":this.noAction,"v-list-group--sub-group":this.subGroup}}},watch:{isActive(n){!this.subGroup&&n&&this.list&&this.list.listClick(this._uid)},$route:"onRouteChange"},created(){this.list&&this.list.register(this),this.group&&this.$route&&this.value==null&&(this.isActive=this.matchRoute(this.$route.path))},beforeDestroy(){this.list&&this.list.unregister(this)},methods:{click(n){this.disabled||(this.isBooted=!0,this.$emit("click",n),this.$nextTick(()=>this.isActive=!this.isActive))},genIcon(n){return this.$createElement(B,n)},genAppendIcon(){const n=this.subGroup?!1:this.appendIcon;return!n&&!this.$slots.appendIcon?null:this.$createElement(r,{staticClass:"v-list-group__header__append-icon"},[this.$slots.appendIcon||this.genIcon(n)])},genHeader(){return this.$createElement(l,{staticClass:"v-list-group__header",attrs:{"aria-expanded":String(this.isActive),role:"button"},class:{[this.activeClass]:this.isActive},props:{inputValue:this.isActive},directives:[{name:"ripple",value:this.ripple}],on:{...this.listeners$,click:this.click}},[this.genPrependIcon(),this.$slots.activator,this.genAppendIcon()])},genItems(){return this.showLazyContent(()=>[this.$createElement("div",{staticClass:"v-list-group__items",directives:[{name:"show",value:this.isActive}]},N(this))])},genPrependIcon(){const n=this.subGroup&&this.prependIcon==null?"$subgroup":this.prependIcon;return!n&&!this.$slots.prependIcon?null:this.$createElement(r,{staticClass:"v-list-group__header__prepend-icon"},[this.$slots.prependIcon||this.genIcon(n)])},onRouteChange(n){if(!this.group)return;const t=this.matchRoute(n.path);t&&this.isActive!==t&&this.list&&this.list.listClick(this._uid),this.isActive=t},toggle(n){const t=this._uid===n;t&&(this.isBooted=!0),this.$nextTick(()=>this.isActive=t)},matchRoute(n){return n.match(this.group)!==null}},render(n){return n("div",this.setTextColor(this.isActive&&this.color,{staticClass:"v-list-group",class:this.classes}),[this.genHeader(),n(G,this.genItems())])}});const D=h(p,v).extend({name:"v-list-item-group",provide(){return{isInGroup:!0,listItemGroup:this}},computed:{classes(){return{...p.options.computed.classes.call(this),"v-list-item-group":!0}}},methods:{genData(){return this.setTextColor(this.color,{...p.options.methods.genData.call(this),attrs:{role:"listbox"}})}}});const u=h(v,k,S).extend({name:"v-avatar",props:{left:Boolean,right:Boolean,size:{type:[Number,String],default:48}},computed:{classes(){return{"v-avatar--left":this.left,"v-avatar--right":this.right,...this.roundedClasses}},styles(){return{height:c(this.size),minWidth:c(this.size),width:c(this.size),...this.measurableStyles}}},render(n){const t={staticClass:"v-avatar",class:this.classes,style:this.styles,on:this.$listeners};return n("div",this.setBackgroundColor(this.color,t),this.$slots.default)}}),M=u.extend({name:"v-list-item-avatar",props:{horizontal:Boolean,size:{type:[Number,String],default:40}},computed:{classes(){return{"v-list-item__avatar--horizontal":this.horizontal,...u.options.computed.classes.call(this),"v-avatar--tile":this.tile||this.horizontal}}},render(n){const t=u.options.render.call(this,n);return t.data=t.data||{},t.data.staticClass+=" v-list-item__avatar",t}}),O={name:"NavigationItem",components:{Tooltip:d,IconComponent:m,ImageComponent:y},extends:o,props:{isHidden:{type:Boolean,default:!1}},data(){return{prepend:new _(this.value.data.prepend||{})}}};var W=function(){var t=this,e=t._self._c;return e("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:s}){return[e(l,t._g(t._b({class:{"pl-2":t.isHidden},attrs:{dense:"",exact:""},on:{click:function(a){return t.$actions.call(t.component.data.action)}}},"v-list-item",t.component.attributes,!1),s),[t.prepend?[t.prepend.componentName==="IconComponent"?e(r,{staticClass:"mx-auto justify-center",staticStyle:{"min-width":"40px"}},[e("IconComponent",{attrs:{value:t.prepend}})],1):t.prepend.componentName==="ImageComponent"?e(M,{staticClass:"my-0",class:{"mr-2":!t.isHidden},attrs:{"max-width":t.prepend.attributes.maxWidth,"max-height":t.prepend.attributes.maxHeight}},[e("ImageComponent",{staticClass:"mx-auto",attrs:{value:t.prepend}})],1):t._e()]:t._e(),e(f,[e(g,{domProps:{textContent:t._s(t.component.content.title)}}),t.component.content.description?e(w,{domProps:{textContent:t._s(t.component.content.description)}}):t._e()],1)],2)]}}])})},U=[],q=i(O,W,U,!1,null,null,null,null);const C=q.exports,J={name:"NavigationItem",components:{DarkModeSwitchComponent:()=>H(()=>import("./ebb71a1a.js"),["assets/js/ebb71a1a.js","assets/css/88ecae5e.css","assets/js/ab7dd6a0.js","assets/js/e63a8b3a.js","assets/js/12a8f78c.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/dcc38a7c.js","assets/css/025f49a1.css","assets/js/d4d55fcc.js","assets/js/dd17033c.js","assets/js/1f7af962.js","assets/css/3977ab21.css","assets/js/c8f02950.js","assets/css/ad5269aa.css","assets/js/517420cd.js","assets/js/4516f3b3.js","assets/css/62c25b1f.css","assets/js/d2e49a62.js","assets/js/56cedc9b.js","assets/js/887f6627.js","assets/js/da1824ff.js","assets/css/4d5af27d.css","assets/js/42aaffeb.js","assets/js/f03d37af.js","assets/js/12d57222.js","assets/js/77c2c49e.js","assets/css/bc1291ec.css","assets/js/068f7ff1.js","assets/js/2610d196.js","assets/js/0a0e57c8.js","assets/js/63539db6.js","assets/js/6dc30b97.js","assets/js/bb2da526.js","assets/js/25bd67b4.js","assets/css/f5d19e07.css","assets/js/4e01a737.js","assets/css/029efb8b.css","assets/js/41901c56.js","assets/css/b0585eea.css","assets/js/bda96ba9.js","assets/js/6590abf9.js","assets/css/e89f2dca.css","assets/js/3f0873a2.js","assets/css/c4cf8052.css","assets/js/8e2d7f23.js","assets/css/44e3c463.css"])},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var K=function(){var t=this,e=t._self._c;return e(t.component.data.type,{tag:"component",attrs:{value:t.component,"is-hidden":t.isHidden}})},Q=[],X=i(J,K,Q,!1,null,null,null,null);const $=X.exports,Y={name:"NavigationCreateItem",components:{Icon:m,Tooltip:d},extends:o,props:{isHidden:{type:Boolean,default:!1}},data(){return{icon:new _({content:{type:"fas fa-plus"}})}}};var Z=function(){var t=this,e=t._self._c;return e("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:s}){return[e(l,t._g(t._b({directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],staticClass:"pl-4",attrs:{dense:""},on:{click:function(a){return t.$actions.call(t.component.data.action)}}},"v-list-item",t.component.attributes,!1),s),[e("icon",{staticClass:"mx-auto",attrs:{value:t.icon,center:""}})],1)]}}])})},tt=[],et=i(Y,Z,tt,!1,null,null,null,null);const x=et.exports,nt={name:"NavigationCreateItem",components:{Tooltip:d},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var st=function(){var t=this,e=t._self._c;return e("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:s}){return[e(l,t._g(t._b({directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],staticClass:"pl-4 text--secondary",attrs:{ripple:!1,dense:"",inactive:""}},"v-list-item",t.component.attributes,!1),s),[e("span",{staticClass:"mx-auto",domProps:{textContent:t._s(t.component.content.title)}})])]}}])})},ot=[],it=i(nt,st,ot,!1,null,null,null,null);const b=it.exports,at={name:"GroupNavigation",components:{NavigationItemComponent:C,NavigationCreateItemComponent:x,NavigationCustomItemComponent:$,NavigationContentItemComponent:b},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var rt=function(){var t=this,e=t._self._c;return e(D,{attrs:{color:"primary"}},t._l(t.component.data.navigations,function(s){return e(s.componentName,{key:s.identifier,tag:"component",attrs:{"is-hidden":t.isHidden,value:s}})}),1)},lt=[],ct=i(at,rt,lt,!1,null,null,null,null);const pt=ct.exports,ut={name:"CollapseNavigation",components:{Icon:m,NavigationItemComponent:C,NavigationCreateItemComponent:x,NavigationCustomItemComponent:$,NavigationContentItemComponent:b},extends:o,props:{isHidden:{type:Boolean,default:!1}},data(){return{defaultIcon:new _({content:{type:"fas fa-list"}})}}};var dt=function(){var t=this,e=t._self._c;return e(j,{attrs:{"no-action":"",color:"text--primary"},scopedSlots:t._u([{key:"activator",fn:function(){return[e(r,{directives:[{name:"show",rawName:"v-show",value:t.component.data.icon||t.isHidden,expression:"component.data.icon || isHidden"}],staticClass:"justify-center",class:[t.isHidden?"ml-n2":"mr-2"],staticStyle:{"min-width":"40px"}},[e("icon",{attrs:{value:t.component.data.icon||t.defaultIcon}})],1),e(f,[e(g,{domProps:{textContent:t._s(t.component.content.title)}})],1)]},proxy:!0}])},t._l(t.component.data.navigations,function(s){return e(s.componentName,{directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],key:s.identifier,tag:"component",attrs:{"is-hidden":t.isHidden,value:s}})}),1)},mt=[],_t=i(ut,dt,mt,!1,null,null,null,null);const ht=_t.exports,vt={name:"Navbar",components:{GroupNavigationComponent:pt,CollapseNavigationComponent:ht},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var ft=function(){var t=this,e=t._self._c;return e(E,t._b({attrs:{dense:""}},"v-list",t.component.attributes,!1),[t._l(t.component.data.list,function(s,a){return[s.subheader?[e(P,{directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],key:a,staticClass:"mb-1",staticStyle:{height:"20px"}},[t._v(" "+t._s(s.subheader)+" ")])]:s.divider?[e(F,{key:a,staticClass:"my-1"})]:[e(s.componentName,{key:a,tag:"component",attrs:{value:s,"is-hidden":t.isHidden}})]]})],2)},gt=[],Ct=i(vt,ft,gt,!1,null,null,null,null);const $t=Ct.exports,Lt=Object.freeze(Object.defineProperty({__proto__:null,default:$t},Symbol.toStringTag,{value:"Module"}));export{$t as N,r as _,Lt as a};