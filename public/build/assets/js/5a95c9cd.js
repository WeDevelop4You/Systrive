import{P as H,p as a,a as w}from"./abc307ea.js";import{m as f,T as b,C as v}from"./10397c83.js";import{a3 as M}from"./e60bc734.js";var s;(function(t){t[t.Hour=1]="Hour",t[t.Minute=2]="Minute",t[t.Second=3]="Second"})(s||(s={}));const P=f(H).extend({name:"v-time-picker-title",props:{ampm:Boolean,ampmReadonly:Boolean,disabled:Boolean,hour:Number,minute:Number,second:Number,period:{type:String,validator:t=>t==="am"||t==="pm"},readonly:Boolean,useSeconds:Boolean,selecting:Number},methods:{genTime(){let t=this.hour;this.ampm&&(t=t?(t-1)%12+1:12);const e=this.hour==null?"--":this.ampm?String(t):a(t),i=this.minute==null?"--":a(this.minute),n=[this.genPickerButton("selecting",s.Hour,e,this.disabled),this.$createElement("span",":"),this.genPickerButton("selecting",s.Minute,i,this.disabled)];if(this.useSeconds){const o=this.second==null?"--":a(this.second);n.push(this.$createElement("span",":")),n.push(this.genPickerButton("selecting",s.Second,o,this.disabled))}return this.$createElement("div",{class:"v-time-picker-title__time"},n)},genAmPm(){return this.$createElement("div",{staticClass:"v-time-picker-title__ampm",class:{"v-time-picker-title__ampm--readonly":this.ampmReadonly}},[!this.ampmReadonly||this.period==="am"?this.genPickerButton("period","am",this.$vuetify.lang.t("$vuetify.timePicker.am"),this.disabled||this.readonly):null,!this.ampmReadonly||this.period==="pm"?this.genPickerButton("period","pm",this.$vuetify.lang.t("$vuetify.timePicker.pm"),this.disabled||this.readonly):null])}},render(t){const e=[this.genTime()];return this.ampm&&e.push(this.genAmPm()),t("div",{staticClass:"v-time-picker-title"},e)}});const S=f(v,b).extend({name:"v-time-picker-clock",props:{allowedValues:Function,ampm:Boolean,disabled:Boolean,double:Boolean,format:{type:Function,default:t=>t},max:{type:Number,required:!0},min:{type:Number,required:!0},scrollable:Boolean,readonly:Boolean,rotate:{type:Number,default:0},step:{type:Number,default:1},value:Number},data(){return{inputValue:this.value,isDragging:!1,valueOnMouseDown:null,valueOnMouseUp:null}},computed:{count(){return this.max-this.min+1},degreesPerUnit(){return 360/this.roundCount},degrees(){return this.degreesPerUnit*Math.PI/180},displayedValue(){return this.value==null?this.min:this.value},innerRadiusScale(){return .62},roundCount(){return this.double?this.count/2:this.count}},watch:{value(t){this.inputValue=t}},methods:{wheel(t){t.preventDefault();const e=Math.sign(-t.deltaY||1);let i=this.displayedValue;do i=i+e,i=(i-this.min+this.count)%this.count+this.min;while(!this.isAllowed(i)&&i!==this.displayedValue);i!==this.displayedValue&&this.update(i)},isInner(t){return this.double&&t-this.min>=this.roundCount},handScale(t){return this.isInner(t)?this.innerRadiusScale:1},isAllowed(t){return!this.allowedValues||this.allowedValues(t)},genValues(){const t=[];for(let e=this.min;e<=this.max;e=e+this.step){const i=e===this.value&&(this.color||"accent");t.push(this.$createElement("span",this.setBackgroundColor(i,{staticClass:"v-time-picker-clock__item",class:{"v-time-picker-clock__item--active":e===this.displayedValue,"v-time-picker-clock__item--disabled":this.disabled||!this.isAllowed(e)},style:this.getTransform(e),domProps:{innerHTML:`<span>${this.format(e)}</span>`}})))}return t},genHand(){const t=`scaleY(${this.handScale(this.displayedValue)})`,e=this.rotate+this.degreesPerUnit*(this.displayedValue-this.min),i=this.value!=null&&(this.color||"accent");return this.$createElement("div",this.setBackgroundColor(i,{staticClass:"v-time-picker-clock__hand",class:{"v-time-picker-clock__hand--inner":this.isInner(this.value)},style:{transform:`rotate(${e}deg) ${t}`}}))},getTransform(t){const{x:e,y:i}=this.getPosition(t);return{left:`${50+e*50}%`,top:`${50+i*50}%`}},getPosition(t){const e=this.rotate*Math.PI/180;return{x:Math.sin((t-this.min)*this.degrees+e)*this.handScale(t),y:-Math.cos((t-this.min)*this.degrees+e)*this.handScale(t)}},onMouseDown(t){t.preventDefault(),this.valueOnMouseDown=null,this.valueOnMouseUp=null,this.isDragging=!0,this.onDragMove(t)},onMouseUp(t){t.stopPropagation(),this.isDragging=!1,this.valueOnMouseUp!==null&&this.isAllowed(this.valueOnMouseUp)&&this.$emit("change",this.valueOnMouseUp)},onDragMove(t){if(t.preventDefault(),!this.isDragging&&t.type!=="click"||!this.$refs.clock)return;const{width:e,top:i,left:n}=this.$refs.clock.getBoundingClientRect(),{width:o}=this.$refs.innerClock.getBoundingClientRect(),{clientX:r,clientY:m}="touches"in t?t.touches[0]:t,c={x:e/2,y:-e/2},l={x:r-n,y:i-m},h=Math.round(this.angle(c,l)-this.rotate+360)%360,p=this.double&&this.euclidean(c,l)<(o+o*this.innerRadiusScale)/4,d=Math.ceil(15/this.degreesPerUnit);let u;for(let g=0;g<d;g++){if(u=this.angleToValue(h+g*this.degreesPerUnit,p),this.isAllowed(u))return this.setMouseDownValue(u);if(u=this.angleToValue(h-g*this.degreesPerUnit,p),this.isAllowed(u))return this.setMouseDownValue(u)}},angleToValue(t,e){const i=(Math.round(t/this.degreesPerUnit)+(e?this.roundCount:0))%this.count+this.min;return t<360-this.degreesPerUnit/2?i:e?this.max-this.roundCount+1:this.min},setMouseDownValue(t){this.valueOnMouseDown===null&&(this.valueOnMouseDown=t),this.valueOnMouseUp=t,this.update(t)},update(t){this.inputValue!==t&&(this.inputValue=t,this.$emit("input",t))},euclidean(t,e){const i=e.x-t.x,n=e.y-t.y;return Math.sqrt(i*i+n*n)},angle(t,e){const i=2*Math.atan2(e.y-t.y-this.euclidean(t,e),e.x-t.x);return Math.abs(i*180/Math.PI)}},render(t){const e={staticClass:"v-time-picker-clock",class:{"v-time-picker-clock--indeterminate":this.value==null,...this.themeClasses},on:this.readonly||this.disabled?void 0:{mousedown:this.onMouseDown,mouseup:this.onMouseUp,mouseleave:i=>this.isDragging&&this.onMouseUp(i),touchstart:this.onMouseDown,touchend:this.onMouseUp,mousemove:this.onDragMove,touchmove:this.onDragMove},ref:"clock"};return this.scrollable&&e.on&&(e.on.wheel=this.wheel),t("div",e,[t("div",{staticClass:"v-time-picker-clock__inner",ref:"innerClock"},[this.genHand(),this.genValues()])])}}),C=M(24),k=M(12),A=k.map(t=>t+12),y=M(60),$={1:"hour",2:"minute",3:"second"},I=f(w,H).extend({name:"v-time-picker",props:{allowedHours:[Function,Array],allowedMinutes:[Function,Array],allowedSeconds:[Function,Array],disabled:Boolean,format:{type:String,default:"ampm",validator(t){return["ampm","24hr"].includes(t)}},min:String,max:String,readonly:Boolean,scrollable:Boolean,useSeconds:Boolean,value:null,ampmInTitle:Boolean},data(){return{inputHour:null,inputMinute:null,inputSecond:null,lazyInputHour:null,lazyInputMinute:null,lazyInputSecond:null,period:"am",selecting:s.Hour}},computed:{selectingHour:{get(){return this.selecting===s.Hour},set(t){this.selecting=s.Hour}},selectingMinute:{get(){return this.selecting===s.Minute},set(t){this.selecting=s.Minute}},selectingSecond:{get(){return this.selecting===s.Second},set(t){this.selecting=s.Second}},isAllowedHourCb(){let t;if(this.allowedHours instanceof Array?t=n=>this.allowedHours.includes(n):t=this.allowedHours,!this.min&&!this.max)return t;const e=this.min?Number(this.min.split(":")[0]):0,i=this.max?Number(this.max.split(":")[0]):23;return n=>n>=e*1&&n<=i*1&&(!t||t(n))},isAllowedMinuteCb(){let t;const e=!this.isAllowedHourCb||this.inputHour===null||this.isAllowedHourCb(this.inputHour);if(this.allowedMinutes instanceof Array?t=l=>this.allowedMinutes.includes(l):t=this.allowedMinutes,!this.min&&!this.max)return e?t:()=>!1;const[i,n]=this.min?this.min.split(":").map(Number):[0,0],[o,r]=this.max?this.max.split(":").map(Number):[23,59],m=i*60+n*1,c=o*60+r*1;return l=>{const h=60*this.inputHour+l;return h>=m&&h<=c&&e&&(!t||t(l))}},isAllowedSecondCb(){let t;const i=(!this.isAllowedHourCb||this.inputHour===null||this.isAllowedHourCb(this.inputHour))&&(!this.isAllowedMinuteCb||this.inputMinute===null||this.isAllowedMinuteCb(this.inputMinute));if(this.allowedSeconds instanceof Array?t=d=>this.allowedSeconds.includes(d):t=this.allowedSeconds,!this.min&&!this.max)return i?t:()=>!1;const[n,o,r]=this.min?this.min.split(":").map(Number):[0,0,0],[m,c,l]=this.max?this.max.split(":").map(Number):[23,59,59],h=n*3600+o*60+(r||0)*1,p=m*3600+c*60+(l||0)*1;return d=>{const u=3600*this.inputHour+60*this.inputMinute+d;return u>=h&&u<=p&&i&&(!t||t(d))}},isAmPm(){return this.format==="ampm"}},watch:{value:"setInputData"},mounted(){this.setInputData(this.value),this.$on("update:period",this.setPeriod)},methods:{genValue(){return this.inputHour!=null&&this.inputMinute!=null&&(!this.useSeconds||this.inputSecond!=null)?`${a(this.inputHour)}:${a(this.inputMinute)}`+(this.useSeconds?`:${a(this.inputSecond)}`:""):null},emitValue(){const t=this.genValue();t!==null&&this.$emit("input",t)},setPeriod(t){if(this.period=t,this.inputHour!=null){const e=this.inputHour+(t==="am"?-12:12);this.inputHour=this.firstAllowed("hour",e),this.emitValue()}},setInputData(t){if(t==null||t==="")this.inputHour=null,this.inputMinute=null,this.inputSecond=null;else if(t instanceof Date)this.inputHour=t.getHours(),this.inputMinute=t.getMinutes(),this.inputSecond=t.getSeconds();else{const[,e,i,,n,o]=t.trim().toLowerCase().match(/^(\d+):(\d+)(:(\d+))?([ap]m)?$/)||new Array(6);this.inputHour=o?this.convert12to24(parseInt(e,10),o):parseInt(e,10),this.inputMinute=parseInt(i,10),this.inputSecond=parseInt(n||0,10)}this.period=this.inputHour==null||this.inputHour<12?"am":"pm"},convert24to12(t){return t?(t-1)%12+1:12},convert12to24(t,e){return t%12+(e==="pm"?12:0)},onInput(t){this.selecting===s.Hour?this.inputHour=this.isAmPm?this.convert12to24(t,this.period):t:this.selecting===s.Minute?this.inputMinute=t:this.inputSecond=t,this.emitValue()},onChange(t){this.$emit(`click:${$[this.selecting]}`,t);const e=this.selecting===(this.useSeconds?s.Second:s.Minute);if(this.selecting===s.Hour?this.selecting=s.Minute:this.useSeconds&&this.selecting===s.Minute&&(this.selecting=s.Second),this.inputHour===this.lazyInputHour&&this.inputMinute===this.lazyInputMinute&&(!this.useSeconds||this.inputSecond===this.lazyInputSecond))return;const i=this.genValue();i!==null&&(this.lazyInputHour=this.inputHour,this.lazyInputMinute=this.inputMinute,this.useSeconds&&(this.lazyInputSecond=this.inputSecond),e&&this.$emit("change",i))},firstAllowed(t,e){const i=t==="hour"?this.isAllowedHourCb:t==="minute"?this.isAllowedMinuteCb:this.isAllowedSecondCb;if(!i)return e;const n=t==="minute"||t==="second"?y:this.isAmPm?e<12?k:A:C;return((n.find(r=>i((r+e)%n.length+n[0]))||0)+e)%n.length+n[0]},genClock(){return this.$createElement(S,{props:{allowedValues:this.selecting===s.Hour?this.isAllowedHourCb:this.selecting===s.Minute?this.isAllowedMinuteCb:this.isAllowedSecondCb,color:this.color,dark:this.dark,disabled:this.disabled,double:this.selecting===s.Hour&&!this.isAmPm,format:this.selecting===s.Hour?this.isAmPm?this.convert24to12:t=>t:t=>a(t,2),light:this.light,max:this.selecting===s.Hour?this.isAmPm&&this.period==="am"?11:23:59,min:this.selecting===s.Hour&&this.isAmPm&&this.period==="pm"?12:0,readonly:this.readonly,scrollable:this.scrollable,size:Number(this.width)-(!this.fullWidth&&this.landscape?80:20),step:this.selecting===s.Hour?1:5,value:this.selecting===s.Hour?this.inputHour:this.selecting===s.Minute?this.inputMinute:this.inputSecond},on:{input:this.onInput,change:this.onChange},ref:"clock"})},genClockAmPm(){return this.$createElement("div",this.setTextColor(this.color||"primary",{staticClass:"v-time-picker-clock__ampm"}),[this.genPickerButton("period","am",this.$vuetify.lang.t("$vuetify.timePicker.am"),this.disabled||this.readonly),this.genPickerButton("period","pm",this.$vuetify.lang.t("$vuetify.timePicker.pm"),this.disabled||this.readonly)])},genPickerBody(){return this.$createElement("div",{staticClass:"v-time-picker-clock__container",key:this.selecting},[!this.ampmInTitle&&this.isAmPm&&this.genClockAmPm(),this.genClock()])},genPickerTitle(){return this.$createElement(P,{props:{ampm:this.isAmPm,ampmReadonly:this.isAmPm&&!this.ampmInTitle,disabled:this.disabled,hour:this.inputHour,minute:this.inputMinute,second:this.inputSecond,period:this.period,readonly:this.readonly,useSeconds:this.useSeconds,selecting:this.selecting},on:{"update:selecting":t=>this.selecting=t,"update:period":t=>this.$emit("update:period",t)},ref:"title",slot:"title"})}},render(){return this.genPicker("v-picker--time")}});export{I as _};
