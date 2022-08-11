import{m as n,T as o,C as r}from"./8ba31e84.js";import{R as s}from"./65a60693.js";import{f as h,a as d}from"./039e00f1.js";import{r as c}from"./24ed13ab.js";import{r as u,k as m}from"./30fae2fd.js";const f=n(r,s,o,d("listItemGroup"),h("inputValue")),C=f.extend().extend({name:"v-list-item",directives:{Ripple:c},inject:{isInGroup:{default:!1},isInList:{default:!1},isInMenu:{default:!1},isInNav:{default:!1}},inheritAttrs:!1,props:{activeClass:{type:String,default(){return this.listItemGroup?this.listItemGroup.activeClass:""}},dense:Boolean,inactive:Boolean,link:Boolean,selectable:{type:Boolean},tag:{type:String,default:"div"},threeLine:Boolean,twoLine:Boolean,value:null},data:()=>({proxyClass:"v-list-item--active"}),computed:{classes(){return{"v-list-item":!0,...s.options.computed.classes.call(this),"v-list-item--dense":this.dense,"v-list-item--disabled":this.disabled,"v-list-item--link":this.isClickable&&!this.inactive,"v-list-item--selectable":this.selectable,"v-list-item--three-line":this.threeLine,"v-list-item--two-line":this.twoLine,...this.themeClasses}},isClickable(){return Boolean(s.options.computed.isClickable.call(this)||this.listItemGroup)}},created(){this.$attrs.hasOwnProperty("avatar")&&u("avatar",this)},methods:{click(t){t.detail&&this.$el.blur(),this.$emit("click",t),this.to||this.toggle()},genAttrs(){const t={"aria-disabled":this.disabled?!0:void 0,tabindex:this.isClickable&&!this.disabled?0:-1,...this.$attrs};return this.$attrs.hasOwnProperty("role")||this.isInNav||(this.isInGroup?(t.role="option",t["aria-selected"]=String(this.isActive)):this.isInMenu?(t.role=this.isClickable?"menuitem":void 0,t.id=t.id||`list-item-${this._uid}`):this.isInList&&(t.role="listitem")),t},toggle(){this.to&&this.inputValue===void 0&&(this.isActive=!this.isActive),this.$emit("change")}},render(t){let{tag:l,data:i}=this.generateRouteLink();i.attrs={...i.attrs,...this.genAttrs()},i[this.to?"nativeOn":"on"]={...i[this.to?"nativeOn":"on"],keydown:e=>{this.disabled||(e.keyCode===m.enter&&this.click(e),this.$emit("keydown",e))}},this.inactive&&(l="div"),this.inactive&&this.to&&(i.on=i.nativeOn,delete i.nativeOn);const a=this.$scopedSlots.default?this.$scopedSlots.default({active:this.isActive,toggle:this.toggle}):this.$slots.default;return t(l,this.isActive?this.setTextColor(this.color,i):i,a)}});export{C as _};
