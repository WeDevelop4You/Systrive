import{c}from"./627c4e78.js";import{v as m}from"./feafbc55.js";function u(o=[],...s){return Array().concat(o,...s)}function p(o,s="top center 0",e){return{name:o,functional:!0,props:{group:{type:Boolean,default:!1},hideOnLeave:{type:Boolean,default:!1},leaveAbsolute:{type:Boolean,default:!1},mode:{type:String,default:e},origin:{type:String,default:s}},render(r,n){const a=`transition${n.props.group?"-group":""}`,t={props:{name:o,mode:n.props.mode},on:{beforeEnter(i){i.style.transformOrigin=n.props.origin,i.style.webkitTransformOrigin=n.props.origin}}};return n.props.leaveAbsolute&&(t.on.leave=u(t.on.leave,i=>{const{offsetTop:f,offsetLeft:l,offsetWidth:y,offsetHeight:d}=i;i._transitionInitialStyles={position:i.style.position,top:i.style.top,left:i.style.left,width:i.style.width,height:i.style.height},i.style.position="absolute",i.style.top=f+"px",i.style.left=l+"px",i.style.width=y+"px",i.style.height=d+"px"}),t.on.afterLeave=u(t.on.afterLeave,i=>{if(i&&i._transitionInitialStyles){const{position:f,top:l,left:y,width:d,height:g}=i._transitionInitialStyles;delete i._transitionInitialStyles,i.style.position=f||"",i.style.top=l||"",i.style.left=y||"",i.style.width=d||"",i.style.height=g||""}})),n.props.hideOnLeave&&(t.on.leave=u(t.on.leave,i=>{i.style.setProperty("display","none","important")})),r(a,c(n.data,t),n.children)}}}function h(o,s,e="in-out"){return{name:o,functional:!0,props:{mode:{type:String,default:e}},render(r,n){return r("transition",c(n.data,{props:{name:o},on:s}),n.children)}}}function v(o="",s=!1){const e=s?"width":"height",r=`offset${m(e)}`;return{beforeEnter(t){t._parent=t.parentNode,t._initialStyle={transition:t.style.transition,overflow:t.style.overflow,[e]:t.style[e]}},enter(t){const i=t._initialStyle;t.style.setProperty("transition","none","important"),t.style.overflow="hidden";const f=`${t[r]}px`;t.style[e]="0",t.offsetHeight,t.style.transition=i.transition,o&&t._parent&&t._parent.classList.add(o),requestAnimationFrame(()=>{t.style[e]=f})},afterEnter:a,enterCancelled:a,leave(t){t._initialStyle={transition:"",overflow:t.style.overflow,[e]:t.style[e]},t.style.overflow="hidden",t.style[e]=`${t[r]}px`,t.offsetHeight,requestAnimationFrame(()=>t.style[e]="0")},afterLeave:n,leaveCancelled:n};function n(t){o&&t._parent&&t._parent.classList.remove(o),a(t)}function a(t){const i=t._initialStyle[e];t.style.overflow=t._initialStyle.overflow,i!=null&&(t.style[e]=i),delete t._initialStyle}}const T=p("tab-transition"),_=p("tab-reverse-transition"),b=p("fab-transition","center center","out-in"),L=p("fade-transition"),V=p("slide-x-transition"),E=h("expand-transition",v()),A=h("expand-x-transition",v("",!0));export{E as V,L as a,V as b,_ as c,T as d,b as e,A as f};
