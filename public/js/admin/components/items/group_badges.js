"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[9542,6761],{7275:(t,e,s)=>{s.r(e),s.d(e,{default:()=>c});const i={name:"Badge",mixins:[s(5535).Z]};var n=s(1900),o=s(3453),r=s.n(o),l=s(819),h=(0,n.Z)(i,(function(){var t=this,e=t.$createElement;return(t._self._c||e)("v-chip",t._b({attrs:{label:"",small:"",link:""}},"v-chip",t.value.attributes,!1),[t._v("\n    "+t._s(t.value.content.value)+"\n")])}),[],!1,null,null,null);const c=h.exports;r()(h,{VChip:l.Z})},3411:(t,e,s)=>{s.r(e),s.d(e,{default:()=>_});var i=s(7275),n=s(5535);const o={name:"GroupBadges",components:{badge:i.default},mixins:[n.Z]};var r=s(1900),l=s(3453),h=s.n(l),c=s(9524),a=s(6930),u=s(62),p=s(9989),d=s(7293),f=s(2706),v=s(5530),g=s(8131);function m(t){const e=Math.abs(t);return Math.sign(t)*(e/((1/.501-2)*(1-e)+1))}function w(t,e,s,i){const n=t.clientWidth,o=s?e.content-t.offsetLeft-n:t.offsetLeft;s&&(i=-i);const r=e.wrapper+i,l=n+o,h=.4*n;return o<=i?i=Math.max(o-h,0):r<=l&&(i=Math.min(i-(r-l-h),e.content-e.wrapper)),s?-i:i}const b=(0,v.Z)(u.y,p.Z).extend({name:"base-slide-group",directives:{Resize:d.Z,Touch:f.Z},props:{activeClass:{type:String,default:"v-slide-item--active"},centerActive:Boolean,nextIcon:{type:String,default:"$next"},prevIcon:{type:String,default:"$prev"},showArrows:{type:[Boolean,String],validator:t=>"boolean"==typeof t||["always","desktop","mobile"].includes(t)}},data:()=>({internalItemsLength:0,isOverflowing:!1,resizeTimeout:0,startX:0,isSwipingHorizontal:!1,isSwiping:!1,scrollOffset:0,widths:{content:0,wrapper:0}}),computed:{canTouch:()=>"undefined"!=typeof window,__cachedNext(){return this.genTransition("next")},__cachedPrev(){return this.genTransition("prev")},classes(){return{...u.y.options.computed.classes.call(this),"v-slide-group":!0,"v-slide-group--has-affixes":this.hasAffixes,"v-slide-group--is-overflowing":this.isOverflowing}},hasAffixes(){switch(this.showArrows){case"always":return!0;case"desktop":return!this.isMobile;case!0:return this.isOverflowing||Math.abs(this.scrollOffset)>0;case"mobile":return this.isMobile||this.isOverflowing||Math.abs(this.scrollOffset)>0;default:return!this.isMobile&&(this.isOverflowing||Math.abs(this.scrollOffset)>0)}},hasNext(){if(!this.hasAffixes)return!1;const{content:t,wrapper:e}=this.widths;return t>Math.abs(this.scrollOffset)+e},hasPrev(){return this.hasAffixes&&0!==this.scrollOffset}},watch:{internalValue:"setWidths",isOverflowing:"setWidths",scrollOffset(t){this.$vuetify.rtl&&(t=-t);let e=t<=0?m(-t):t>this.widths.content-this.widths.wrapper?-(this.widths.content-this.widths.wrapper)+m(this.widths.content-this.widths.wrapper-t):-t;this.$vuetify.rtl&&(e=-e),this.$refs.content.style.transform=`translateX(${e}px)`}},beforeUpdate(){this.internalItemsLength=(this.$children||[]).length},updated(){this.internalItemsLength!==(this.$children||[]).length&&this.setWidths()},methods:{onScroll(){this.$refs.wrapper.scrollLeft=0},onFocusin(t){if(this.isOverflowing)for(const e of(0,g.iZ)(t))for(const t of this.items)if(t.$el===e)return void(this.scrollOffset=w(t.$el,this.widths,this.$vuetify.rtl,this.scrollOffset))},genNext(){const t=this.$scopedSlots.next?this.$scopedSlots.next({}):this.$slots.next||this.__cachedNext;return this.$createElement("div",{staticClass:"v-slide-group__next",class:{"v-slide-group__next--disabled":!this.hasNext},on:{click:()=>this.onAffixClick("next")},key:"next"},[t])},genContent(){return this.$createElement("div",{staticClass:"v-slide-group__content",ref:"content",on:{focusin:this.onFocusin}},this.$slots.default)},genData(){return{class:this.classes,directives:[{name:"resize",value:this.onResize}]}},genIcon(t){let e=t;this.$vuetify.rtl&&"prev"===t?e="next":this.$vuetify.rtl&&"next"===t&&(e="prev");const s=this[`has${`${t[0].toUpperCase()}${t.slice(1)}`}`];return this.showArrows||s?this.$createElement(c.Z,{props:{disabled:!s}},this[`${e}Icon`]):null},genPrev(){const t=this.$scopedSlots.prev?this.$scopedSlots.prev({}):this.$slots.prev||this.__cachedPrev;return this.$createElement("div",{staticClass:"v-slide-group__prev",class:{"v-slide-group__prev--disabled":!this.hasPrev},on:{click:()=>this.onAffixClick("prev")},key:"prev"},[t])},genTransition(t){return this.$createElement(a.Z5,[this.genIcon(t)])},genWrapper(){return this.$createElement("div",{staticClass:"v-slide-group__wrapper",directives:[{name:"touch",value:{start:t=>this.overflowCheck(t,this.onTouchStart),move:t=>this.overflowCheck(t,this.onTouchMove),end:t=>this.overflowCheck(t,this.onTouchEnd)}}],ref:"wrapper",on:{scroll:this.onScroll}},[this.genContent()])},calculateNewOffset(t,e,s,i){const n=s?-1:1,o=n*i+("prev"===t?-1:1)*e.wrapper;return n*Math.max(Math.min(o,e.content-e.wrapper),0)},onAffixClick(t){this.$emit(`click:${t}`),this.scrollTo(t)},onResize(){this._isDestroyed||this.setWidths()},onTouchStart(t){const{content:e}=this.$refs;this.startX=this.scrollOffset+t.touchstartX,e.style.setProperty("transition","none"),e.style.setProperty("willChange","transform")},onTouchMove(t){if(this.canTouch){if(!this.isSwiping){const e=t.touchmoveX-t.touchstartX,s=t.touchmoveY-t.touchstartY;this.isSwipingHorizontal=Math.abs(e)>Math.abs(s),this.isSwiping=!0}this.isSwipingHorizontal&&(this.scrollOffset=this.startX-t.touchmoveX,document.documentElement.style.overflowY="hidden")}},onTouchEnd(){if(!this.canTouch)return;const{content:t,wrapper:e}=this.$refs,s=t.clientWidth-e.clientWidth;t.style.setProperty("transition",null),t.style.setProperty("willChange",null),this.$vuetify.rtl?this.scrollOffset>0||!this.isOverflowing?this.scrollOffset=0:this.scrollOffset<=-s&&(this.scrollOffset=-s):this.scrollOffset<0||!this.isOverflowing?this.scrollOffset=0:this.scrollOffset>=s&&(this.scrollOffset=s),this.isSwiping=!1,document.documentElement.style.removeProperty("overflow-y")},overflowCheck(t,e){t.stopPropagation(),this.isOverflowing&&e(t)},scrollIntoView(){if(!this.selectedItem&&this.items.length){const t=this.items[this.items.length-1].$el.getBoundingClientRect(),e=this.$refs.wrapper.getBoundingClientRect();(this.$vuetify.rtl&&e.right<t.right||!this.$vuetify.rtl&&e.left>t.left)&&this.scrollTo("prev")}this.selectedItem&&(0===this.selectedIndex||!this.centerActive&&!this.isOverflowing?this.scrollOffset=0:this.centerActive?this.scrollOffset=function(t,e,s){const{offsetLeft:i,clientWidth:n}=t;if(s){const t=e.content-i-n/2-e.wrapper/2;return-Math.min(e.content-e.wrapper,Math.max(0,t))}{const t=i+n/2-e.wrapper/2;return Math.min(e.content-e.wrapper,Math.max(0,t))}}(this.selectedItem.$el,this.widths,this.$vuetify.rtl):this.isOverflowing&&(this.scrollOffset=w(this.selectedItem.$el,this.widths,this.$vuetify.rtl,this.scrollOffset)))},scrollTo(t){this.scrollOffset=this.calculateNewOffset(t,{content:this.$refs.content?this.$refs.content.clientWidth:0,wrapper:this.$refs.wrapper?this.$refs.wrapper.clientWidth:0},this.$vuetify.rtl,this.scrollOffset)},setWidths(){window.requestAnimationFrame((()=>{if(this._isDestroyed)return;const{content:t,wrapper:e}=this.$refs;this.widths={content:t?t.clientWidth:0,wrapper:e?e.clientWidth:0},this.isOverflowing=this.widths.wrapper+1<this.widths.content,this.scrollIntoView()}))}},render(t){return t("div",this.genData(),[this.genPrev(),this.genWrapper(),this.genNext()])}});b.extend({name:"v-slide-group",provide(){return{slideGroup:this}}});var $=s(5836);const x=(0,v.Z)(b,$.Z).extend({name:"v-chip-group",provide(){return{chipGroup:this}},props:{column:Boolean},computed:{classes(){return{...b.options.computed.classes.call(this),"v-chip-group":!0,"v-chip-group--column":this.column}}},watch:{column(t){t&&(this.scrollOffset=0),this.$nextTick(this.onResize)}},methods:{genData(){return this.setTextColor(this.color,{...b.options.methods.genData.call(this)})}}});var y=(0,r.Z)(o,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-chip-group",{attrs:{column:""}},t._l(t.value.data.badges,(function(t,e){return s("badge",{key:e,attrs:{value:t}})})),1)}),[],!1,null,null,null);const _=y.exports;h()(y,{VChipGroup:x})},819:(t,e,s)=>{s.d(e,{Z:()=>d});var i=s(5530),n=s(6930),o=s(9524),r=s(5836),l=s(1302),h=s(2066),c=s(4552),a=s(9367),u=s(2412),p=s(8219);const d=(0,i.Z)(r.Z,u.Z,a.Z,h.Z,(0,l.d)("chipGroup"),(0,c.d)("inputValue")).extend({name:"v-chip",props:{active:{type:Boolean,default:!0},activeClass:{type:String,default(){return this.chipGroup?this.chipGroup.activeClass:""}},close:Boolean,closeIcon:{type:String,default:"$delete"},closeLabel:{type:String,default:"$vuetify.close"},disabled:Boolean,draggable:Boolean,filter:Boolean,filterIcon:{type:String,default:"$complete"},label:Boolean,link:Boolean,outlined:Boolean,pill:Boolean,tag:{type:String,default:"span"},textColor:String,value:null},data:()=>({proxyClass:"v-chip--active"}),computed:{classes(){return{"v-chip":!0,...a.Z.options.computed.classes.call(this),"v-chip--clickable":this.isClickable,"v-chip--disabled":this.disabled,"v-chip--draggable":this.draggable,"v-chip--label":this.label,"v-chip--link":this.isLink,"v-chip--no-color":!this.color,"v-chip--outlined":this.outlined,"v-chip--pill":this.pill,"v-chip--removable":this.hasClose,...this.themeClasses,...this.sizeableClasses,...this.groupClasses}},hasClose(){return Boolean(this.close)},isClickable(){return Boolean(a.Z.options.computed.isClickable.call(this)||this.chipGroup)}},created(){[["outline","outlined"],["selected","input-value"],["value","active"],["@input","@active.sync"]].forEach((([t,e])=>{this.$attrs.hasOwnProperty(t)&&(0,p.fK)(t,e,this)}))},methods:{click(t){this.$emit("click",t),this.chipGroup&&this.toggle()},genFilter(){const t=[];return this.isActive&&t.push(this.$createElement(o.Z,{staticClass:"v-chip__filter",props:{left:!0}},this.filterIcon)),this.$createElement(n.Zq,t)},genClose(){return this.$createElement(o.Z,{staticClass:"v-chip__close",props:{right:!0,size:18},attrs:{"aria-label":this.$vuetify.lang.t(this.closeLabel)},on:{click:t=>{t.stopPropagation(),t.preventDefault(),this.$emit("click:close"),this.$emit("update:active",!1)}}},this.closeIcon)},genContent(){return this.$createElement("span",{staticClass:"v-chip__content"},[this.filter&&this.genFilter(),this.$slots.default,this.hasClose&&this.genClose()])}},render(t){const e=[this.genContent()];let{tag:s,data:i}=this.generateRouteLink();i.attrs={...i.attrs,draggable:this.draggable?"true":void 0,tabindex:this.chipGroup&&!this.disabled?0:i.attrs.tabindex},i.directives.push({name:"show",value:this.active}),i=this.setBackgroundColor(this.color,i);const n=this.textColor||this.outlined&&this.color;return t(s,this.setTextColor(n,i),e)}})},7293:(t,e,s)=>{s.d(e,{Z:()=>i});const i={inserted:function(t,e,s){const i=e.value,n=e.options||{passive:!0};window.addEventListener("resize",i,n),t._onResize=Object(t._onResize),t._onResize[s.context._uid]={callback:i,options:n},e.modifiers&&e.modifiers.quiet||i()},unbind:function(t,e,s){var i;if(null==(i=t._onResize)||!i[s.context._uid])return;const{callback:n,options:o}=t._onResize[s.context._uid];window.removeEventListener("resize",n,o),delete t._onResize[s.context._uid]}}},2706:(t,e,s)=>{s.d(e,{Z:()=>r});var i=s(8131);function n(t,e){const s=t.changedTouches[0];e.touchendX=s.clientX,e.touchendY=s.clientY,e.end&&e.end(Object.assign(t,e)),(t=>{const{touchstartX:e,touchendX:s,touchstartY:i,touchendY:n}=t;t.offsetX=s-e,t.offsetY=n-i,Math.abs(t.offsetY)<.5*Math.abs(t.offsetX)&&(t.left&&s<e-16&&t.left(t),t.right&&s>e+16&&t.right(t)),Math.abs(t.offsetX)<.5*Math.abs(t.offsetY)&&(t.up&&n<i-16&&t.up(t),t.down&&n>i+16&&t.down(t))})(e)}function o(t){const e={touchstartX:0,touchstartY:0,touchendX:0,touchendY:0,touchmoveX:0,touchmoveY:0,offsetX:0,offsetY:0,left:t.left,right:t.right,up:t.up,down:t.down,start:t.start,move:t.move,end:t.end};return{touchstart:t=>function(t,e){const s=t.changedTouches[0];e.touchstartX=s.clientX,e.touchstartY=s.clientY,e.start&&e.start(Object.assign(t,e))}(t,e),touchend:t=>n(t,e),touchmove:t=>function(t,e){const s=t.changedTouches[0];e.touchmoveX=s.clientX,e.touchmoveY=s.clientY,e.move&&e.move(Object.assign(t,e))}(t,e)}}const r={inserted:function(t,e,s){const n=e.value,r=n.parent?t.parentElement:t,l=n.options||{passive:!0};if(!r)return;const h=o(e.value);r._touchHandlers=Object(r._touchHandlers),r._touchHandlers[s.context._uid]=h,(0,i.XP)(h).forEach((t=>{r.addEventListener(t,h[t],l)}))},unbind:function(t,e,s){const n=e.value.parent?t.parentElement:t;if(!n||!n._touchHandlers)return;const o=n._touchHandlers[s.context._uid];(0,i.XP)(o).forEach((t=>{n.removeEventListener(t,o[t])})),delete n._touchHandlers[s.context._uid]}}},9989:(t,e,s)=>{s.d(e,{Z:()=>n});var i=s(8219);const n=s(538).Z.extend({name:"mobile",props:{mobileBreakpoint:{type:[Number,String],default(){return this.$vuetify?this.$vuetify.breakpoint.mobileBreakpoint:void 0},validator:t=>!isNaN(Number(t))||["xs","sm","md","lg","xl"].includes(String(t))}},computed:{isMobile(){const{mobile:t,width:e,name:s,mobileBreakpoint:i}=this.$vuetify.breakpoint;if(i===this.mobileBreakpoint)return t;const n=parseInt(this.mobileBreakpoint,10);return!isNaN(n)?e<n:s===this.mobileBreakpoint}},created(){this.$attrs.hasOwnProperty("mobile-break-point")&&(0,i.Rn)("mobile-break-point","mobile-breakpoint",this)}})}}]);