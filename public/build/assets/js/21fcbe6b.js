import{D as t}from"./57a61d6a.js";import{T as s}from"./6bd6fa12.js";import{m as a}from"./590a28b7.js";import{c as o}from"./6208e2c9.js";const u=a(t,s).extend({name:"v-hover",props:{disabled:{type:Boolean,default:!1},value:{type:Boolean,default:void 0}},methods:{onMouseEnter(){this.runDelay("open")},onMouseLeave(){this.runDelay("close")}},render(){if(!this.$scopedSlots.default&&this.value===void 0)return o("v-hover is missing a default scopedSlot or bound value",this),null;let e;return this.$scopedSlots.default&&(e=this.$scopedSlots.default({hover:this.isActive})),Array.isArray(e)&&e.length===1&&(e=e[0]),!e||Array.isArray(e)||!e.tag?(o("v-hover should only contain a single element",this),e):(this.disabled||(e.data=e.data||{},this._g(e.data,{mouseenter:this.onMouseEnter,mouseleave:this.onMouseLeave})),e)}});export{u as _};
