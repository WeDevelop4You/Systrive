import{V as u,c as $,a as n,b as A,g as p,m as T}from"./89ae458c.js";import{S as d,O as w,P as x,a as O,_ as M,b as B,c as C}from"./efdb8700.js";import{n as m}from"./75131b1e.js";import{R}from"./94ca7cec.js";import{m as c,_ as v,T as f,C as k,a as V}from"./20f47019.js";import{N as H}from"./eb7e653c.js";import{_ as o,a as E,b as P}from"./14ee71cd.js";import{f as L}from"./53ee5cfb.js";import{D as N}from"./05a5b6b8.js";import{M as g}from"./00245e15.js";import{C as U,_ as W}from"./27561507.js";import{R as z}from"./64b64aa2.js";import{T as D}from"./1cb7ba60.js";import{T as I}from"./492a710f.js";import{_ as j}from"./0f69cb55.js";import{_ as X}from"./64eb8a9e.js";import"./e2324ecf.js";import"./e2c5929a.js";import"./5661cf77.js";import"./c8ee0776.js";import"./456dbe17.js";import"./12b2fd9b.js";import"./8e99813f.js";import"./dd294eca.js";import"./b7f1edae.js";import"./3bfe2d76.js";import"./30ff1d0a.js";import"./9f62fef9.js";import"./f57264bf.js";function F(t,e,i){const{self:s=!1}=e.modifiers||{},r=e.value,a=typeof r=="object"&&r.options||{passive:!0},l=typeof r=="function"||"handleEvent"in r?r:r.handler,h=s?t:e.arg?document.querySelector(e.arg):window;!h||(h.addEventListener("scroll",l,a),t._onScroll=Object(t._onScroll),t._onScroll[i.context._uid]={handler:l,options:a,target:s?void 0:h})}function q(t,e,i){var s;if(!((s=t._onScroll)!=null&&s[i.context._uid]))return;const{handler:r,options:a,target:l=t}=t._onScroll[i.context._uid];l.removeEventListener("scroll",r,a),delete t._onScroll[i.context._uid]}const _={inserted:F,unbind:q},Y=_;function b(t,e=[]){return c(L(["absolute","fixed"])).extend({name:"applicationable",props:{app:Boolean},computed:{applicationProperty(){return t}},watch:{app(i,s){s?this.removeApplication(!0):this.callUpdate()},applicationProperty(i,s){this.$vuetify.application.unregister(this._uid,s)}},activated(){this.callUpdate()},created(){for(let i=0,s=e.length;i<s;i++)this.$watch(e[i],this.callUpdate);this.callUpdate()},mounted(){this.callUpdate()},deactivated(){this.removeApplication()},destroyed(){this.removeApplication()},methods:{callUpdate(){!this.app||this.$vuetify.application.register(this._uid,this.applicationProperty,this.updateApplication())},removeApplication(i=!1){!i&&!this.app||this.$vuetify.application.unregister(this._uid,this.applicationProperty)},updateApplication:()=>0}})}const S=u.extend({name:"scrollable",directives:{Scroll:_},props:{scrollTarget:String,scrollThreshold:[String,Number]},data:()=>({currentScroll:0,currentThreshold:0,isActive:!1,isScrollingUp:!1,previousScroll:0,savedScroll:0,target:null}),computed:{canScroll(){return typeof window<"u"},computedScrollThreshold(){return this.scrollThreshold?Number(this.scrollThreshold):300}},watch:{isScrollingUp(){this.savedScroll=this.savedScroll||this.currentScroll},isActive(){this.savedScroll=0}},mounted(){this.scrollTarget&&(this.target=document.querySelector(this.scrollTarget),this.target||$(`Unable to locate element with identifier ${this.scrollTarget}`,this))},methods:{onScroll(){!this.canScroll||(this.previousScroll=this.currentScroll,this.currentScroll=this.target?this.target.scrollTop:window.pageYOffset,this.isScrollingUp=this.currentScroll<this.previousScroll,this.currentThreshold=Math.abs(this.currentScroll-this.computedScrollThreshold),this.$nextTick(()=>{Math.abs(this.currentScroll-this.savedScroll)>this.computedScrollThreshold&&this.thresholdMet()}))},thresholdMet(){}}}),G=c(o,S,d,I,b("top",["clippedLeft","clippedRight","computedHeight","invertedScroll","isExtended","isProminent","value"])),Z=G.extend({name:"v-app-bar",directives:{Scroll:Y},provide(){return{VAppBar:this}},props:{clippedLeft:Boolean,clippedRight:Boolean,collapseOnScroll:Boolean,elevateOnScroll:Boolean,fadeImgOnScroll:Boolean,hideOnScroll:Boolean,invertedScroll:Boolean,scrollOffScreen:Boolean,shrinkOnScroll:Boolean,value:{type:Boolean,default:!0}},data(){return{isActive:this.value}},computed:{applicationProperty(){return this.bottom?"bottom":"top"},canScroll(){return S.options.computed.canScroll.call(this)&&(this.invertedScroll||this.elevateOnScroll||this.hideOnScroll||this.collapseOnScroll||this.isBooted||!this.value)},classes(){return{...o.options.computed.classes.call(this),"v-toolbar--collapse":this.collapse||this.collapseOnScroll,"v-app-bar":!0,"v-app-bar--clipped":this.clippedLeft||this.clippedRight,"v-app-bar--fade-img-on-scroll":this.fadeImgOnScroll,"v-app-bar--elevate-on-scroll":this.elevateOnScroll,"v-app-bar--fixed":!this.absolute&&(this.app||this.fixed),"v-app-bar--hide-shadow":this.hideShadow,"v-app-bar--is-scrolled":this.currentScroll>0,"v-app-bar--shrink-on-scroll":this.shrinkOnScroll}},scrollRatio(){const t=this.computedScrollThreshold;return Math.max((t-this.currentScroll)/t,0)},computedContentHeight(){if(!this.shrinkOnScroll)return o.options.computed.computedContentHeight.call(this);const t=this.dense?48:56,e=this.computedOriginalHeight;return t+(e-t)*this.scrollRatio},computedFontSize(){if(!this.isProminent)return;const t=1.25;return t+(1.5-t)*this.scrollRatio},computedLeft(){return!this.app||this.clippedLeft?0:this.$vuetify.application.left},computedMarginTop(){return this.app?this.$vuetify.application.bar:0},computedOpacity(){if(!!this.fadeImgOnScroll)return this.scrollRatio},computedOriginalHeight(){let t=o.options.computed.computedContentHeight.call(this);return this.isExtended&&(t+=parseInt(this.extensionHeight)),t},computedRight(){return!this.app||this.clippedRight?0:this.$vuetify.application.right},computedScrollThreshold(){return this.scrollThreshold?Number(this.scrollThreshold):this.computedOriginalHeight-(this.dense?48:56)},computedTransform(){if(!this.canScroll||this.elevateOnScroll&&this.currentScroll===0&&this.isActive||this.isActive)return 0;const t=this.scrollOffScreen?this.computedHeight:this.computedContentHeight;return this.bottom?t:-t},hideShadow(){return this.elevateOnScroll&&this.isExtended?this.currentScroll<this.computedScrollThreshold:this.elevateOnScroll?this.currentScroll===0||this.computedTransform<0:(!this.isExtended||this.scrollOffScreen)&&this.computedTransform!==0},isCollapsed(){return this.collapseOnScroll?this.currentScroll>0:o.options.computed.isCollapsed.call(this)},isProminent(){return o.options.computed.isProminent.call(this)||this.shrinkOnScroll},styles(){return{...o.options.computed.styles.call(this),fontSize:n(this.computedFontSize,"rem"),marginTop:n(this.computedMarginTop),transform:`translateY(${n(this.computedTransform)})`,left:n(this.computedLeft),right:n(this.computedRight)}}},watch:{canScroll:"onScroll",computedTransform(){!this.canScroll||!this.clippedLeft&&!this.clippedRight||this.callUpdate()},invertedScroll(t){this.isActive=!t||this.currentScroll!==0},hideOnScroll(t){this.isActive=!t||this.currentScroll<this.computedScrollThreshold}},created(){this.invertedScroll&&(this.isActive=!1)},methods:{genBackground(){const t=o.options.methods.genBackground.call(this);return t.data=this._b(t.data||{},t.tag,{style:{opacity:this.computedOpacity}}),t},updateApplication(){return this.invertedScroll?0:this.computedHeight+this.computedTransform},thresholdMet(){if(this.invertedScroll){this.isActive=this.currentScroll>this.computedScrollThreshold;return}this.hideOnScroll&&(this.isActive=this.isScrollingUp||this.currentScroll<this.computedScrollThreshold),!(this.currentThreshold<this.computedScrollThreshold)&&(this.savedScroll=this.currentScroll)}},render(t){const e=o.options.render.call(this,t);return e.data=e.data||{},this.canScroll&&(e.data.directives=e.data.directives||[],e.data.directives.push({arg:this.scrollTarget,name:"scroll",value:this.onScroll})),e}}),J=u.extend({name:"v-app-bar-nav-icon",functional:!0,render(t,{slots:e,listeners:i,props:s,data:r}){const a=Object.assign(r,{staticClass:`v-app-bar__nav-icon ${r.staticClass||""}`.trim(),props:{...s,icon:!0},on:i}),l=e().default;return t(j,a,l||[t(v,"$menu")])}});const y=c(R).extend({name:"v-breadcrumbs-item",props:{activeClass:{type:String,default:"v-breadcrumbs__item--disabled"},ripple:{type:[Boolean,Object],default:!1}},computed:{classes(){return{"v-breadcrumbs__item":!0,[this.activeClass]:this.disabled}}},render(t){const{tag:e,data:i}=this.generateRouteLink();return t("li",[t(e,{...i,attrs:{...i.attrs,"aria-current":this.isActive&&this.isLink?"page":void 0}},this.$slots.default)])}}),K=A("v-breadcrumbs__divider","li"),Q=c(f).extend({name:"v-breadcrumbs",props:{divider:{type:String,default:"/"},items:{type:Array,default:()=>[]},large:Boolean},computed:{classes(){return{"v-breadcrumbs--large":this.large,...this.themeClasses}}},methods:{genDivider(){return this.$createElement(K,this.$slots.divider?this.$slots.divider:this.divider)},genItems(){const t=[],e=!!this.$scopedSlots.item,i=[];for(let s=0;s<this.items.length;s++){const r=this.items[s];i.push(r.text),e?t.push(this.$scopedSlots.item({item:r})):t.push(this.$createElement(y,{key:i.join("."),props:r},[r.text])),s<this.items.length-1&&t.push(this.genDivider())}return t}},render(t){const e=this.$slots.default||this.genItems();return t("ul",{staticClass:"v-breadcrumbs",class:this.classes},e)}});const tt=c(b("left",["isActive","isMobile","miniVariant","expandOnHover","permanent","right","temporary","width"]),k,N,g,w,d,f),et=tt.extend({name:"v-navigation-drawer",directives:{ClickOutside:U,Resize:z,Touch:D},provide(){return{isInNav:this.tag==="nav"}},props:{bottom:Boolean,clipped:Boolean,disableResizeWatcher:Boolean,disableRouteWatcher:Boolean,expandOnHover:Boolean,floating:Boolean,height:{type:[Number,String],default(){return this.app?"100vh":"100%"}},miniVariant:Boolean,miniVariantWidth:{type:[Number,String],default:56},permanent:Boolean,right:Boolean,src:{type:[String,Object],default:""},stateless:Boolean,tag:{type:String,default(){return this.app?"nav":"aside"}},temporary:Boolean,touchless:Boolean,width:{type:[Number,String],default:256},value:null},data:()=>({isMouseover:!1,touchArea:{left:0,right:0},stackMinZIndex:6}),computed:{applicationProperty(){return this.right?"right":"left"},classes(){return{"v-navigation-drawer":!0,"v-navigation-drawer--absolute":this.absolute,"v-navigation-drawer--bottom":this.bottom,"v-navigation-drawer--clipped":this.clipped,"v-navigation-drawer--close":!this.isActive,"v-navigation-drawer--fixed":!this.absolute&&(this.app||this.fixed),"v-navigation-drawer--floating":this.floating,"v-navigation-drawer--is-mobile":this.isMobile,"v-navigation-drawer--is-mouseover":this.isMouseover,"v-navigation-drawer--mini-variant":this.isMiniVariant,"v-navigation-drawer--custom-mini-variant":Number(this.miniVariantWidth)!==56,"v-navigation-drawer--open":this.isActive,"v-navigation-drawer--open-on-hover":this.expandOnHover,"v-navigation-drawer--right":this.right,"v-navigation-drawer--temporary":this.temporary,...this.themeClasses}},computedMaxHeight(){if(!this.hasApp)return null;const t=this.$vuetify.application.bottom+this.$vuetify.application.footer+this.$vuetify.application.bar;return this.clipped?t+this.$vuetify.application.top:t},computedTop(){if(!this.hasApp)return 0;let t=this.$vuetify.application.bar;return t+=this.clipped?this.$vuetify.application.top:0,t},computedTransform(){return this.isActive?0:this.isBottom||this.right?100:-100},computedWidth(){return this.isMiniVariant?this.miniVariantWidth:this.width},hasApp(){return this.app&&!this.isMobile&&!this.temporary},isBottom(){return this.bottom&&this.isMobile},isMiniVariant(){return!this.expandOnHover&&this.miniVariant||this.expandOnHover&&!this.isMouseover},isMobile(){return!this.stateless&&!this.permanent&&g.options.computed.isMobile.call(this)},reactsToClick(){return!this.stateless&&!this.permanent&&(this.isMobile||this.temporary)},reactsToMobile(){return this.app&&!this.disableResizeWatcher&&!this.permanent&&!this.stateless&&!this.temporary},reactsToResize(){return!this.disableResizeWatcher&&!this.stateless},reactsToRoute(){return!this.disableRouteWatcher&&!this.stateless&&(this.temporary||this.isMobile)},showOverlay(){return!this.hideOverlay&&this.isActive&&(this.isMobile||this.temporary)},styles(){const t=this.isBottom?"translateY":"translateX";return{height:n(this.height),top:this.isBottom?"auto":n(this.computedTop),maxHeight:this.computedMaxHeight!=null?`calc(100% - ${n(this.computedMaxHeight)})`:void 0,transform:`${t}(${n(this.computedTransform,"%")})`,width:n(this.computedWidth)}}},watch:{$route:"onRouteChange",isActive(t){this.$emit("input",t)},isMobile(t,e){!t&&this.isActive&&!this.temporary&&this.removeOverlay(),!(e==null||!this.reactsToResize||!this.reactsToMobile)&&(this.isActive=!t)},permanent(t){t&&(this.isActive=!0)},showOverlay(t){t?this.genOverlay():this.removeOverlay()},value(t){if(!this.permanent){if(t==null){this.init();return}t!==this.isActive&&(this.isActive=t)}},expandOnHover:"updateMiniVariant",isMouseover(t){this.updateMiniVariant(!t)}},beforeMount(){this.init()},methods:{calculateTouchArea(){const t=this.$el.parentNode;if(!t)return;const e=t.getBoundingClientRect();this.touchArea={left:e.left+50,right:e.right-50}},closeConditional(){return this.isActive&&!this._isDestroyed&&this.reactsToClick},genAppend(){return this.genPosition("append")},genBackground(){const t={height:"100%",width:"100%",src:this.src},e=this.$scopedSlots.img?this.$scopedSlots.img(t):this.$createElement(E,{props:t});return this.$createElement("div",{staticClass:"v-navigation-drawer__image"},[e])},genDirectives(){const t=[{name:"click-outside",value:{handler:()=>{this.isActive=!1},closeConditional:this.closeConditional,include:this.getOpenDependentElements}}];return!this.touchless&&!this.stateless&&t.push({name:"touch",value:{parent:!0,left:this.swipeLeft,right:this.swipeRight}}),t},genListeners(){const t={mouseenter:()=>this.isMouseover=!0,mouseleave:()=>this.isMouseover=!1,transitionend:e=>{if(e.target!==e.currentTarget)return;this.$emit("transitionend",e);const i=document.createEvent("UIEvents");i.initUIEvent("resize",!0,!1,window,0),window.dispatchEvent(i)}};return this.miniVariant&&(t.click=()=>this.$emit("update:mini-variant",!1)),t},genPosition(t){const e=p(this,t);return e&&this.$createElement("div",{staticClass:`v-navigation-drawer__${t}`},e)},genPrepend(){return this.genPosition("prepend")},genContent(){return this.$createElement("div",{staticClass:"v-navigation-drawer__content"},this.$slots.default)},genBorder(){return this.$createElement("div",{staticClass:"v-navigation-drawer__border"})},init(){this.permanent?this.isActive=!0:this.stateless||this.value!=null?this.isActive=this.value:this.temporary||(this.isActive=!this.isMobile)},onRouteChange(){this.reactsToRoute&&this.closeConditional()&&(this.isActive=!1)},swipeLeft(t){this.isActive&&this.right||(this.calculateTouchArea(),!(Math.abs(t.touchendX-t.touchstartX)<100)&&(this.right&&t.touchstartX>=this.touchArea.right?this.isActive=!0:!this.right&&this.isActive&&(this.isActive=!1)))},swipeRight(t){this.isActive&&!this.right||(this.calculateTouchArea(),!(Math.abs(t.touchendX-t.touchstartX)<100)&&(!this.right&&t.touchstartX<=this.touchArea.left?this.isActive=!0:this.right&&this.isActive&&(this.isActive=!1)))},updateApplication(){if(!this.isActive||this.isMobile||this.temporary||!this.$el)return 0;const t=Number(this.miniVariant?this.miniVariantWidth:this.width);return isNaN(t)?this.$el.clientWidth:t},updateMiniVariant(t){this.expandOnHover&&this.miniVariant!==t&&this.$emit("update:mini-variant",t)}},render(t){const e=[this.genPrepend(),this.genContent(),this.genAppend(),this.genBorder()];return(this.src||p(this,"img"))&&e.unshift(this.genBackground()),t(this.tag,this.setBackgroundColor(this.color,{class:this.classes,style:this.styles,directives:this.genDirectives(),on:this.genListeners()}),e)}}),it={name:"Breadcrumb",data(){return{breadcrumbs:[]}},watch:{"$route.meta.breadcrumbs":{handler(t){typeof t=="function"?this.breadcrumbs=t.call(this,this.$route):this.breadcrumbs=t},deep:!0,immediate:!0}}};var st=function(){var e=this,i=e._self._c;return i(Q,{attrs:{items:e.breadcrumbs},scopedSlots:e._u([{key:"item",fn:function({item:s}){return[i(y,{staticClass:"text-subtitle-2 crumb-item",attrs:{to:s.to,disabled:s.disabled,exact:""}},[e._v(" "+e._s(s.text)+" ")])]}}])})},rt=[],nt=m(it,st,rt,!1,null,null,null,null);const ot=nt.exports,at={name:"App",components:{Popup:x,Navbar:H,Breadcrumb:ot,SvgLogoLine:O},props:{response:{required:!0,type:Array}},data(){return{isMini:!0}},computed:{...T({sub:"navigation/sub",main:"navigation/main"})},created(){this.response.forEach(t=>{this.$responseChain(t)}),this.$store.dispatch("navigation/sub")}};var lt=function(){var e=this,i=e._self._c;return i(M,[i(et,{attrs:{app:"",permanent:"",clipped:"","hide-overlay":"","mini-variant":e.isMini},on:{"update:miniVariant":function(s){e.isMini=s},"update:mini-variant":function(s){e.isMini=s}}},[Object.keys(e.main).length!==0?i("Navbar",{attrs:{value:e.main,"is-hidden":e.isMini}}):e._e()],1),i(Z,{attrs:{app:"",dense:"","clipped-left":""}},[i(V,{staticClass:"gap-3 pr-3",attrs:{"no-gutters":""}},[i(J,{staticClass:"mx-1",on:{click:function(s){e.isMini=!e.isMini}}}),i("router-link",{staticClass:"line-height-0 align-self-center",attrs:{to:{name:"dashboard"}}},[i("svg-logo-line",{staticClass:"py-2",style:{height:e.$vuetify.application.top+"px"}})],1),i(P),i("div",{staticClass:"align-self-center cursor-pointer"},[i(W,{attrs:{"nudge-left":18,"close-on-content-click":!1,transition:"slide-y-transition","offset-y":"",bottom:""},scopedSlots:e._u([{key:"activator",fn:function({on:s}){return[i("div",e._g({staticClass:"py-3"},s),[i("span",{domProps:{textContent:e._s(e.$auth.user().email)}}),i(v,{staticClass:"ml-2",attrs:{dense:""}},[e._v(" fas fa-angle-down ")])],1)]}}])},[Object.keys(e.sub).length!==0?i("navbar",{attrs:{value:e.sub}}):e._e()],1)],1)],1),i(X,{attrs:{absolute:"",bottom:"",indeterminate:"",active:e.$loading,color:"primary"}})],1),i(B,[i(C,{attrs:{fluid:""}},[i("breadcrumb"),i("div",{staticClass:"px-6"},[i("router-view",{key:e.$route.name})],1)],1),i("popup")],1)],1)},ct=[],ht=m(at,lt,ct,!1,null,null,null,null);const Wt=ht.exports;export{Wt as default};