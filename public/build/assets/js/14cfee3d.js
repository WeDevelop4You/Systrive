import{C as o}from"./8650efdb.js";import{T as _}from"./9dd6b576.js";import h from"./638aa03d.js";import{n as i}from"./75131b1e.js";import{V as I,g as b,a as l,_ as H,C as v}from"./6208e2c9.js";import{V as f,a as g}from"./ae027585.js";import{_ as N}from"./65408c0c.js";import{_ as B,m as u,C as d,B as A,M as w}from"./590a28b7.js";import{R as k}from"./ed0b44fa.js";import{_ as m}from"./f4d12362.js";import{B as c}from"./95c75297.js";import{B as S}from"./99aee185.js";import{T as R}from"./6bd6fa12.js";import{i as T}from"./58bb7c08.js";import{r as V}from"./17ad2ca9.js";import{V as z}from"./cafb4e72.js";import{_ as G}from"./e656fdfb.js";import{_ as E,a as F}from"./266fe377.js";const r=I.extend({name:"v-list-item-icon",functional:!0,render(n,{data:t,children:e}){return t.staticClass=`v-list-item__icon ${t.staticClass||""}`.trim(),n("div",t,e)}}),P=u(A,S,d,T("list"),R),j=P.extend().extend({name:"v-list-group",directives:{ripple:V},props:{activeClass:{type:String,default:""},appendIcon:{type:String,default:"$expand"},color:{type:String,default:"primary"},disabled:Boolean,group:[String,RegExp],noAction:Boolean,prependIcon:String,ripple:{type:[Boolean,Object],default:!0},subGroup:Boolean},computed:{classes(){return{"v-list-group--active":this.isActive,"v-list-group--disabled":this.disabled,"v-list-group--no-action":this.noAction,"v-list-group--sub-group":this.subGroup}}},watch:{isActive(n){!this.subGroup&&n&&this.list&&this.list.listClick(this._uid)},$route:"onRouteChange"},created(){this.list&&this.list.register(this),this.group&&this.$route&&this.value==null&&(this.isActive=this.matchRoute(this.$route.path))},beforeDestroy(){this.list&&this.list.unregister(this)},methods:{click(n){this.disabled||(this.isBooted=!0,this.$emit("click",n),this.$nextTick(()=>this.isActive=!this.isActive))},genIcon(n){return this.$createElement(B,n)},genAppendIcon(){const n=this.subGroup?!1:this.appendIcon;return!n&&!this.$slots.appendIcon?null:this.$createElement(r,{staticClass:"v-list-group__header__append-icon"},[this.$slots.appendIcon||this.genIcon(n)])},genHeader(){return this.$createElement(m,{staticClass:"v-list-group__header",attrs:{"aria-expanded":String(this.isActive),role:"button"},class:{[this.activeClass]:this.isActive},props:{inputValue:this.isActive},directives:[{name:"ripple",value:this.ripple}],on:{...this.listeners$,click:this.click}},[this.genPrependIcon(),this.$slots.activator,this.genAppendIcon()])},genItems(){return this.showLazyContent(()=>[this.$createElement("div",{staticClass:"v-list-group__items",directives:[{name:"show",value:this.isActive}]},b(this))])},genPrependIcon(){const n=this.subGroup&&this.prependIcon==null?"$subgroup":this.prependIcon;return!n&&!this.$slots.prependIcon?null:this.$createElement(r,{staticClass:"v-list-group__header__prepend-icon"},[this.$slots.prependIcon||this.genIcon(n)])},onRouteChange(n){if(!this.group)return;const t=this.matchRoute(n.path);t&&this.isActive!==t&&this.list&&this.list.listClick(this._uid),this.isActive=t},toggle(n){const t=this._uid===n;t&&(this.isBooted=!0),this.$nextTick(()=>this.isActive=t)},matchRoute(n){return n.match(this.group)!==null}},render(n){return n("div",this.setTextColor(this.isActive&&this.color,{staticClass:"v-list-group",class:this.classes}),[this.genHeader(),n(z,this.genItems())])}});const L=u(c,d).extend({name:"v-list-item-group",provide(){return{isInGroup:!0,listItemGroup:this}},computed:{classes(){return{...c.options.computed.classes.call(this),"v-list-item-group":!0}}},methods:{genData(){return this.setTextColor(this.color,{...c.options.methods.genData.call(this),attrs:{role:"listbox"}})}}});const p=u(d,w,k).extend({name:"v-avatar",props:{left:Boolean,right:Boolean,size:{type:[Number,String],default:48}},computed:{classes(){return{"v-avatar--left":this.left,"v-avatar--right":this.right,...this.roundedClasses}},styles(){return{height:l(this.size),minWidth:l(this.size),width:l(this.size),...this.measurableStyles}}},render(n){const t={staticClass:"v-avatar",class:this.classes,style:this.styles,on:this.$listeners};return n("div",this.setBackgroundColor(this.color,t),this.$slots.default)}}),D=p.extend({name:"v-list-item-avatar",props:{horizontal:Boolean,size:{type:[Number,String],default:40}},computed:{classes(){return{"v-list-item__avatar--horizontal":this.horizontal,...p.options.computed.classes.call(this),"v-avatar--tile":this.tile||this.horizontal}}},render(n){const t=p.options.render.call(this,n);return t.data=t.data||{},t.data.staticClass+=" v-list-item__avatar",t}}),M={name:"NavigationItemIcon",components:{Icon:h},extends:o,props:{isHidden:{type:Boolean,default:!1},center:{type:Boolean,default:!1}}};var O=function(){var t=this,e=t._self._c;return e(r,{staticClass:"justify-center",class:[t.center?"mx-auto":{"mr-2":!t.isHidden}],staticStyle:{"min-width":"40px"}},[e("icon",{attrs:{value:t.component}})],1)},W=[],U=i(M,O,W,!1,null,null,null,null);const $=U.exports,q={name:"CImage",extends:o};var J=function(){var t=this,e=t._self._c;return e(N,t._b({},"v-img",t.component.attributes,!1))},K=[],Q=i(q,J,K,!1,null,null,null,null);const X=Q.exports,Y={name:"NavigationItemIcon",components:{CImage:X},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var Z=function(){var t=this,e=t._self._c;return e(D,{staticClass:"my-0",class:{"mr-2":!t.isHidden},attrs:{"max-width":t.component.attributes.maxWidth,"max-height":t.component.attributes.maxHeight}},[e("c-image",{staticClass:"mx-auto",attrs:{value:t.component}})],1)},tt=[],et=i(Y,Z,tt,!1,null,null,null,null);const nt=et.exports,st={name:"NavigationItem",components:{Tooltip:_,IconComponent:$,ImageComponent:nt},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var ot=function(){var t=this,e=t._self._c;return e("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:s}){return[e(m,t._g(t._b({class:{"pl-2":t.isHidden},attrs:{dense:""},on:{click:function(a){return t.$actions.call(t.component.data.action)}}},"v-list-item",t.component.attributes,!1),s),[t.component.data.prepend?e(t.component.data.prepend.componentName,{tag:"component",attrs:{value:t.component.data.prepend,"is-hidden":t.isHidden}}):t._e(),e(f,[e(g,{domProps:{textContent:t._s(t.component.content.title)}})],1)],1)]}}])})},it=[],at=i(st,ot,it,!1,null,null,null,null);const C=at.exports,rt={name:"NavigationItem",components:{DarkModeSwitchComponent:()=>H(()=>import("./8b8eef4d.js"),["assets/js/8b8eef4d.js","assets/css/88ecae5e.css","assets/js/6208e2c9.js","assets/css/4864f709.css","assets/js/8650efdb.js","assets/js/75131b1e.js","assets/js/36b9b828.js","assets/js/ae027585.js","assets/js/acd73603.js","assets/css/3977ab21.css","assets/js/2cf78807.js","assets/css/ad5269aa.css","assets/js/590a28b7.js","assets/css/025f49a1.css","assets/js/58bb7c08.js","assets/js/17ad2ca9.js","assets/css/62c25b1f.css","assets/js/79032494.js","assets/js/36e454e1.js","assets/js/cafb4e72.js","assets/js/f4d12362.js","assets/css/4d5af27d.css","assets/js/f2966feb.js","assets/js/15010e3a.js","assets/js/6bd6fa12.js","assets/js/9dd6b576.js","assets/css/bc1291ec.css","assets/js/cbc1dd73.js","assets/js/57a61d6a.js","assets/js/99aee185.js","assets/js/60c8b0b9.js","assets/js/de067bf9.js","assets/js/638aa03d.js","assets/js/65408c0c.js","assets/css/f5d19e07.css","assets/js/ed0b44fa.js","assets/css/029efb8b.css","assets/js/95c75297.js","assets/css/b0585eea.css","assets/js/d291a8b0.js","assets/js/e656fdfb.js","assets/css/e89f2dca.css","assets/js/266fe377.js","assets/css/9e64cc89.css"])},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var lt=function(){var t=this,e=t._self._c;return e(t.component.data.type,{tag:"component",attrs:{value:t.component,"is-hidden":t.isHidden}})},ct=[],pt=i(rt,lt,ct,!1,null,null,null,null);const x=pt.exports,ut={name:"NavigationCreateItem",components:{Icon:$,Tooltip:_},extends:o,props:{isHidden:{type:Boolean,default:!1}},data(){return{icon:new v({content:{type:"fas fa-plus"}})}}};var dt=function(){var t=this,e=t._self._c;return e("tooltip",{attrs:{value:t.component.data.tooltip},scopedSlots:t._u([{key:"default",fn:function({tooltip:s}){return[e(m,t._g(t._b({directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],staticClass:"pl-4",attrs:{dense:""},on:{click:function(a){return t.$actions.call(t.component.data.action)}}},"v-list-item",t.component.attributes,!1),s),[e("icon",{staticClass:"mx-auto",attrs:{value:t.icon,center:""}})],1)]}}])})},mt=[],_t=i(ut,dt,mt,!1,null,null,null,null);const y=_t.exports,ht={name:"GroupNavigation",components:{NavigationItemComponent:C,NavigationCreateItemComponent:y,NavigationCustomItemComponent:x},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var vt=function(){var t=this,e=t._self._c;return e(L,{attrs:{color:"primary"}},t._l(t.component.data.navigations,function(s){return e(s.componentName,{key:s.identifier,tag:"component",attrs:{"is-hidden":t.isHidden,value:s}})}),1)},ft=[],gt=i(ht,vt,ft,!1,null,null,null,null);const $t=gt.exports,Ct={name:"CollapseNavigation",components:{Icon:h,NavigationItemComponent:C,NavigationCreateItemComponent:y,NavigationCustomItemComponent:x},extends:o,props:{isHidden:{type:Boolean,default:!1}},data(){return{defaultIcon:new v({content:{type:"fas fa-list"}})}}};var xt=function(){var t=this,e=t._self._c;return e(j,{attrs:{"no-action":"",color:"text--primary"},scopedSlots:t._u([{key:"activator",fn:function(){return[e(r,{directives:[{name:"show",rawName:"v-show",value:t.component.data.icon||t.isHidden,expression:"component.data.icon || isHidden"}],staticClass:"justify-center",class:[t.isHidden?"ml-n2":"mr-2"],staticStyle:{"min-width":"40px"}},[e("icon",{attrs:{value:t.component.data.icon||t.defaultIcon}})],1),e(f,[e(g,{domProps:{textContent:t._s(t.component.content.title)}})],1)]},proxy:!0}])},t._l(t.component.data.navigations,function(s){return e(s.componentName,{directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],key:s.identifier,tag:"component",attrs:{"is-hidden":t.isHidden,value:s}})}),1)},yt=[],It=i(Ct,xt,yt,!1,null,null,null,null);const bt=It.exports,Ht={name:"Navbar",components:{GroupNavigationComponent:$t,CollapseNavigationComponent:bt},extends:o,props:{isHidden:{type:Boolean,default:!1}}};var Nt=function(){var t=this,e=t._self._c;return e(G,t._b({attrs:{dense:""}},"v-list",t.component.attributes,!1),[t._l(t.component.data.list,function(s,a){return[s.subheader?[e(E,{directives:[{name:"show",rawName:"v-show",value:!t.isHidden,expression:"!isHidden"}],key:a,staticClass:"mb-1",staticStyle:{height:"20px"}},[t._v(" "+t._s(s.subheader)+" ")])]:s.divider?[e(F,{key:a,staticClass:"my-1"})]:[e(s.componentName,{key:a,tag:"component",attrs:{value:s,"is-hidden":t.isHidden}})]]})],2)},Bt=[],At=i(Ht,Nt,Bt,!1,null,null,null,null);const wt=At.exports,Jt=Object.freeze(Object.defineProperty({__proto__:null,default:wt},Symbol.toStringTag,{value:"Module"}));export{wt as N,$ as a,Jt as b};
