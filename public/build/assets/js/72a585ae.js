import t from"./89476e2a.js";import{n as s}from"./75131b1e.js";import"./89ae458c.js";import"./20f47019.js";import"./dafc7e36.js";import"./f37f3979.js";const o={name:"DomainNameServer",components:{ViewLayer:t},beforeRouteUpdate(e,r,a){this.setup(e.params.domainNameServer),a()},data(){return{overview:{data:{vuexNamespace:"company/system/dns/overview"}}}},created(){this.setup(this.$route.params.domainNameServer)},methods:{async setup(e){await this.$store.dispatch("company/system/dns/search",e)}}};var n=function(){var r=this,a=r._self._c;return a("view-layer",{attrs:{value:r.overview}})},m=[],i=s(o,n,m,!1,null,null,null,null);const _=i.exports;export{_ as default};