"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[9238],{8668:(e,t,a)=>{a.r(t),a.d(t,{default:()=>n});const s={name:"Table",components:{LocaleDataTable:function(){return Promise.all([a.e(5317),a.e(9157)]).then(a.bind(a,4433))},ServerDataTable:function(){return Promise.all([a.e(5317),a.e(2668)]).then(a.bind(a,7719))}},mixins:[a(1373).Z],data:function(){return{vuexNamespace:this.value.attributes.vuexNamespace}},created:function(){this.setup()},methods:{setup:function(){this.$store.commit("".concat(this.vuexNamespace,"/setRoutes"),{items:this.value.data.itemsUrl,headers:this.value.data.headerUrl}),this.$store.dispatch("".concat(this.vuexNamespace,"/getHeaders"))}}};const n=(0,a(1900).Z)(s,(function(){var e=this;return(0,e._self._c)(e.value.data.type,e._b({tag:"component",attrs:{value:e.value}},"component",e.value.attributes,!1))}),[],!1,null,null,null).exports}}]);