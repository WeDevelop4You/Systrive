"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[3647],{6469:(e,t,a)=>{a.r(t),a.d(t,{default:()=>c});const n={name:"Url",mixins:[a(5535).Z]};var o=a(1900),s=a(3453),l=a.n(s),i=a(9657),r=a(4963),u=(0,o.Z)(n,(function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[e.value.content.value?a("v-hover",{scopedSlots:e._u([{key:"default",fn:function(t){var n=t.hover;return[a("a",{class:[n?"primary--text":e.value.data.color],staticStyle:{"max-width":"max-content"},attrs:{href:e.value.content.value,target:"_blank"}},[e._v("\n            "+e._s(e.value.content.anchor||e.value.content.value.replace(/(^\w+:|^)\/\//,""))+"\n            "),a("v-icon",{staticClass:"mt-n1",class:[n?"primary--text":e.value.data.color],staticStyle:{transition:"none"},attrs:{size:"20"}},[e._v("\n                fa-external-link-alt\n            ")])],1)]}}])}):[e._v("\n        "+e._s(e.$vuetify.lang.t("$vuetify.word.no_content"))+"\n    ")]],2)}),[],!1,null,null,null);const c=u.exports;l()(u,{VHover:i.Z,VIcon:r.Z})},9657:(e,t,a)=>{a.d(t,{Z:()=>i});var n=a(1811),o=a(4552),s=a(5530),l=a(8219);const i=(0,s.Z)(n.Z,o.Z).extend({name:"v-hover",props:{disabled:{type:Boolean,default:!1},value:{type:Boolean,default:void 0}},methods:{onMouseEnter(){this.runDelay("open")},onMouseLeave(){this.runDelay("close")}},render(){if(!this.$scopedSlots.default&&void 0===this.value)return(0,l.Kd)("v-hover is missing a default scopedSlot or bound value",this),null;let e;return this.$scopedSlots.default&&(e=this.$scopedSlots.default({hover:this.isActive})),Array.isArray(e)&&1===e.length&&(e=e[0]),e&&!Array.isArray(e)&&e.tag?(this.disabled||(e.data=e.data||{},this._g(e.data,{mouseenter:this.onMouseEnter,mouseleave:this.onMouseLeave})),e):((0,l.Kd)("v-hover should only contain a single element",this),e)}})},1811:(e,t,a)=>{a.d(t,{Z:()=>n});const n=a(538).Z.extend().extend({name:"delayable",props:{openDelay:{type:[Number,String],default:0},closeDelay:{type:[Number,String],default:0}},data:()=>({openTimeout:void 0,closeTimeout:void 0}),methods:{clearDelay(){clearTimeout(this.openTimeout),clearTimeout(this.closeTimeout)},runDelay(e,t){this.clearDelay();const a=parseInt(this[`${e}Delay`],10);this[`${e}Timeout`]=setTimeout(t||(()=>{this.isActive={open:!0,close:!1}[e]}),a)}}})}}]);