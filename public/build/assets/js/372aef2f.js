import{D as n}from"./0b25b3ba.js";import{F as p,_ as m}from"./69b26093.js";import{n as l}from"./75131b1e.js";import"./34f6096b.js";import"./26138231.js";import"./e63a8b3a.js";import"./12a8f78c.js";import"./6bf1d304.js";import"./dcc38a7c.js";import"./4dd2df00.js";import"./4e01a737.js";import"./25bd67b4.js";import"./6dc30b97.js";import"./cb27d9ce.js";import"./12d57222.js";import"./1eabc0bb.js";import"./8f2da257.js";import"./002c896d.js";import"./f6b2f76e.js";import"./fe993f4a.js";import"./887f6627.js";import"./bda96ba9.js";import"./42aaffeb.js";import"./4516f3b3.js";import"./905d948c.js";import"./e8ba8097.js";import"./57b36955.js";import"./517420cd.js";import"./ab36a8de.js";import"./1b9ea462.js";import"./f57264bf.js";import"./068f7ff1.js";import"./2610d196.js";import"./0a0e57c8.js";import"./69c0631b.js";import"./c8f02950.js";import"./0f1ce05e.js";import"./aeff811c.js";import"./f03d37af.js";import"./209703eb.js";import"./40b96a79.js";import"./f55d25f8.js";function d(r){return{namespaced:!0,state:()=>({queue:[],coordinates:{}}),getters:{file(e){return e.queue.at(0)},coordinates(e){return e.coordinates}},mutations:{add(e,t){e.queue.push(t),r.modalCallback.call(this,!0)},setCoordinates(e,t){e.coordinates=t},remove(e){e.coordinates={},e.queue.splice(0,1),r.modalCallback.call(this,e.queue.length>0)}},actions:{cancel({commit:e}){e("remove")},save({commit:e,getters:t}){r.uploaderCallback.call(this,t.file,t.coordinates).then(()=>{e("remove")})}}}}const c={name:"ImageInput",components:{Dialog:n},extends:p,data(){return{dialog:this.value.data.dialog,vuexCropperNamespace:this.value.data.vuexCropperNamespace}},created(){this.$store.hasModule(this.getPath())||this.$store.registerModule(this.getPath(),d({modalCallback:r=>this.dialog.data.show=r,uploaderCallback:(r,{width:e,height:t,left:a,top:i})=>{const o=this.createFormData(r),s=this.createProgress(r.size);return o.append("width",e),o.append("height",t),o.append("left",a),o.append("top",i),this.uploader(o,s)}}))},beforeDestroy(){this.$store.unregisterModule(this.getPath())},methods:{getPath(){return this.vuexCropperNamespace.split("/")},handler(r){const e=`${this.vuexCropperNamespace}/add`;r instanceof Array?r.forEach(t=>{this.files.length<this.max&&this.$store.commit(e,t)}):this.$store.commit(e,r)}}};var u=function(){var e=this,t=e._self._c;return t("div",[t(m,e._b({class:[{"v-input-hidden":!e.isHidden},e.component.attributes.class],attrs:{clearable:!1,disabled:e.isDisabled||e.files.length>=e.max,label:e.component.content.label,"error-messages":e.errorMessages,error:e.component.data.error&&e.error,"hide-details":e.hideDetails},on:{change:e.handler},scopedSlots:e._u([{key:"selection",fn:function({index:a}){return[a===0?t("span",{staticClass:"text--secondary"},[e._v(" "+e._s(e.component.attributes.placeholder)+" ")]):e._e()]}}])},"v-file-input",e.component.attributes,!1)),t("files",{attrs:{max:e.max,files:e.files,"is-disabled":e.isDisabled},on:{remove:e.remove}}),t("Dialog",{attrs:{value:e.dialog}})],1)},h=[],f=l(c,u,h,!1,null,null,null,null);const ae=f.exports;export{ae as default};