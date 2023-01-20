import n from"./a2f9d391.js";import{C as r}from"./35f22181.js";import{q as s,C as a}from"./5ecbb865.js";import{n as c}from"./75131b1e.js";import{_ as l}from"./6738fc27.js";import{V as p,a as h}from"./8c509b8f.js";import{S as m}from"./fa8fc16c.js";import{V as u}from"./76252812.js";import{T as d}from"./2d98f16d.js";import{e as f}from"./10723b79.js";import{e as _}from"./e0db1d00.js";import{_ as g}from"./f5ffbe96.js";import{_ as v}from"./86f5b0e9.js";import"./00924962.js";import"./caa09a2a.js";import"./16a5c7a5.js";import"./165252c7.js";import"./62678420.js";import"./a097d4c0.js";import"./a03227d5.js";import"./0e939e68.js";import"./ed6ab0a1.js";import"./89ff418b.js";import"./f72d6ec9.js";import"./4d23891e.js";import"./14c8fee9.js";import"./64dbd66a.js";import"./23e0ddc0.js";import"./bcdbeb71.js";import"./e4160f91.js";import"./4138e54f.js";import"./b17e7ff8.js";import"./be706740.js";const C=m.extend({name:"v-switch",directives:{Touch:d},props:{inset:Boolean,loading:{type:[Boolean,String],default:!1},flat:{type:Boolean,default:!1}},computed:{classes(){return{...u.options.computed.classes.call(this),"v-input--selection-controls v-input--switch":!0,"v-input--switch--flat":this.flat,"v-input--switch--inset":this.inset}},attrs(){return{"aria-checked":String(this.isActive),"aria-disabled":String(this.isDisabled),role:"switch"}},validationState(){if(this.hasError&&this.shouldValidate)return"error";if(this.hasSuccess)return"success";if(this.hasColor!==null)return this.computedColor},switchData(){return this.setTextColor(this.loading?void 0:this.validationState,{class:this.themeClasses})}},methods:{genDefaultSlot(){return[this.genSwitch(),this.genLabel()]},genSwitch(){const{title:i,...t}=this.attrs$;return this.$createElement("div",{staticClass:"v-input--selection-controls__input"},[this.genInput("checkbox",{...this.attrs,...t}),this.genRipple(this.setTextColor(this.validationState,{directives:[{name:"touch",value:{left:this.onSwipeLeft,right:this.onSwipeRight}}]})),this.$createElement("div",{staticClass:"v-input--switch__track",...this.switchData}),this.$createElement("div",{staticClass:"v-input--switch__thumb",...this.switchData},[this.genProgress()])])},genProgress(){return this.$createElement(f,{},[this.loading===!1?null:this.$slots.progress||this.$createElement(_,{props:{color:this.loading===!0||this.loading===""?this.color||"primary":this.loading,size:16,width:2,indeterminate:!0}})])},onSwipeLeft(){this.isActive&&this.onChange()},onSwipeRight(){this.isActive||this.onChange()},onKeydown(i){(i.keyCode===s.left&&this.isActive||i.keyCode===s.right&&!this.isActive)&&this.onChange()}}});const w={name:"DarkModeSwitchList",components:{Icon:n},extends:r,props:{isHidden:{type:Boolean,default:!1}},computed:{data:{get(){return this.$auth.preference("dark_mode")},set(i){this.$auth.changePreference("dark_mode",i)}},icon(){return new a({content:{type:this.$vuetify.theme.dark?"fas fa-moon":"fas fa-sun"}})},iconColor(){return this.$vuetify.theme.dark?"#FFFFFF":"rgba(0, 0, 0, 0.54)"}}};var S=function(){var t=this,e=t._self._c;return e(g,{staticClass:"cursor-default text--primary",attrs:{dense:"",color:"secondary",inactive:""}},[e(v,{staticClass:"justify-center mx-auto",staticStyle:{"min-width":"40px"}},[e("icon",{style:{color:t.iconColor},attrs:{value:t.icon}})],1),e(p,{staticStyle:{"padding-bottom":"4px"}},[e(h,{domProps:{textContent:t._s(t.component.content.title)}})],1),e(l,{staticClass:"mb-1 mt-2"},[e(C,{staticClass:"mt-0 pt-0",attrs:{"hide-details":"",dense:""},model:{value:t.data,callback:function(o){t.data=o},expression:"data"}})],1)],1)},y=[],k=c(w,S,y,!1,null,"3fe20a9f",null,null);const st=k.exports;export{st as default};
