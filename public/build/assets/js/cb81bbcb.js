import{V as s}from"./2d81e741.js";import{n as o}from"./75131b1e.js";import"./5ecbb865.js";import"./fb26d87e.js";import"./e0db1d00.js";import"./08a971a8.js";const a={name:"Settings",extends:s,beforeRouteUpdate(e,t,r){this.setup(e.params.page),r()},created(){this.setup(this.$route.params.page)},methods:{getRoute(){return this.$api.route("account.settings.overview")},setup(e){this.$store.dispatch("settings/view",e)}}};var n=function(){var t=this,r=t._self._c;return r("view-layer",{attrs:{value:t.overview}})},i=[],p=o(a,n,i,!1,null,null,null,null);const f=p.exports;export{f as default};
