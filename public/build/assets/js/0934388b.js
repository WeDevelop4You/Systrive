import{L as c}from"./e60c8e2e.js";import{n as i}from"./75131b1e.js";import{a as p}from"./14ee71cd.js";import{a as m,e as u,d as o}from"./20f47019.js";import{E as _}from"./e11e0046.js";import{C as d}from"./0d92c212.js";import{_ as f,a as r,b as a}from"./0cdfeb6c.js";import{_ as n}from"./0f69cb55.js";import{_ as g}from"./5a7554aa.js";import"./94ca7cec.js";import"./89ae458c.js";import"./53ee5cfb.js";import"./5dd91c54.js";import"./4cf2fa9d.js";import"./3bfe2d76.js";import"./64eb8a9e.js";import"./492a710f.js";import"./3b8c775f.js";import"./744bff6b.js";import"./64b64aa2.js";import"./f57264bf.js";const h={name:"LoadingImage",props:{alt:{required:!0,type:String},src:{required:!0,type:String},maxWidth:{type:[String,Number],default:""},minWidth:{type:[String,Number],default:""},maxHeight:{type:[String,Number],default:""},minHeight:{type:[String,Number],default:""},lazySrc:{type:String,default:""}}};var v=function(){var t=this,e=t._self._c;return e(p,{attrs:{alt:t.alt,src:t.src,"lazy-src":t.lazySrc,"max-width":t.maxWidth,"min-width":t.minWidth,"max-height":t.maxHeight,"min-height":t.minHeight},scopedSlots:t._u([{key:"placeholder",fn:function(){return[e(m,{staticClass:"fill-height ma-0",attrs:{align:"center",justify:"center"}},[e(u,{attrs:{indeterminate:"",color:"grey lighten-5"}})],1)]},proxy:!0}])})},y=[],x=i(h,v,y,!1,null,null,null,null);const $=x.exports,w={name:"OneTimePasswordForm",components:{LButtons:c,LoadingImage:$,ErrorMessage:_},mixins:[d],data(){return{step:1}},methods:{close(){this.$store.commit("popups/removeModal"),this.$store.commit(`${this.vuexNamespace}/resetForm`)},validate(){this.$store.dispatch("user/auth/settings/validateOneTimePassword")}}};var C=function(){var t=this,e=t._self._c;return e(f,{attrs:{vertical:"",tile:"",flat:""},model:{value:t.step,callback:function(s){t.step=s},expression:"step"}},[e(r,{attrs:{complete:t.step>1,step:"1"}},[t._v(" "+t._s(t.$vuetify.lang.t("$vuetify.word.scan.qr.code"))+" ")]),e(a,{attrs:{step:"1"}},[e("p",{domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.text.how.to.enable.2fa"))}}),e("loading-image",{staticClass:"mx-auto mb-3",attrs:{src:t.data.QRCode,alt:"2fa-qr-code","max-width":"200","max-height":"200","min-height":"200"}}),e("l-buttons",{attrs:{"no-padding":""}},[e(n,{attrs:{text:""},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.cancel.cancel"))},on:{click:t.close}}),e(n,{attrs:{color:"primary",disabled:t.$loading},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.next"))},on:{click:function(s){t.step=2}}})],1)],1),e(r,{attrs:{complete:t.step>2,step:"2"}},[t._v(" "+t._s(t.$vuetify.lang.t("$vuetify.word.check.2fa"))+" ")]),e(a,{attrs:{step:"2"}},[e(m,{attrs:{"no-gutters":""}},[e(o,{attrs:{cols:"12"}},[e("p",{staticClass:"mt-3",domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.text.check.2fa"))}})]),e(o,{attrs:{cols:"12"}},[e(g,{staticClass:"mx-auto",staticStyle:{"max-width":"275px"},on:{finish:t.validate},model:{value:t.data.oneTimePassword,callback:function(s){t.$set(t.data,"oneTimePassword",s)},expression:"data.oneTimePassword"}}),e("error-message",{attrs:{message:t.errors.one_time_password}})],1)],1),e("l-buttons",{attrs:{"no-padding":""}},[e(n,{attrs:{text:""},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.cancel.cancel"))},on:{click:function(s){t.step=1}}}),e(n,{attrs:{color:"primary",disabled:t.$loading},domProps:{textContent:t._s(t.$vuetify.lang.t("$vuetify.word.check.check"))},on:{click:t.validate}})],1)],1)],1)},b=[],P=i(w,C,b,!1,null,null,null,null);const J=P.exports;export{J as default};