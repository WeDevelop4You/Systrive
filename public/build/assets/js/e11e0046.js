import{n as t}from"./75131b1e.js";const r={name:"ErrorMessage",props:{message:{required:!0,type:[String,Array],default:()=>[]}},computed:{getMessage(){return Array.isArray(this.message)?this.message[0]:this.message}}};var a=function(){var e=this,s=e._self._c;return e.message.length?s("div",{staticClass:"v-text-field__details"},[s("div",{staticClass:"v-messages error--text",class:[e.$vuetify.theme.dark?"theme--dark":"theme--light"],attrs:{role:"alert"}},[s("div",{staticClass:"v-messages__wrapper"},[s("div",{staticClass:"v-messages__message",domProps:{textContent:e._s(e.getMessage)}})])])]):e._e()},n=[],i=t(r,a,n,!1,null,null,null,null);const _=i.exports;export{_ as E};
