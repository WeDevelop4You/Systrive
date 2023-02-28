import{C as d}from"./e63a8b3a.js";import{n as h}from"./75131b1e.js";import{B as o}from"./41901c56.js";import{I as l,h as t}from"./12a8f78c.js";import{f as u}from"./f03d37af.js";import{p as x,i as r}from"./517420cd.js";import{m as a,C as p,_ as v}from"./dcc38a7c.js";import{V as m,a as _}from"./887f6627.js";import{B as f}from"./0a0e57c8.js";import{r as g}from"./4516f3b3.js";import"./d2e49a62.js";import"./bda96ba9.js";const b=o.extend({name:"v-expansion-panels",provide(){return{expansionPanels:this}},props:{accordion:Boolean,disabled:Boolean,flat:Boolean,hover:Boolean,focusable:Boolean,inset:Boolean,popout:Boolean,readonly:Boolean,tile:Boolean},computed:{classes(){return{...o.options.computed.classes.call(this),"v-expansion-panels":!0,"v-expansion-panels--accordion":this.accordion,"v-expansion-panels--flat":this.flat,"v-expansion-panels--hover":this.hover,"v-expansion-panels--focusable":this.focusable,"v-expansion-panels--inset":this.inset,"v-expansion-panels--popout":this.popout,"v-expansion-panels--tile":this.tile}}},created(){this.$attrs.hasOwnProperty("expand")&&l("expand","multiple",this),Array.isArray(this.value)&&this.value.length>0&&typeof this.value[0]=="boolean"&&l(':value="[true, false, true]"',':value="[0, 2]"',this)},methods:{updateItem(e,n){const s=this.getValue(e,n),i=this.getValue(e,n+1);e.isActive=this.toggleMethod(s),e.nextIsActive=this.toggleMethod(i)}}}),C=a(u("expansionPanels","v-expansion-panel","v-expansion-panels"),x("expansionPanel",!0)).extend({name:"v-expansion-panel",props:{disabled:Boolean,readonly:Boolean},data(){return{content:null,header:null,nextIsActive:!1}},computed:{classes(){return{"v-expansion-panel--active":this.isActive,"v-expansion-panel--next-active":this.nextIsActive,"v-expansion-panel--disabled":this.isDisabled,...this.groupClasses}},isDisabled(){return this.expansionPanels.disabled||this.disabled},isReadonly(){return this.expansionPanels.readonly||this.readonly}},methods:{registerContent(e){this.content=e},unregisterContent(){this.content=null},registerHeader(e){this.header=e,e.$on("click",this.onClick)},unregisterHeader(){this.header=null},onClick(e){e.detail&&this.header.$el.blur(),this.$emit("click",e),this.isReadonly||this.isDisabled||this.toggle()},toggle(){this.$nextTick(()=>this.$emit("change"))}},render(e){return e("div",{staticClass:"v-expansion-panel",class:this.classes,attrs:{"aria-expanded":String(this.isActive)}},t(this))}}),y=a(f,p,r("expansionPanel","v-expansion-panel-content","v-expansion-panel")),A=y.extend().extend({name:"v-expansion-panel-content",data:()=>({isActive:!1}),computed:{parentIsActive(){return this.expansionPanel.isActive}},watch:{parentIsActive:{immediate:!0,handler(e,n){e&&(this.isBooted=!0),n==null?this.isActive=e:this.$nextTick(()=>this.isActive=e)}}},created(){this.expansionPanel.registerContent(this)},beforeDestroy(){this.expansionPanel.unregisterContent()},render(e){return e(m,this.showLazyContent(()=>[e("div",this.setBackgroundColor(this.color,{staticClass:"v-expansion-panel-content",directives:[{name:"show",value:this.isActive}]}),[e("div",{class:"v-expansion-panel-content__wrap"},t(this))])]))}}),B=a(p,r("expansionPanel","v-expansion-panel-header","v-expansion-panel")),P=B.extend().extend({name:"v-expansion-panel-header",directives:{ripple:g},props:{disableIconRotate:Boolean,expandIcon:{type:String,default:"$expand"},hideActions:Boolean,ripple:{type:[Boolean,Object],default:!1}},data:()=>({hasMousedown:!1}),computed:{classes(){return{"v-expansion-panel-header--active":this.isActive,"v-expansion-panel-header--mousedown":this.hasMousedown}},isActive(){return this.expansionPanel.isActive},isDisabled(){return this.expansionPanel.isDisabled},isReadonly(){return this.expansionPanel.isReadonly}},created(){this.expansionPanel.registerHeader(this)},beforeDestroy(){this.expansionPanel.unregisterHeader()},methods:{onClick(e){this.$emit("click",e)},genIcon(){const e=t(this,"actions")||[this.$createElement(v,this.expandIcon)];return this.$createElement(_,[this.$createElement("div",{staticClass:"v-expansion-panel-header__icon",class:{"v-expansion-panel-header__icon--disable-rotate":this.disableIconRotate},directives:[{name:"show",value:!this.isDisabled}]},e)])}},render(e){return e("button",this.setBackgroundColor(this.color,{staticClass:"v-expansion-panel-header",class:this.classes,attrs:{tabindex:this.isDisabled?-1:null,type:"button","aria-expanded":this.isActive},directives:[{name:"ripple",value:this.ripple}],on:{...this.$listeners,click:this.onClick,mousedown:()=>this.hasMousedown=!0,mouseup:()=>this.hasMousedown=!1}}),[t(this,"default",{open:this.isActive},!0),this.hideActions||this.genIcon()])}}),$={name:"SourceExpansion",extends:d};var k=function(){var n=this,s=n._self._c;return s(b,{staticClass:"text--disabled",staticStyle:{border:"1px solid"},attrs:{flat:""}},[s(C,[s(P,{staticClass:"px-3 py-2",staticStyle:{"min-height":"40px"}},[n._v(" "+n._s(n.component.content.label)+" ")]),s(A,{staticClass:"translation"},[s("ul",n._l(n.component.data.sources,function(i,c){return s("li",{key:c},[n._v(" "+n._s(i)+" ")])}),0)])],1)],1)},I=[],w=h($,k,I,!1,null,null,null,null);const G=w.exports;export{G as default};
