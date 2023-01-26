var x=(e,a,t)=>{if(!a.has(e))throw TypeError("Cannot "+t)};var u=(e,a,t)=>(x(e,a,"read from private field"),t?t.call(e):a.get(e)),E=(e,a,t)=>{if(a.has(e))throw TypeError("Cannot add the same private member more than once");a instanceof WeakSet?a.add(e):a.set(e,t)},I=(e,a,t,s)=>(x(e,a,"write to private field"),s?s.call(e,t):a.set(e,t),t);import{V as n,F as y,l as g,O as b,i as z,S as j,_ as o,B as m,a as C,A as B,e as F,b as H,c as S,d as M}from"./feafbc55.js";import{a as U}from"./ee2f9ce0.js";import{U as q,R as J,S as K}from"./7828eb71.js";import{S as T,a as D,L as Q}from"./a0bb82aa.js";const v=n.prototype,W={namespaced:!0,actions:{init({commit:e},a){e(`${a}/setCreate`,{})},create({commit:e},a){e("form/resetForm",0),v.$api.call({url:a,method:"GET"}).then(()=>{e("form/setCreate",{})})},store({commit:e,getters:a},t){return v.$api.call({url:t,method:"POST",data:a["form/data"]}).catch(s=>(e("form/setErrors",s.response.data.errors||{}),Promise.reject()))},edit({commit:e},a){e("form/resetForm",0),v.$api.call({url:a,method:"GET"}).then(()=>{e("form/setEdit",{})})},update({commit:e,getters:a},t){return v.$api.call({url:t,method:"PATCH",data:a["form/data"]}).catch(s=>(e("form/setErrors",s.response.data.errors||{}),Promise.reject()))}},modules:{form:y(),restoreForm:y()}},$=n.prototype,X={namespaced:!0,state:()=>({items:[]}),mutations:{setItems(e,a){e.items=a},addItem(e,a){e.items.push(a)},addItemAtIndex(e,{data:a,index:t}){e.items.splice(t,0,a)},replaceItem(e,{data:a,index:t}){e.items.splice(t,1,a)},replaceItemAtIndex(e,{data:a,originalIndex:t,index:s}){e.items[t]=a,U(e.items,t,s)},deleteItem(e,a){e.items.splice(a,1)}},getters:{getItems(e){return e.items},getReIndexedItems(e){return g.exports.cloneDeep(e.items).map((t,s)=>(t.after=s,t))}},actions:{list({commit:e},a){$.$api.call({url:a,method:"GET"}).then(t=>{e("setItems",t.data.data)})},create({commit:e,rootGetters:a},t){$.$api.call({url:t,method:"GET",params:{isEditing:a["cms/table/form/isEditing"]}}).then(s=>{e("form/setCreate",s.data.data)})},edit({commit:e,state:a,rootGetters:t},s){$.$api.call({url:s,method:"GET",params:{isEditing:t["cms/table/form/isEditing"]}}).then(r=>{const d=r.data.data,i=a.items.find(_=>_.original_key===d);e("form/setEdit",g.exports.cloneDeep(i||{}))})},process({state:e,commit:a,getters:t},s){const r=g.exports.cloneDeep(t["form/data"]),d=e.items.map(i=>i.original_key).filter(i=>i!==r.original_key);return r.type=r.type.value,$.$api.call({url:s,method:"POST",data:{...r,keys:d}}).then(i=>{const _=r.after,R=e.items.findIndex(p=>p.original_key===r.original_key),A=(p,l)=>{switch(p){case"addItem":return l;case"addItemAtIndex":return{data:l,index:_};case"replaceItem":return{data:l,index:R};case"replaceItemAtIndex":return{data:l,originalIndex:R,index:_}}},G=(p,l)=>{a(p,A(p,l.listItem)),a(`dataTable/${p}`,A(p,l.tableItem))},P=_==="default",k=t["form/isEditing"]?P?"replaceItem":"replaceItemAtIndex":P?"addItem":"addItemAtIndex";return G(k,i.data.data),Promise.resolve()}).catch(i=>(a("form/setErrors",i.response.data.errors||{}),Promise.reject()))},delete({state:e,commit:a},t){const s=e.items.findIndex(r=>r.original_key===t);a("deleteItem",s),a("dataTable/deleteItem",s)}},modules:{form:y()}},f=n.prototype,Y={namespaced:!0,actions:{create({commit:e},a){f.$api.call({url:a,method:"GET"}).then(t=>{e("form/setCreate",t.data.data)})},store({commit:e,getters:a},t){const s=a["form/data"],r=a["columns/getReIndexedItems"];return f.$api.call({url:t,method:"POST",data:{...s,columns:r}}).catch(d=>(e("form/setErrors",d.response.data.errors||{}),Promise.reject()))},edit({commit:e},a){f.$api.call({url:a,method:"GET"}).then(t=>{e("form/setEdit",t.data.data)})},update({commit:e,getters:a},t){const s=a["form/data"],r=a["columns/getReIndexedItems"];return f.$api.call({url:t,method:"PATCH",data:{...s,columns:r}}).catch(d=>(e("form/setErrors",d.response.data.errors||{}),Promise.reject()))}},modules:{form:y(),overview:b(),items:W,columns:X}},N=n.prototype,Z={namespaced:!0,state:()=>({id:null,name:null,database:null}),mutations:{initialize(e,a){e.id=a.id,e.name=a.name,e.database=a.database}},getters:{id(e){return e.id}},actions:{search({commit:e},a){return N.$api.call({url:N.$api.companyRoute("company.cms.search",a),method:"GET"}).then(t=>(e("initialize",t.data.data),Promise.resolve()))}},modules:{table:Y}},ee={namespaced:!0,modules:{overview:b}},ae=n.prototype,te={namespaced:!0,actions:{edit({commit:e},a){ae.$api.call({url:a,method:"GET"}).then(t=>{e("form/setEdit",t.data.data)})}},modules:{form:y({withoutId:!0}),overview:b}},se={namespaced:!0,modules:{overview:b}},re={namespaced:!0,modules:{overview:b}};n.use(z);const w=n.prototype,L=new j({state:()=>({id:null,systemId:null}),mutations:{initialize(e,a){e.id=a.id,e.systemId=a.system_id}},getters:{id(e){return e.id},systemId(e){return e.systemId}},actions:{initialize({commit:e},a){return e("navigation/setMain",[]),w.$api.call({url:w.$api.route("company.initialize",a),method:"GET"}).then(t=>{e("initialize",t.data.data)})},complete({commit:e},a){w.$api.call({url:a,method:"GET"}).then(()=>{e("form/setCreate",{})})},update({getters:e,commit:a},t){return w.$api.call({url:t,method:"PATCH",data:e["form/data"]}).catch(s=>(a("form/setErrors",s.response.data.errors||{}),Promise.reject()))}},modules:{form:y({isReady:!0,withoutId:!0,disableLoader:!0}),switcher:b(),cms:Z,users:q,roles:J,system:{namespaced:!0,modules:{dns:ee,domain:te,database:se,mailDomain:re}}}}),oe=[{path:"/",name:"cms.table",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{vuexNamespace:"cms/table/overview",route:({app:e,route:a})=>e.$api.companyRoute("company.cms.table.search",e.$store.getters["cms/id"],a.params.tableName),updateOnRouteChange:(e,a)=>{const t=e.params.cmsName===a.params.cmsName,s=e.params.tableName!==a.params.tableName;return t&&s}}}},meta:{page:"company",breadcrumbs:({app:e,route:a})=>e.$breadcrumbs.setCms(a)}}],me=[{path:"users/:chapters*",name:"admin.users",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{route:({app:e})=>e.$api.companyRoute("company.user.overview")}}},meta:{page:"company",allowedStates:[T,D],breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setAdmin(t).add(new m(a.lang.t("$vuetify.word.users")))}},{path:"roles/:chapters*",name:"admin.roles",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{route:({app:e})=>e.$api.companyRoute("company.role.overview")}}},meta:{page:"company",allowedStates:[T,D],breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setAdmin(t).add(new m(a.lang.t("$vuetify.word.roles")))}}],ne=[{path:"d/:name/:chapters*",name:"system.domain",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{route:({app:e,route:a})=>e.systemRoute("system.domain.search",a.params.name),updateOnRouteChange:(e,a)=>e.params.name!==a.params.name}}},meta:{page:"company",allowedStates:T,breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setSystem(t,a.lang.t("$vuetify.word.domain.domain"))}},{path:"dns/:name",name:"system.dns",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{vuexNamespace:"company/system/dns/overview",route:({app:e,route:a})=>e.$api.systemRoute("system.dns.search",a.params.name),updateOnRouteChange:(e,a)=>e.params.name!==a.params.name}}},meta:{page:"company",breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setSystem(t,a.lang.t("$vuetify.word.dns.dns"))}},{path:"db/:name",name:"system.database",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{vuexNamespace:"company/system/database/overview",route:({app:e,route:a})=>e.$api.systemRoute("system.database.search",a.params.name),updateOnRouteChange:(e,a)=>e.params.name!==a.params.name}}},meta:{page:"company",isAuthenticatedPage:!0,breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setSystem(t,a.lang.t("$vuetify.word.database.database"))}},{path:"m/:name",name:"system.mail",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{vuexNamespace:"company/system/mailDomain/overview",route:({app:e,route:a})=>e.$api.systemRoute("system.mail.domain.search",a.params.name),updateOnRouteChange:(e,a)=>e.params.name!==a.params.name}}},meta:{page:"company",isAuthenticatedPage:!0,breadcrumbs:({app:e,vuetify:a,route:t})=>e.$breadcrumbs.setSystem(t,a.lang.t("$vuetify.word.mail.domain"))}}],O={template:"<router-view></router-view>"},de=[{path:"/switcher",component:()=>o(()=>import("./c6a1bb70.js"),["assets/js/c6a1bb70.js","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/8db8b454.js","assets/css/5379cb29.css","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/f405985a.js","assets/js/bf7aa835.js","assets/css/1047aac8.css","assets/js/199060bd.js","assets/js/9c35b307.js","assets/js/f4c9f400.js","assets/css/3be72a03.css","assets/js/dfc93a5e.js","assets/js/8df457ab.js","assets/js/419d1667.js","assets/css/c961c359.css","assets/js/4b49aa8e.js","assets/css/029efb8b.css","assets/js/81c97ad2.js","assets/css/f5d19e07.css","assets/js/7f872bef.js","assets/js/95dd51c2.js","assets/js/4c8845d6.js","assets/js/51c71445.js","assets/js/712cfcfd.js","assets/css/1f7b26d7.css","assets/js/9ac5599c.js","assets/css/55f96b45.css","assets/js/e05367ee.js","assets/js/26688549.js","assets/js/76f91a17.js","assets/js/d0d927ab.js","assets/css/62c25b1f.css","assets/js/80b49b16.js","assets/js/8c1b3bb5.js","assets/css/312561be.css","assets/js/92887c0f.js","assets/js/efa8d6c3.js","assets/js/08d53163.js","assets/css/b0b5dfd6.css","assets/js/1fec3443.js","assets/js/f57264bf.js","assets/js/c395c583.js","assets/js/06f2725c.js","assets/js/bb18b195.js","assets/js/d3c7861c.js","assets/js/d9e8d07e.js","assets/css/a94ad5b0.css","assets/js/6896e886.js","assets/css/bc1291ec.css","assets/js/6ccc2df7.js","assets/js/0a70410c.js","assets/js/818f85cd.js","assets/js/80dcca67.js","assets/css/4d5af27d.css","assets/js/7d2f04f0.js","assets/js/87fe7e0c.js","assets/js/12090a70.js","assets/css/b0585eea.css","assets/js/bca9cab1.js","assets/js/460034c3.js","assets/css/e89f2dca.css","assets/js/96c5e212.js","assets/css/c4cf8052.css","assets/js/b5c144e7.js","assets/css/44e3c463.css","assets/js/456346a0.js","assets/css/ddf5ea89.css","assets/js/3a43f35c.js","assets/css/70d8eb6d.css","assets/js/0f1ce05e.js"]),children:[{path:"/switcher",name:"switcher",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),props:{value:{data:{vuexNamespace:"switcher",route:({app:e})=>e.$api.route("company.switcher.overview")}}}},{path:"*",redirect:{name:"switcher"}}]},{path:"/:companyName",component:()=>o(()=>import("./a00e005c.js"),["assets/js/a00e005c.js","assets/css/fe9dadf1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/8db8b454.js","assets/css/5379cb29.css","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/75131b1e.js","assets/js/f405985a.js","assets/js/bf7aa835.js","assets/css/1047aac8.css","assets/js/199060bd.js","assets/js/9c35b307.js","assets/js/f4c9f400.js","assets/css/3be72a03.css","assets/js/dfc93a5e.js","assets/js/8df457ab.js","assets/js/419d1667.js","assets/css/c961c359.css","assets/js/4b49aa8e.js","assets/css/029efb8b.css","assets/js/81c97ad2.js","assets/css/f5d19e07.css","assets/js/7f872bef.js","assets/js/95dd51c2.js","assets/js/4c8845d6.js","assets/js/51c71445.js","assets/js/712cfcfd.js","assets/css/1f7b26d7.css","assets/js/9ac5599c.js","assets/css/55f96b45.css","assets/js/e05367ee.js","assets/js/26688549.js","assets/js/76f91a17.js","assets/js/d0d927ab.js","assets/css/62c25b1f.css","assets/js/80b49b16.js","assets/js/8c1b3bb5.js","assets/css/312561be.css","assets/js/92887c0f.js","assets/js/efa8d6c3.js","assets/js/08d53163.js","assets/css/b0b5dfd6.css","assets/js/1fec3443.js","assets/js/f57264bf.js","assets/js/c395c583.js","assets/js/06f2725c.js","assets/js/bb18b195.js","assets/js/456346a0.js","assets/css/ddf5ea89.css","assets/js/d3c7861c.js","assets/js/d9e8d07e.js","assets/css/a94ad5b0.css","assets/js/6896e886.js","assets/css/bc1291ec.css","assets/js/6ccc2df7.js","assets/js/0a70410c.js","assets/js/818f85cd.js","assets/js/80dcca67.js","assets/css/4d5af27d.css","assets/js/7d2f04f0.js","assets/js/87fe7e0c.js","assets/js/12090a70.js","assets/css/b0585eea.css","assets/js/bca9cab1.js","assets/js/460034c3.js","assets/css/e89f2dca.css","assets/js/96c5e212.js","assets/css/c4cf8052.css","assets/js/b5c144e7.js","assets/css/44e3c463.css","assets/js/e4ac145d.js","assets/js/0f1ce05e.js","assets/js/9ceb43aa.js","assets/js/fce81ff4.js","assets/css/726b8e9b.css","assets/js/3a43f35c.js","assets/css/70d8eb6d.css"]),props:{load:e=>e.$store.dispatch("initialize",e.$route.params.companyName)},children:[{path:"/:companyName",name:"dashboard",component:()=>o(()=>import("./0460b287.js"),["assets/js/0460b287.js","assets/js/627c4e78.js","assets/css/025f49a1.css","assets/js/feafbc55.js","assets/css/fe568582.css","assets/js/75131b1e.js","assets/js/a0bb82aa.js"]),meta:{page:"company",breadcrumbs:({app:e,route:a})=>{e.$breadcrumbs.setDashboard(a)}}},{path:"cms/:cmsName/table/:tableName",component:()=>o(()=>import("./8dba943a.js"),["assets/js/8dba943a.js","assets/js/75131b1e.js"]),children:oe},{path:"system",component:O,children:ne},{path:"admin",component:O,children:me},{path:"*",redirect:e=>({name:"dashboard",params:{companyName:e.params.companyName}})}]},{path:"*",redirect:{name:"switcher"}}];n.use(C);const V=new C({mode:"history",routes:de});var h;class ie extends B{constructor(t,s){super(t);E(this,h,void 0);I(this,h,s)}companyRoute(t,...s){const r=u(this,h).getters.id;return this.route(t,r,...s)}systemRoute(t,...s){const r=u(this,h).getters.systemId;return this.route(t,r,...s)}}h=new WeakMap;var c;class ce extends F{constructor(t,s,r,d){super(t,s,r,d);E(this,c,void 0);I(this,c,d)}setDashboard(t,s=!1){const r=t.params.companyName;return this.add(new m(u(this,c).lang.t("$vuetify.word.dashboard"),s?{name:"dashboard",params:{companyName:r}}:void 0))}setCms(t){return this.setDashboard(t,!0).add(new m(u(this,c).lang.t("$vuetify.word.cms"))).add(new m(t.params.cmsName)).add(new m(u(this,c).lang.t("$vuetify.word.table"))).add(new m(t.params.tableName))}setSystem(t,s){return this.setDashboard(t,!0).add(new m(u(this,c).lang.t("$vuetify.word.system.system"))).add(new m(s)).add(new m(t.params.name))}setAdmin(t){return this.setDashboard(t,!0).add(new m(u(this,c).lang.t("$vuetify.word.admin")))}}c=new WeakMap;n.use(H,{store:L,router:V,vuetify:S.framework,loader:({app:e,store:a,router:t,vuetify:s})=>{e.$api=new ie(e,a),e.$auth=new M(a),e.$state=new K(t),e.$loader=new Q(e,a,t,s),e.$breadcrumbs=new ce(e,a,t,s)}});n.config.productionTip=!1;new n({name:"Company",store:L,router:V,vuetify:S,components:{CompanyLayout:()=>o(()=>import("./040ea0f7.js"),["assets/js/040ea0f7.js","assets/js/75131b1e.js"])}}).$mount("#mount");
