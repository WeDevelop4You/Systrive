import{T as s,m as i}from"./e49d6570.js";const a=s.extend({name:"v-divider",props:{inset:Boolean,vertical:Boolean},render(e){let t;return(!this.$attrs.role||this.$attrs.role==="separator")&&(t=this.vertical?"vertical":"horizontal"),e("hr",{class:{"v-divider":!0,"v-divider--inset":this.inset,"v-divider--vertical":this.vertical,...this.themeClasses},attrs:{role:"separator","aria-orientation":t,...this.$attrs},on:this.$listeners})}});const n=i(s).extend({name:"v-subheader",props:{inset:Boolean},render(e){return e("div",{staticClass:"v-subheader",class:{"v-subheader--inset":this.inset,...this.themeClasses},attrs:this.$attrs,on:this.$listeners},this.$slots.default)}});export{n as _,a};
