import{l as o}from"./5ecbb865.js";import{F as a}from"./2a42de1a.js";import{n as m}from"./75131b1e.js";import{_ as l}from"./c71827a8.js";import"./35f22181.js";import"./f55d25f8.js";import"./76252812.js";import"./e0db1d00.js";import"./16a5c7a5.js";import"./63395702.js";import"./10723b79.js";import"./4d23891e.js";import"./e4160f91.js";import"./0f1ce05e.js";import"./00924962.js";import"./f57264bf.js";const c={name:"NumberInput",extends:a,data(){return{total:6,places:2,regex:"",number:"",original:"",isNumeric:!1}},created(){const e=this.component.data.isNumeric||!1;this.isNumeric=e,this.number=this.getValue,this.original=this.getValue,this.total=this.component.data.total,this.places=this.component.data.places,this.regex=e?"[^0-9.]":"[^0-9]"},methods:{format(e){this.$nextTick(()=>{const t=this.$refs.number.$refs.input,s=t.selectionStart;let i=e.replace(",",".").replace(new RegExp(this.regex,"g"),"");this.isNumeric&&(i=this.formatNumeric(i)),e.startsWith("-")&&(i=`-${i}`),this.setValue(i),this.$nextTick(()=>{const r=s-(i!==e);t.setSelectionRange(s,r,"none")})}),this.clearError(this.key)},setValue(e){this.number=e,this.original=e,this.data=Object.assign({},o.exports.set(this.data,this.key,e))},formatNumeric(e){const t=e.includes("."),s=t?this.findDotIndex(e):e.length,i=e.substring(0,s).replace(".",""),n=e.substring(s+1).replace(".","").substring(0,this.places);let r=i;return i.length>this.total&&(r=i.slice(-this.total)),t&&(r+=`.${n}`),r},findDotIndex(e){let t=e.indexOf(".");return this.original!==null&&e.split("").every((s,i)=>s!==this.original.charAt(i)&&s==="."?(t=i,!1):!0),t}}};var u=function(){var t=this,s=t._self._c;return s(l,t._b({directives:[{name:"show",rawName:"v-show",value:t.isHidden,expression:"isHidden"}],ref:"number",class:[{"v-input-hidden":!t.isHidden},t.component.attributes.class],attrs:{disabled:t.isDisabled,label:t.component.content.label,"error-messages":t.errorMessages,"hide-details":t.hideDetails},on:{input:function(i){return t.format(i)}},model:{value:t.number,callback:function(i){t.number=i},expression:"number"}},"v-text-field",t.component.attributes,!1))},p=[],h=m(c,u,p,!1,null,null,null,null);const H=h.exports;export{H as default};
