import{V as s}from"./30fae2fd.js";import{i as r}from"./a5372d14.js";function a(t="value",i="input"){return s.extend({name:"toggleable",model:{prop:t,event:i},props:{[t]:{required:!1}},data(){return{isActive:!!this[t]}},watch:{[t](e){this.isActive=!!e},isActive(e){!!e!==this[t]&&this.$emit(i,e)}}})}const o=a(),n=o;function u(t,i,e){return r(t,i,e).extend({name:"groupable",props:{activeClass:{type:String,default(){if(!!this[t])return this[t].activeClass}},disabled:Boolean},data(){return{isActive:!1}},computed:{groupClasses(){return this.activeClass?{[this.activeClass]:this.isActive}:{}}},created(){this[t]&&this[t].register(this)},beforeDestroy(){this[t]&&this[t].unregister(this)},methods:{toggle(){this.$emit("change")}}})}u("itemGroup");export{n as T,u as a,a as f};
