import{n as l}from"./75131b1e.js";import{R as o}from"./165252c7.js";import{m as n,T as m}from"./e0db1d00.js";import{n as c}from"./5ecbb865.js";const a=n(o).extend({name:"v-breadcrumbs-item",props:{activeClass:{type:String,default:"v-breadcrumbs__item--disabled"},ripple:{type:[Boolean,Object],default:!1}},computed:{classes(){return{"v-breadcrumbs__item":!0,[this.activeClass]:this.disabled}}},render(t){const{tag:e,data:s}=this.generateRouteLink();return t("li",[t(e,{...s,attrs:{...s.attrs,"aria-current":this.isActive&&this.isLink?"page":void 0}},this.$slots.default)])}}),u=c("v-breadcrumbs__divider","li"),d=n(m).extend({name:"v-breadcrumbs",props:{divider:{type:String,default:"/"},items:{type:Array,default:()=>[]},large:Boolean},computed:{classes(){return{"v-breadcrumbs--large":this.large,...this.themeClasses}}},methods:{genDivider(){return this.$createElement(u,this.$slots.divider?this.$slots.divider:this.divider)},genItems(){const t=[],e=!!this.$scopedSlots.item,s=[];for(let r=0;r<this.items.length;r++){const i=this.items[r];s.push(i.text),e?t.push(this.$scopedSlots.item({item:i})):t.push(this.$createElement(a,{key:s.join("."),props:i},[i.text])),r<this.items.length-1&&t.push(this.genDivider())}return t}},render(t){const e=this.$slots.default||this.genItems();return t("ul",{staticClass:"v-breadcrumbs",class:this.classes},e)}}),p={name:"Breadcrumb",computed:{items(){return this.$breadcrumbs.items}}};var h=function(){var e=this,s=e._self._c;return s(d,{attrs:{items:e.items},scopedSlots:e._u([{key:"item",fn:function({item:r}){return[s(a,{staticClass:"text-subtitle-2 crumb-item",attrs:{to:r.to,exact:""}},[e._v(" "+e._s(r.label)+" ")])]}}])})},_=[],b=l(p,h,_,!1,null,null,null,null);const $=b.exports;export{$ as B};
