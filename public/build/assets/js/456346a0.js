import{j as l,m}from"./feafbc55.js";import{n as o}from"./75131b1e.js";import{R as c}from"./76f91a17.js";import{m as a,T as d}from"./627c4e78.js";const n=a(c).extend({name:"v-breadcrumbs-item",props:{activeClass:{type:String,default:"v-breadcrumbs__item--disabled"},ripple:{type:[Boolean,Object],default:!1}},computed:{classes(){return{"v-breadcrumbs__item":!0,[this.activeClass]:this.disabled}}},render(t){const{tag:e,data:s}=this.generateRouteLink();return t("li",[t(e,{...s,attrs:{...s.attrs,"aria-current":this.isActive&&this.isLink?"page":void 0}},this.$slots.default)])}}),u=l("v-breadcrumbs__divider","li"),p=a(d).extend({name:"v-breadcrumbs",props:{divider:{type:String,default:"/"},items:{type:Array,default:()=>[]},large:Boolean},computed:{classes(){return{"v-breadcrumbs--large":this.large,...this.themeClasses}}},methods:{genDivider(){return this.$createElement(u,this.$slots.divider?this.$slots.divider:this.divider)},genItems(){const t=[],e=!!this.$scopedSlots.item,s=[];for(let r=0;r<this.items.length;r++){const i=this.items[r];s.push(i.text),e?t.push(this.$scopedSlots.item({item:i})):t.push(this.$createElement(n,{key:s.join("."),props:i},[i.text])),r<this.items.length-1&&t.push(this.genDivider())}return t}},render(t){const e=this.$slots.default||this.genItems();return t("ul",{staticClass:"v-breadcrumbs",class:this.classes},e)}}),h={name:"Breadcrumb",computed:{...m({items:"breadcrumbs/items"})}};var _=function(){var e=this,s=e._self._c;return s(p,{attrs:{items:e.items},scopedSlots:e._u([{key:"item",fn:function({item:r}){return[s(n,{staticClass:"text-subtitle-2 crumb-item",attrs:{to:r.to,exact:""}},[e._v(" "+e._s(r.label)+" ")])]}}])})},b=[],v=o(h,_,b,!1,null,null,null,null);const $=v.exports;export{$ as B};
