"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[219],{5383:(e,t,a)=>{a.r(t),a.d(t,{default:()=>d});const s={name:"Url",props:{value:{required:!0,type:String},anchor:{type:String,default:""},color:{type:String,default:"text--secondary"}}};var n=a(1900),r=a(3453),o=a.n(r),l=a(9657),i=a(8766),u=(0,n.Z)(s,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("v-hover",{scopedSlots:e._u([{key:"default",fn:function(t){var s=t.hover;return[a("a",{class:[s?"primary--text":e.color],attrs:{href:e.value,target:"_blank"}},[e._v("\n        "+e._s(e.anchor||e.value.replace(/(^\w+:|^)\/\//,""))+"\n        "),a("v-icon",{staticClass:"mt-n1",class:[s?"primary--text":e.color],staticStyle:{transition:"none"},attrs:{size:"20"}},[e._v("\n            fa-external-link-alt\n        ")])],1)]}}])})}),[],!1,null,null,null);const d=u.exports;o()(u,{VHover:l.Z,VIcon:i.Z})},9657:(e,t,a)=>{a.d(t,{Z:()=>l});var s=a(1811),n=a(4552),r=a(5530),o=a(8219);const l=(0,r.Z)(s.Z,n.Z).extend({name:"v-hover",props:{disabled:{type:Boolean,default:!1},value:{type:Boolean,default:void 0}},methods:{onMouseEnter(){this.runDelay("open")},onMouseLeave(){this.runDelay("close")}},render(){if(!this.$scopedSlots.default&&void 0===this.value)return(0,o.Kd)("v-hover is missing a default scopedSlot or bound value",this),null;let e;return this.$scopedSlots.default&&(e=this.$scopedSlots.default({hover:this.isActive})),Array.isArray(e)&&1===e.length&&(e=e[0]),e&&!Array.isArray(e)&&e.tag?(this.disabled||(e.data=e.data||{},this._g(e.data,{mouseenter:this.onMouseEnter,mouseleave:this.onMouseLeave})),e):((0,o.Kd)("v-hover should only contain a single element",this),e)}})}}]);