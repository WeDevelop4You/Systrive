import{g as o,h as s,f as r}from"./dcc38a7c.js";import{C as n}from"./12a8f78c.js";import{L as i}from"./65f62a47.js";import{n as h}from"./75131b1e.js";const u={name:"Page",components:{ComponentError:o,ComponentLoading:s},mixins:[r],beforeRouteUpdate(e,t,a){this.hasUpdateOnRouteChange&&this.getUpdateOnRouteChangeCondition(e,t)&&(this.component=n.empty(),this.getComponent(e)),a()},props:{value:{type:Object,default:()=>({data:{}})}},data(){return{component:{},route:this.value.data.route,loadState:this.value.data.loadState,vuexNamespace:this.value.data.vuexNamespace,refreshDelay:this.value.data.refreshDelay,updateOnRouteChange:this.value.data.updateOnRouteChange}},computed:{isLoad(){return Object.keys(this.overview).length!==0},overview(){return this.hasVuexNamespace()?this.$store.getters[`${this.vuexNamespace}/component`]:this.component}},created(){this.$loader instanceof i&&this.$loader.convertStringToRouteParams(),this.hasRoute()&&this.getComponent(),this.hasRefreshDelay()&&this.createRefresh(),this.hasLoadState()&&this.runLoadState()},beforeDestroy(){this.hasRefreshDelay()&&clearInterval(this.interval)},methods:{hasRoute(){return this.route!==void 0},hasVuexNamespace(){return this.vuexNamespace!==void 0},hasRefreshDelay(){return this.refreshDelay!==void 0},hasLoadState(){return this.loadState!==void 0},hasUpdateOnRouteChange(){return this.updateOnRouteChange!==void 0},createRoute(e){return this.route instanceof Function?this.route.call(this,{app:this,route:e||this.$route}):this.route},createRefresh(){this.interval=setInterval(()=>{this.getComponent()},this.refreshDelay)},getComponent(e){const t=this.createRoute(e);this.hasVuexNamespace()?this.getComponentWithVuex(t):this.getComponentWithApi(t)},getComponentWithVuex(e){this.$store.dispatch(`${this.vuexNamespace}/component`,e)},getComponentWithApi(e){const t=new n({componentName:"ComponentError"});this.$api.call({url:e,method:"GET"}).then(a=>{this.component=a.data.component||t})},getLoadStateVuexNamespace(){switch(typeof this.loadState){case"boolean":return"";case"string":return this.loadState;default:return this.vuexNamespace}},getUpdateOnRouteChangeCondition(e,t){return this.updateOnRouteChange instanceof Function?this.updateOnRouteChange.call(this,e,t):this.updateOnRouteChange},runLoadState(){const e=this.getLoadStateVuexNamespace();e!==void 0&&this.$loader.runStateAction(e)}}};var p=function(){var t=this,a=t._self._c;return a("div",[t.isLoad?a(t.overview.componentName,t._b({tag:"component",attrs:{value:t.overview}},"component",t.overview.attributes,!1)):[a("ComponentLoading")]],2)},d=[],m=h(u,p,d,!1,null,null,null,null);const g=m.exports;export{g as default};
