import{_ as o}from"./30fae2fd.js";import{h as r,g as n,c as i}from"./8ba31e84.js";import{C as s,L as l}from"./343b66ef.js";import{S as d}from"./d3299a61.js";import{n as u}from"./75131b1e.js";const c={name:"Page",components:{ComponentLoading:s,Row:()=>({component:o(()=>import("./f91d226c.js"),["assets/js/f91d226c.js","assets/js/30fae2fd.js","assets/css/4ddb1fa6.css","assets/js/8ba31e84.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/d3299a61.js","assets/js/343b66ef.js"]),...l}),Table:()=>({component:o(()=>import("./7818c519.js"),["assets/js/7818c519.js","assets/js/30fae2fd.js","assets/css/4ddb1fa6.css","assets/js/8ba31e84.js","assets/css/025f49a1.css","assets/js/75131b1e.js"]),loading:r,delay:0,error:n,timeout:1e4}),Card:()=>({component:o(()=>import("./a20a892f.js").then(e=>e.d),["assets/js/a20a892f.js","assets/css/1f7b26d7.css","assets/js/30fae2fd.js","assets/css/4ddb1fa6.css","assets/js/8ba31e84.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/65a60693.js","assets/css/029efb8b.css","assets/js/24ed13ab.js","assets/css/62c25b1f.css","assets/js/1c949a44.js","assets/css/55f96b45.css","assets/js/edafd123.js","assets/css/526f3c7c.css"]),loading:d,delay:0,error:n,timeout:1e4})},mixins:[i],data(){return{component:{},route:this.value.data.route,runLoader:this.value.data.runLoader,vuexNamespace:this.value.data.vuexNamespace,callbackDelay:this.value.data.callbackDelay,hasVuexNamespace:this.value.data.vuexNamespace!==void 0,hasCallbackDelay:this.value.data.callbackDelay!==void 0}},computed:{isLoad(){return Object.keys(this.overview).length!==0},overview(){return this.vuexNamespace!==void 0?this.$store.getters[`${this.vuexNamespace}/component`]:this.component}},created(){if(this.$loader.convertStringToRouteParams(),this.route!==void 0&&this.load(),this.hasCallbackDelay&&(this.interval=setInterval(()=>{this.load()},this.callbackDelay)),this.runLoader!==void 0){const e=typeof this.runLoader=="string"?this.runLoader:this.vuexNamespace;e!==void 0&&this.$loader.runStateAction(e)}},beforeDestroy(){this.hasCallbackDelay&&clearInterval(this.interval)},methods:{load(){this.vuexNamespace!==void 0?this.$store.dispatch(`${this.vuexNamespace}/component`,this.route):this.$api.call({url:this.route}).then(e=>{this.component=e.data.component||{}})}}};var m=function(){var a=this,t=a._self._c;return t("div",[a.isLoad?t(a.overview.componentName,{tag:"component",attrs:{value:a.overview}}):[t("ComponentLoading")]],2)},p=[],h=u(c,m,p,!1,null,null,null,null);const x=h.exports;export{x as default};
