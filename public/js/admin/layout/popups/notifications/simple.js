"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[231],{1941:(t,e,s)=>{s.r(e),s.d(e,{default:()=>b});const o={name:"Simple",props:{data:{type:Object,required:!0}},data:function(){return{show:!1,message:this.data.message}},mounted:function(){this.show=!0},methods:{remove:function(){this.$store.commit("popups/removeNotifications",this.data.uuid)}}};var i=s(1900),r=s(3453),n=s.n(r),l=s(9744),a=s(8205),c=s(9524),d=s(4552),h=s(2066);const u=s(538).Z.extend({name:"transitionable",props:{mode:String,origin:String,transition:String}});var p=s(5530),m=s(8219);const v=(0,p.Z)(l.Z,d.Z,u).extend({name:"v-alert",props:{border:{type:String,validator:t=>["top","right","bottom","left"].includes(t)},closeLabel:{type:String,default:"$vuetify.close"},coloredBorder:Boolean,dense:Boolean,dismissible:Boolean,closeIcon:{type:String,default:"$cancel"},icon:{default:"",type:[Boolean,String],validator:t=>"string"==typeof t||!1===t},outlined:Boolean,prominent:Boolean,text:Boolean,type:{type:String,validator:t=>["info","error","success","warning"].includes(t)},value:{type:Boolean,default:!0}},computed:{__cachedBorder(){if(!this.border)return null;let t={staticClass:"v-alert__border",class:{[`v-alert__border--${this.border}`]:!0}};return this.coloredBorder&&(t=this.setBackgroundColor(this.computedColor,t),t.class["v-alert__border--has-color"]=!0),this.$createElement("div",t)},__cachedDismissible(){if(!this.dismissible)return null;const t=this.iconColor;return this.$createElement(a.Z,{staticClass:"v-alert__dismissible",props:{color:t,icon:!0,small:!0},attrs:{"aria-label":this.$vuetify.lang.t(this.closeLabel)},on:{click:()=>this.isActive=!1}},[this.$createElement(c.Z,{props:{color:t}},this.closeIcon)])},__cachedIcon(){return this.computedIcon?this.$createElement(c.Z,{staticClass:"v-alert__icon",props:{color:this.iconColor}},this.computedIcon):null},classes(){const t={...l.Z.options.computed.classes.call(this),"v-alert--border":Boolean(this.border),"v-alert--dense":this.dense,"v-alert--outlined":this.outlined,"v-alert--prominent":this.prominent,"v-alert--text":this.text};return this.border&&(t[`v-alert--border-${this.border}`]=!0),t},computedColor(){return this.color||this.type},computedIcon(){return!1!==this.icon&&("string"==typeof this.icon&&this.icon?this.icon:!!["error","info","success","warning"].includes(this.type)&&`$${this.type}`)},hasColoredIcon(){return this.hasText||Boolean(this.border)&&this.coloredBorder},hasText(){return this.text||this.outlined},iconColor(){return this.hasColoredIcon?this.computedColor:void 0},isDark(){return!(!this.type||this.coloredBorder||this.outlined)||h.Z.options.computed.isDark.call(this)}},created(){this.$attrs.hasOwnProperty("outline")&&(0,m.fK)("outline","outlined",this)},methods:{genWrapper(){const t=[this.$slots.prepend||this.__cachedIcon,this.genContent(),this.__cachedBorder,this.$slots.append,this.$scopedSlots.close?this.$scopedSlots.close({toggle:this.toggle}):this.__cachedDismissible];return this.$createElement("div",{staticClass:"v-alert__wrapper"},t)},genContent(){return this.$createElement("div",{staticClass:"v-alert__content"},this.$slots.default)},genAlert(){let t={staticClass:"v-alert",attrs:{role:"alert"},on:this.listeners$,class:this.classes,style:this.styles,directives:[{name:"show",value:this.isActive}]};if(!this.coloredBorder){t=(this.hasText?this.setTextColor:this.setBackgroundColor)(this.computedColor,t)}return this.$createElement("div",t,[this.genWrapper()])},toggle(){this.isActive=!this.isActive}},render(t){const e=this.genAlert();return this.transition?t("transition",{props:{name:this.transition,origin:this.origin,mode:this.mode}},[e]):e}});var g=s(1111),_=s(8766),f=(0,i.Z)(o,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-alert",{attrs:{value:t.show,icon:t.message.icon,type:t.message.type,color:t.message.color,elevation:t.$config.elevation,border:"left","colored-border":"",transition:"scale-transition"},scopedSlots:t._u([t.data.dismissible?{key:"close",fn:function(){return[s("v-btn",{staticClass:"v-alert__dismissible",attrs:{small:"",icon:""},on:{click:t.remove}},[s("v-icon",[t._v("fas fa-times")])],1)]},proxy:!0}:null],null,!0)},[s("div",{domProps:{innerHTML:t._s(t.message.text)}})])}),[],!1,null,null,null);const b=f.exports;n()(f,{VAlert:v,VBtn:g.Z,VIcon:_.Z})},8205:(t,e,s)=>{s.d(e,{Z:()=>o});const o=s(1111).Z}}]);