import{n as l}from"./75131b1e.js";import{V as o}from"./65a60693.js";import{_ as i}from"./5d3fcc86.js";import{m as a,_ as r,T as c}from"./8ba31e84.js";import{T as d}from"./039e00f1.js";import{V as u,q as h}from"./30fae2fd.js";import"./24ed13ab.js";import"./a5372d14.js";const p=u.extend({name:"transitionable",props:{mode:String,origin:String,transition:String}}),m=a(o,d,p).extend({name:"v-alert",props:{border:{type:String,validator(t){return["top","right","bottom","left"].includes(t)}},closeLabel:{type:String,default:"$vuetify.close"},coloredBorder:Boolean,dense:Boolean,dismissible:Boolean,closeIcon:{type:String,default:"$cancel"},icon:{default:"",type:[Boolean,String],validator(t){return typeof t=="string"||t===!1}},outlined:Boolean,prominent:Boolean,text:Boolean,type:{type:String,validator(t){return["info","error","success","warning"].includes(t)}},value:{type:Boolean,default:!0}},computed:{__cachedBorder(){if(!this.border)return null;let t={staticClass:"v-alert__border",class:{[`v-alert__border--${this.border}`]:!0}};return this.coloredBorder&&(t=this.setBackgroundColor(this.computedColor,t),t.class["v-alert__border--has-color"]=!0),this.$createElement("div",t)},__cachedDismissible(){if(!this.dismissible)return null;const t=this.iconColor;return this.$createElement(i,{staticClass:"v-alert__dismissible",props:{color:t,icon:!0,small:!0},attrs:{"aria-label":this.$vuetify.lang.t(this.closeLabel)},on:{click:()=>this.isActive=!1}},[this.$createElement(r,{props:{color:t}},this.closeIcon)])},__cachedIcon(){return this.computedIcon?this.$createElement(r,{staticClass:"v-alert__icon",props:{color:this.iconColor}},this.computedIcon):null},classes(){const t={...o.options.computed.classes.call(this),"v-alert--border":Boolean(this.border),"v-alert--dense":this.dense,"v-alert--outlined":this.outlined,"v-alert--prominent":this.prominent,"v-alert--text":this.text};return this.border&&(t[`v-alert--border-${this.border}`]=!0),t},computedColor(){return this.color||this.type},computedIcon(){return this.icon===!1?!1:typeof this.icon=="string"&&this.icon?this.icon:["error","info","success","warning"].includes(this.type)?`$${this.type}`:!1},hasColoredIcon(){return this.hasText||Boolean(this.border)&&this.coloredBorder},hasText(){return this.text||this.outlined},iconColor(){return this.hasColoredIcon?this.computedColor:void 0},isDark(){return this.type&&!this.coloredBorder&&!this.outlined?!0:c.options.computed.isDark.call(this)}},created(){this.$attrs.hasOwnProperty("outline")&&h("outline","outlined",this)},methods:{genWrapper(){const t=[this.$slots.prepend||this.__cachedIcon,this.genContent(),this.__cachedBorder,this.$slots.append,this.$scopedSlots.close?this.$scopedSlots.close({toggle:this.toggle}):this.__cachedDismissible],e={staticClass:"v-alert__wrapper"};return this.$createElement("div",e,t)},genContent(){return this.$createElement("div",{staticClass:"v-alert__content"},this.$slots.default)},genAlert(){let t={staticClass:"v-alert",attrs:{role:"alert"},on:this.listeners$,class:this.classes,style:this.styles,directives:[{name:"show",value:this.isActive}]};return this.coloredBorder||(t=(this.hasText?this.setTextColor:this.setBackgroundColor)(this.computedColor,t)),this.$createElement("div",t,[this.genWrapper()])},toggle(){this.isActive=!this.isActive}},render(t){const e=this.genAlert();return this.transition?t("transition",{props:{name:this.transition,origin:this.origin,mode:this.mode}},[e]):e}}),_={name:"Simple",props:{value:{type:Object,required:!0}},methods:{remove(){this.$store.commit("popups/removeNotification",this.value.identifier)}}};var f=function(){var e=this,s=e._self._c;return s(m,e._b({attrs:{border:"left","colored-border":"",transition:"scale-transition"},scopedSlots:e._u([e.value.data.dismissible?{key:"close",fn:function(){return[s(i,{staticClass:"v-alert__dismissible",attrs:{small:"",icon:""},on:{click:e.remove}},[s(r,[e._v("fas fa-times")])],1)]},proxy:!0}:null],null,!0),model:{value:e.value.data.show,callback:function(n){e.$set(e.value.data,"show",n)},expression:"value.data.show"}},"v-alert",e.value.attributes,!1),[s("div",{domProps:{innerHTML:e._s(e.value.content.text)}})])},v=[],g=l(_,f,v,!1,null,null,null,null);const k=g.exports;export{k as default};