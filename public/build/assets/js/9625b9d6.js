import{_ as t}from"./89ae458c.js";import{c as s}from"./20f47019.js";import{n as r}from"./75131b1e.js";const o={name:"Table",components:{LocaleDataTable:()=>t(()=>import("./73387d06.js"),["assets/js/73387d06.js","assets/js/0fd98d8f.js","assets/css/d676ab1c.css","assets/js/89ae458c.js","assets/css/4ddb1fa6.css","assets/js/fe4bf605.js","assets/css/085112bc.css","assets/js/3b8c775f.js","assets/css/bb7e0fdc.css","assets/js/744bff6b.js","assets/css/6f9cee48.css","assets/js/20f47019.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/3bfe2d76.js","assets/js/64eb8a9e.js","assets/css/55f96b45.css","assets/js/53ee5cfb.js","assets/css/62c25b1f.css","assets/js/64b64aa2.js","assets/js/f57264bf.js","assets/js/4cec98fc.js","assets/css/a92f18bb.css","assets/js/492a710f.js","assets/js/94ca7cec.js","assets/css/029efb8b.css","assets/js/27561507.js","assets/css/70d8eb6d.css","assets/js/05a5b6b8.js","assets/js/456dbe17.js","assets/js/b7f1edae.js","assets/js/9f62fef9.js","assets/css/9e64cc89.css","assets/js/5661cf77.js","assets/js/12b2fd9b.js","assets/css/c4ecb3dc.css","assets/js/adb0a683.js","assets/js/30ff1d0a.js","assets/css/e89f2dca.css","assets/js/dd294eca.js","assets/js/0f69cb55.js","assets/css/726b8e9b.css","assets/js/00245e15.js","assets/js/14ee71cd.js","assets/css/526f3c7c.css"]),ServerDataTable:()=>t(()=>import("./7d1bc94a.js"),["assets/js/7d1bc94a.js","assets/js/89ae458c.js","assets/css/4ddb1fa6.css","assets/js/0fd98d8f.js","assets/css/d676ab1c.css","assets/js/fe4bf605.js","assets/css/085112bc.css","assets/js/3b8c775f.js","assets/css/bb7e0fdc.css","assets/js/744bff6b.js","assets/css/6f9cee48.css","assets/js/20f47019.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/3bfe2d76.js","assets/js/64eb8a9e.js","assets/css/55f96b45.css","assets/js/53ee5cfb.js","assets/css/62c25b1f.css","assets/js/64b64aa2.js","assets/js/f57264bf.js","assets/js/4cec98fc.js","assets/css/a92f18bb.css","assets/js/492a710f.js","assets/js/94ca7cec.js","assets/css/029efb8b.css","assets/js/27561507.js","assets/css/70d8eb6d.css","assets/js/05a5b6b8.js","assets/js/456dbe17.js","assets/js/b7f1edae.js","assets/js/9f62fef9.js","assets/css/9e64cc89.css","assets/js/5661cf77.js","assets/js/12b2fd9b.js","assets/css/c4ecb3dc.css","assets/js/adb0a683.js","assets/js/30ff1d0a.js","assets/css/e89f2dca.css","assets/js/dd294eca.js","assets/js/0f69cb55.js","assets/css/726b8e9b.css","assets/js/00245e15.js","assets/js/14ee71cd.js","assets/css/526f3c7c.css"])},mixins:[s],data(){return{vuexNamespace:this.value.attributes.vuexNamespace}},created(){this.setup()},methods:{setup(){this.$store.commit(`${this.vuexNamespace}/setRoutes`,{items:this.value.data.itemsUrl,headers:this.value.data.headerUrl}),this.$store.dispatch(`${this.vuexNamespace}/getHeaders`)}}};var n=function(){var e=this,a=e._self._c;return a(e.value.data.type,e._b({tag:"component",attrs:{value:e.value}},"component",e.value.attributes,!1))},i=[],l=r(o,n,i,!1,null,null,null,null);const p=l.exports;export{p as default};