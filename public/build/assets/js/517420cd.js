import{V as i,k as u}from"./12a8f78c.js";function n(r,e){return()=>u(`The ${r} component must be used inside a ${e}`)}function a(r,e,t){const s=e&&t?{register:n(e,t),unregister:n(e,t)}:null;return i.extend({name:"registrable-inject",inject:{[r]:{default:s}}})}function g(r,e=!1){return i.extend({name:"registrable-provide",provide(){return{[r]:e?this:{register:this.register,unregister:this.unregister}}}})}export{a as i,g as p};
