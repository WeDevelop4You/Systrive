import{m as a,C as r,c as h}from"./8ba31e84.js";import{n as l}from"./75131b1e.js";import{M as c,D as u,A as p}from"./80e71617.js";import{D as d}from"./a3716e35.js";import{a as n,s as f,j as m,k as v}from"./30fae2fd.js";const g=a(r,d,u,c).extend({name:"v-tooltip",props:{closeDelay:{type:[Number,String],default:0},disabled:Boolean,openDelay:{type:[Number,String],default:0},openOnHover:{type:Boolean,default:!0},openOnFocus:{type:Boolean,default:!0},tag:{type:String,default:"span"},transition:String},data:()=>({calculatedMinWidth:0,closeDependents:!1}),computed:{calculatedLeft(){const{activator:e,content:t}=this.dimensions,s=!this.bottom&&!this.left&&!this.top&&!this.right,i=this.attach!==!1?e.offsetLeft:e.left;let o=0;return this.top||this.bottom||s?o=i+e.width/2-t.width/2:(this.left||this.right)&&(o=i+(this.right?e.width:-t.width)+(this.right?10:-10)),this.nudgeLeft&&(o-=parseInt(this.nudgeLeft)),this.nudgeRight&&(o+=parseInt(this.nudgeRight)),`${this.calcXOverflow(o,this.dimensions.content.width)}px`},calculatedTop(){const{activator:e,content:t}=this.dimensions,s=this.attach!==!1?e.offsetTop:e.top;let i=0;return this.top||this.bottom?i=s+(this.bottom?e.height:-t.height)+(this.bottom?10:-10):(this.left||this.right)&&(i=s+e.height/2-t.height/2),this.nudgeTop&&(i-=parseInt(this.nudgeTop)),this.nudgeBottom&&(i+=parseInt(this.nudgeBottom)),this.attach===!1&&(i+=this.pageYOffset),`${this.calcYOverflow(i)}px`},classes(){return{"v-tooltip--top":this.top,"v-tooltip--right":this.right,"v-tooltip--bottom":this.bottom,"v-tooltip--left":this.left,"v-tooltip--attached":this.attach===""||this.attach===!0||this.attach==="attach"}},computedTransition(){return this.transition?this.transition:this.isActive?"scale-transition":"fade-transition"},offsetY(){return this.top||this.bottom},offsetX(){return this.left||this.right},styles(){return{left:this.calculatedLeft,maxWidth:n(this.maxWidth),minWidth:n(this.minWidth),top:this.calculatedTop,zIndex:this.zIndex||this.activeZIndex}}},beforeMount(){this.$nextTick(()=>{this.value&&this.callActivate()})},mounted(){f(this,"activator",!0)==="v-slot"&&m(`v-tooltip's activator slot must be bound, try '<template #activator="data"><v-btn v-on="data.on>'`,this)},methods:{activate(){this.updateDimensions(),requestAnimationFrame(this.startTransition)},deactivate(){this.runDelay("close")},genActivatorListeners(){const e=p.options.methods.genActivatorListeners.call(this);return this.openOnFocus&&(e.focus=t=>{this.getActivator(t),this.runDelay("open")},e.blur=t=>{this.getActivator(t),this.runDelay("close")}),e.keydown=t=>{t.keyCode===v.esc&&(this.getActivator(t),this.runDelay("close"))},e},genActivatorAttributes(){return{"aria-haspopup":!0,"aria-expanded":String(this.isActive)}},genTransition(){const e=this.genContent();return this.computedTransition?this.$createElement("transition",{props:{name:this.computedTransition}},[e]):e},genContent(){return this.$createElement("div",this.setBackgroundColor(this.color,{staticClass:"v-tooltip__content",class:{[this.contentClass]:!0,menuable__content__active:this.isActive,"v-tooltip__content--fixed":this.activatorFixed},style:this.styles,attrs:this.getScopeIdAttrs(),directives:[{name:"show",value:this.isContentActive}],ref:"content"}),this.getContentSlot())}},render(e){return e(this.tag,{staticClass:"v-tooltip",class:this.classes},[this.showLazyContent(()=>[this.genTransition()]),this.genActivator()])}}),_={name:"Tooltip",mixins:[h]};var b=function(){var t=this,s=t._self._c;return s(g,t._b({attrs:{disabled:!t.value.content.text},scopedSlots:t._u([{key:"activator",fn:function({on:i}){return[t._t("default",null,{tooltip:i})]}}],null,!0)},"v-tooltip",t.value.attributes,!1),[t._v(" "+t._s(t.value.content.text)+" ")])},y=[],T=l(_,b,y,!1,null,null,null,null);const L=T.exports;export{L as T};
