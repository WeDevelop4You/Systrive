"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[5022],{2008:(t,e,s)=>{s.r(e),s.d(e,{default:()=>g});var i=s(7024),a=s(2504),n=s(952),r=s(8008),l=s(6925),o=s(7894),h=s(8444),d=s(1373),u=s(4894);const c={name:"SkeletonText"};var p=s(1900);const v=(0,p.Z)(c,(function(){return(0,this._self._c)(u.Z,{staticClass:"skeleton-round mt-1",attrs:{type:"text"}})}),[],!1,null,null,null).exports,m={name:"List",components:{URL:function(){return{component:s.e(3647).then(s.bind(s,1559)),loading:v,delay:0}},Badge:function(){return Promise.all([s.e(5317),s.e(6761)]).then(s.bind(s,4321))},UpTimer:function(){return s.e(2269).then(s.bind(s,9590))},GroupBadges:function(){return Promise.all([s.e(5317),s.e(9542)]).then(s.bind(s,4059))}},mixins:[d.Z]};const g=(0,p.Z)(m,(function(){var t=this,e=t._self._c;return e(n.Z,{staticClass:"dialog-divide-color pt-0",attrs:{dense:"",color:"transparent"}},[t._l(t.value.data.list,(function(s,n){return[s.divider?[e(a.Z,{key:n,staticClass:"my-1"})]:s.subheader?[e(h.Z,{key:n,staticClass:"subtitle-1",class:[t.value.data.hasSubheader?"pl-4":""],staticStyle:{height:"25px"},domProps:{textContent:t._s(s.subheader)}})]:[e(o.Z,{key:n,attrs:{"no-gutters":""}},t._l(s.items,(function(a){return e(i.Z,{key:a.identifier,attrs:{md:s.columns,cols:"12"}},[e(r.Z,{class:[t.value.data.hasSubheader?"pl-6":""],attrs:{dense:""}},[e(l.km,[e(l.V9,{domProps:{textContent:t._s(a.content.label)}}),t._v(" "),"Content"!==a.componentName?[e(a.componentName,{tag:"component",class:{"mt-1 max-w-min-content":"Badge"===a.componentName},attrs:{value:a}})]:[e(l.oZ,{domProps:{textContent:t._s(a.content.value||t.$vuetify.lang.t("$vuetify.word.no_content"))}})]],2)],1)],1)})),1)]]}))],2)}),[],!1,null,null,null).exports},2504:(t,e,s)=>{s.d(e,{Z:()=>i});const i=s(2066).Z.extend({name:"v-divider",props:{inset:Boolean,vertical:Boolean},render(t){let e;return this.$attrs.role&&"separator"!==this.$attrs.role||(e=this.vertical?"vertical":"horizontal"),t("hr",{class:{"v-divider":!0,"v-divider--inset":this.inset,"v-divider--vertical":this.vertical,...this.themeClasses},attrs:{role:"separator","aria-orientation":e,...this.$attrs},on:this.$listeners})}})},9524:(t,e,s)=>{s.d(e,{Z:()=>i});const i=s(9588).Z},3447:(t,e,s)=>{s.d(e,{y:()=>o});var i=s(8789),a=s(7779),n=s(2066),r=s(5530),l=s(8219);const o=(0,r.Z)(i.Z,a.Z,n.Z).extend({name:"base-item-group",props:{activeClass:{type:String,default:"v-item--active"},mandatory:Boolean,max:{type:[Number,String],default:null},multiple:Boolean,tag:{type:String,default:"div"}},data(){return{internalLazyValue:void 0!==this.value?this.value:this.multiple?[]:void 0,items:[]}},computed:{classes(){return{"v-item-group":!0,...this.themeClasses}},selectedIndex(){return this.selectedItem&&this.items.indexOf(this.selectedItem)||-1},selectedItem(){if(!this.multiple)return this.selectedItems[0]},selectedItems(){return this.items.filter(((t,e)=>this.toggleMethod(this.getValue(t,e))))},selectedValues(){return null==this.internalValue?[]:Array.isArray(this.internalValue)?this.internalValue:[this.internalValue]},toggleMethod(){if(!this.multiple)return t=>this.valueComparator(this.internalValue,t);const t=this.internalValue;return Array.isArray(t)?e=>t.some((t=>this.valueComparator(t,e))):()=>!1}},watch:{internalValue:"updateItemsState",items:"updateItemsState"},created(){this.multiple&&!Array.isArray(this.internalValue)&&(0,l.Kd)("Model must be bound to an array if the multiple property is true.",this)},methods:{genData(){return{class:this.classes}},getValue:(t,e)=>void 0===t.value?e:t.value,onClick(t){this.updateInternalValue(this.getValue(t,this.items.indexOf(t)))},register(t){const e=this.items.push(t)-1;t.$on("change",(()=>this.onClick(t))),this.mandatory&&!this.selectedValues.length&&this.updateMandatory(),this.updateItem(t,e)},unregister(t){if(this._isDestroyed)return;const e=this.items.indexOf(t),s=this.getValue(t,e);this.items.splice(e,1);if(!(this.selectedValues.indexOf(s)<0)){if(!this.mandatory)return this.updateInternalValue(s);this.multiple&&Array.isArray(this.internalValue)?this.internalValue=this.internalValue.filter((t=>t!==s)):this.internalValue=void 0,this.selectedItems.length||this.updateMandatory(!0)}},updateItem(t,e){const s=this.getValue(t,e);t.isActive=this.toggleMethod(s)},updateItemsState(){this.$nextTick((()=>{if(this.mandatory&&!this.selectedItems.length)return this.updateMandatory();this.items.forEach(this.updateItem)}))},updateInternalValue(t){this.multiple?this.updateMultiple(t):this.updateSingle(t)},updateMandatory(t){if(!this.items.length)return;const e=this.items.slice();t&&e.reverse();const s=e.find((t=>!t.disabled));if(!s)return;const i=this.items.indexOf(s);this.updateInternalValue(this.getValue(s,i))},updateMultiple(t){const e=(Array.isArray(this.internalValue)?this.internalValue:[]).slice(),s=e.findIndex((e=>e===t));this.mandatory&&s>-1&&e.length-1<1||null!=this.max&&s<0&&e.length+1>this.max||(s>-1?e.splice(s,1):e.push(t),this.internalValue=e)},updateSingle(t){const e=t===this.internalValue;this.mandatory&&e||(this.internalValue=e?void 0:t)}},render(t){return t(this.tag,this.genData(),this.$slots.default)}});o.extend({name:"v-item-group",provide(){return{itemGroup:this}}})},952:(t,e,s)=>{s.d(e,{Z:()=>a});var i=s(1726);const a=i.Z.extend().extend({name:"v-list",provide(){return{isInList:!0,list:this}},inject:{isInMenu:{default:!1},isInNav:{default:!1}},props:{dense:Boolean,disabled:Boolean,expand:Boolean,flat:Boolean,nav:Boolean,rounded:Boolean,subheader:Boolean,threeLine:Boolean,twoLine:Boolean},data:()=>({groups:[]}),computed:{classes(){return{...i.Z.options.computed.classes.call(this),"v-list--dense":this.dense,"v-list--disabled":this.disabled,"v-list--flat":this.flat,"v-list--nav":this.nav,"v-list--rounded":this.rounded,"v-list--subheader":this.subheader,"v-list--two-line":this.twoLine,"v-list--three-line":this.threeLine}}},methods:{register(t){this.groups.push(t)},unregister(t){const e=this.groups.findIndex((e=>e._uid===t._uid));e>-1&&this.groups.splice(e,1)},listClick(t){if(!this.expand)for(const e of this.groups)e.toggle(t)}},render(t){const e={staticClass:"v-list",class:this.classes,style:this.styles,attrs:{role:this.isInNav||this.isInMenu?void 0:"list",...this.attrs$}};return t(this.tag,this.setBackgroundColor(this.color,e),[this.$slots.default])}})},8168:(t,e,s)=>{s.d(e,{Z:()=>m});var i=s(9524),a=s(8008),n=s(3560),r=s(6141),l=s(6986),o=s(5836),h=s(4552),d=s(950),u=s(5127),c=s(6930),p=s(5530),v=s(8131);const m=(0,p.Z)(r.Z,l.Z,o.Z,(0,d.f)("list"),h.Z).extend().extend({name:"v-list-group",directives:{ripple:u.Z},props:{activeClass:{type:String,default:""},appendIcon:{type:String,default:"$expand"},color:{type:String,default:"primary"},disabled:Boolean,group:[String,RegExp],noAction:Boolean,prependIcon:String,ripple:{type:[Boolean,Object],default:!0},subGroup:Boolean},computed:{classes(){return{"v-list-group--active":this.isActive,"v-list-group--disabled":this.disabled,"v-list-group--no-action":this.noAction,"v-list-group--sub-group":this.subGroup}}},watch:{isActive(t){!this.subGroup&&t&&this.list&&this.list.listClick(this._uid)},$route:"onRouteChange"},created(){this.list&&this.list.register(this),this.group&&this.$route&&null==this.value&&(this.isActive=this.matchRoute(this.$route.path))},beforeDestroy(){this.list&&this.list.unregister(this)},methods:{click(t){this.disabled||(this.isBooted=!0,this.$emit("click",t),this.$nextTick((()=>this.isActive=!this.isActive)))},genIcon(t){return this.$createElement(i.Z,t)},genAppendIcon(){const t=!this.subGroup&&this.appendIcon;return t||this.$slots.appendIcon?this.$createElement(n.Z,{staticClass:"v-list-group__header__append-icon"},[this.$slots.appendIcon||this.genIcon(t)]):null},genHeader(){return this.$createElement(a.Z,{staticClass:"v-list-group__header",attrs:{"aria-expanded":String(this.isActive),role:"button"},class:{[this.activeClass]:this.isActive},props:{inputValue:this.isActive},directives:[{name:"ripple",value:this.ripple}],on:{...this.listeners$,click:this.click}},[this.genPrependIcon(),this.$slots.activator,this.genAppendIcon()])},genItems(){return this.showLazyContent((()=>[this.$createElement("div",{staticClass:"v-list-group__items",directives:[{name:"show",value:this.isActive}]},(0,v.z9)(this))]))},genPrependIcon(){const t=this.subGroup&&null==this.prependIcon?"$subgroup":this.prependIcon;return t||this.$slots.prependIcon?this.$createElement(n.Z,{staticClass:"v-list-group__header__prepend-icon"},[this.$slots.prependIcon||this.genIcon(t)]):null},onRouteChange(t){if(!this.group)return;const e=this.matchRoute(t.path);e&&this.isActive!==e&&this.list&&this.list.listClick(this._uid),this.isActive=e},toggle(t){const e=this._uid===t;e&&(this.isBooted=!0),this.$nextTick((()=>this.isActive=e))},matchRoute(t){return null!==t.match(this.group)}},render(t){return t("div",this.setTextColor(this.isActive&&this.color,{staticClass:"v-list-group",class:this.classes}),[this.genHeader(),t(c.Fx,this.genItems())])}})},8008:(t,e,s)=>{s.d(e,{Z:()=>u});var i=s(5836),a=s(9367),n=s(1302),r=s(2066),l=s(4552),o=s(5127),h=s(8131),d=s(8219);const u=(0,s(5530).Z)(i.Z,a.Z,r.Z,(0,n.d)("listItemGroup"),(0,l.d)("inputValue")).extend().extend({name:"v-list-item",directives:{Ripple:o.Z},inject:{isInGroup:{default:!1},isInList:{default:!1},isInMenu:{default:!1},isInNav:{default:!1}},inheritAttrs:!1,props:{activeClass:{type:String,default(){return this.listItemGroup?this.listItemGroup.activeClass:""}},dense:Boolean,inactive:Boolean,link:Boolean,selectable:{type:Boolean},tag:{type:String,default:"div"},threeLine:Boolean,twoLine:Boolean,value:null},data:()=>({proxyClass:"v-list-item--active"}),computed:{classes(){return{"v-list-item":!0,...a.Z.options.computed.classes.call(this),"v-list-item--dense":this.dense,"v-list-item--disabled":this.disabled,"v-list-item--link":this.isClickable&&!this.inactive,"v-list-item--selectable":this.selectable,"v-list-item--three-line":this.threeLine,"v-list-item--two-line":this.twoLine,...this.themeClasses}},isClickable(){return Boolean(a.Z.options.computed.isClickable.call(this)||this.listItemGroup)}},created(){this.$attrs.hasOwnProperty("avatar")&&(0,d.Jk)("avatar",this)},methods:{click(t){t.detail&&this.$el.blur(),this.$emit("click",t),this.to||this.toggle()},genAttrs(){const t={"aria-disabled":!!this.disabled||void 0,tabindex:this.isClickable&&!this.disabled?0:-1,...this.$attrs};return this.$attrs.hasOwnProperty("role")||this.isInNav||(this.isInGroup?(t.role="option",t["aria-selected"]=String(this.isActive)):this.isInMenu?(t.role=this.isClickable?"menuitem":void 0,t.id=t.id||`list-item-${this._uid}`):this.isInList&&(t.role="listitem")),t},toggle(){this.to&&void 0===this.inputValue&&(this.isActive=!this.isActive),this.$emit("change")}},render(t){let{tag:e,data:s}=this.generateRouteLink();s.attrs={...s.attrs,...this.genAttrs()},s[this.to?"nativeOn":"on"]={...s[this.to?"nativeOn":"on"],keydown:t=>{this.disabled||(t.keyCode===h.Do.enter&&this.click(t),this.$emit("keydown",t))}},this.inactive&&(e="div"),this.inactive&&this.to&&(s.on=s.nativeOn,delete s.nativeOn);const i=this.$scopedSlots.default?this.$scopedSlots.default({active:this.isActive,toggle:this.toggle}):this.$slots.default;return t(e,this.isActive?this.setTextColor(this.color,s):s,i)}})},3444:(t,e,s)=>{s.d(e,{Z:()=>i});const i=s(538).ZP.extend({name:"v-list-item-action",functional:!0,render(t,{data:e,children:s=[]}){e.staticClass=e.staticClass?`v-list-item__action ${e.staticClass}`:"v-list-item__action";return s.filter((t=>!1===t.isComment&&" "!==t.text)).length>1&&(e.staticClass+=" v-list-item__action--stack"),t("div",e,s)}})},2802:(t,e,s)=>{s.d(e,{Z:()=>o});var i=s(5836),a=s(9548),n=s(5357),r=s(8131);const l=(0,s(5530).Z)(i.Z,a.Z,n.Z).extend({name:"v-avatar",props:{left:Boolean,right:Boolean,size:{type:[Number,String],default:48}},computed:{classes(){return{"v-avatar--left":this.left,"v-avatar--right":this.right,...this.roundedClasses}},styles(){return{height:(0,r.kb)(this.size),minWidth:(0,r.kb)(this.size),width:(0,r.kb)(this.size),...this.measurableStyles}}},render(t){const e={staticClass:"v-avatar",class:this.classes,style:this.styles,on:this.$listeners};return t("div",this.setBackgroundColor(this.color,e),this.$slots.default)}}),o=l.extend({name:"v-list-item-avatar",props:{horizontal:Boolean,size:{type:[Number,String],default:40}},computed:{classes(){return{"v-list-item__avatar--horizontal":this.horizontal,...l.options.computed.classes.call(this),"v-avatar--tile":this.tile||this.horizontal}}},render(t){const e=l.options.render.call(this,t);return e.data=e.data||{},e.data.staticClass+=" v-list-item__avatar",e}})},695:(t,e,s)=>{s.d(e,{Z:()=>n});var i=s(3447),a=s(5836);const n=(0,s(5530).Z)(i.y,a.Z).extend({name:"v-list-item-group",provide(){return{isInGroup:!0,listItemGroup:this}},computed:{classes(){return{...i.y.options.computed.classes.call(this),"v-list-item-group":!0}}},methods:{genData(){return this.setTextColor(this.color,{...i.y.options.methods.genData.call(this),attrs:{role:"listbox"}})}}})},3560:(t,e,s)=>{s.d(e,{Z:()=>i});const i=s(538).ZP.extend({name:"v-list-item-icon",functional:!0,render:(t,{data:e,children:s})=>(e.staticClass=`v-list-item__icon ${e.staticClass||""}`.trim(),t("div",e,s))})},6925:(t,e,s)=>{s.d(e,{V9:()=>p,km:()=>c,oZ:()=>v});var i=s(8131),a=s(952),n=s(8168),r=s(8008),l=s(695),o=s(3444),h=s(2802),d=s(3560);const u=(0,i.Ji)("v-list-item__action-text","span"),c=(0,i.Ji)("v-list-item__content","div"),p=(0,i.Ji)("v-list-item__title","div"),v=(0,i.Ji)("v-list-item__subtitle","div");a.Z,n.Z,r.Z,o.Z,h.Z,l.Z,d.Z},8444:(t,e,s)=>{s.d(e,{Z:()=>a});var i=s(2066);const a=(0,s(5530).Z)(i.Z).extend({name:"v-subheader",props:{inset:Boolean},render(t){return t("div",{staticClass:"v-subheader",class:{"v-subheader--inset":this.inset,...this.themeClasses},attrs:this.$attrs,on:this.$listeners},this.$slots.default)}})},6986:(t,e,s)=>{s.d(e,{Z:()=>a});var i=s(8219);const a=s(538).ZP.extend().extend({name:"bootable",props:{eager:Boolean},data:()=>({isBooted:!1}),computed:{hasContent(){return this.isBooted||this.eager||this.isActive}},watch:{isActive(){this.isBooted=!0}},created(){"lazy"in this.$attrs&&(0,i.Jk)("lazy",this)},methods:{showLazyContent(t){return this.hasContent&&t?t():[this.$createElement()]}}})},8789:(t,e,s)=>{s.d(e,{Z:()=>n});var i=s(538),a=s(8131);const n=i.ZP.extend({name:"comparable",props:{valueComparator:{type:Function,default:a.vZ}}})},1302:(t,e,s)=>{s.d(e,{d:()=>a});var i=s(950);function a(t,e,s){return(0,i.f)(t,e,s).extend({name:"groupable",props:{activeClass:{type:String,default(){if(this[t])return this[t].activeClass}},disabled:Boolean},data:()=>({isActive:!1}),computed:{groupClasses(){return this.activeClass?{[this.activeClass]:this.isActive}:{}}},created(){this[t]&&this[t].register(this)},beforeDestroy(){this[t]&&this[t].unregister(this)},methods:{toggle(){this.$emit("change")}}})}a("itemGroup")},950:(t,e,s)=>{s.d(e,{J:()=>l,f:()=>r});var i=s(538),a=s(8219);function n(t,e){return()=>(0,a.Kd)(`The ${t} component must be used inside a ${e}`)}function r(t,e,s){const a=e&&s?{register:n(e,s),unregister:n(e,s)}:null;return i.ZP.extend({name:"registrable-inject",inject:{[t]:{default:a}}})}function l(t,e=!1){return i.ZP.extend({name:"registrable-provide",provide(){return{[t]:e?this:{register:this.register,unregister:this.unregister}}}})}},4552:(t,e,s)=>{s.d(e,{Z:()=>n,d:()=>a});var i=s(538);function a(t="value",e="input"){return i.ZP.extend({name:"toggleable",model:{prop:t,event:e},props:{[t]:{required:!1}},data(){return{isActive:!!this[t]}},watch:{[t](t){this.isActive=!!t},isActive(s){!!s!==this[t]&&this.$emit(e,s)}}})}const n=a()}}]);