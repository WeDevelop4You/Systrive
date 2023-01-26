import{F as g}from"./11811950.js";import{n as y}from"./75131b1e.js";import"./feafbc55.js";import"./dfc93a5e.js";import"./f55d25f8.js";var b=["onActivate","onAddUndo","onBeforeAddUndo","onBeforeExecCommand","onBeforeGetContent","onBeforeRenderUI","onBeforeSetContent","onBeforePaste","onBlur","onChange","onClearUndos","onClick","onContextMenu","onCopy","onCut","onDblclick","onDeactivate","onDirty","onDrag","onDragDrop","onDragEnd","onDragGesture","onDragOver","onDrop","onExecCommand","onFocus","onFocusIn","onFocusOut","onGetContent","onHide","onInit","onKeyDown","onKeyPress","onKeyUp","onLoadContent","onMouseDown","onMouseEnter","onMouseLeave","onMouseMove","onMouseOut","onMouseOver","onMouseUp","onNodeChange","onObjectResizeStart","onObjectResized","onObjectSelected","onPaste","onPostProcess","onPostRender","onPreProcess","onProgressState","onRedo","onRemove","onReset","onSaveContent","onSelectionChange","onSetAttrib","onSetContent","onShow","onSubmit","onUndo","onVisualAid"],$=function(e){return b.map(function(t){return t.toLowerCase()}).indexOf(e.toLowerCase())!==-1},C=function(e,t,n){Object.keys(t).filter($).forEach(function(i){var o=t[i];typeof o=="function"&&(i==="onInit"?o(e,n):n.on(i.substring(2),function(r){return o(r,n)}))})},S=function(e,t){var n=e.$props.modelEvents?e.$props.modelEvents:null,i=Array.isArray(n)?n.join(" "):n;t.on(i||"change input undo redo",function(){e.$emit("input",t.getContent({format:e.$props.outputFormat}))})},w=function(e,t,n){var i=t.$props.value?t.$props.value:"",o=t.$props.initialValue?t.$props.initialValue:"";n.setContent(i||(t.initialized?t.cache:o)),t.$watch("value",function(r,s){n&&typeof r=="string"&&r!==s&&r!==n.getContent({format:t.$props.outputFormat})&&n.setContent(r)}),t.$listeners.input&&S(t,n),C(e,t.$listeners,n),t.initialized=!0},f=0,h=function(e){var t=Date.now(),n=Math.floor(Math.random()*1e9);return f++,e+"_"+n+f+String(t)},E=function(e){return e!==null&&e.tagName.toLowerCase()==="textarea"},m=function(e){return typeof e>"u"||e===""?[]:Array.isArray(e)?e:e.split(" ")},k=function(e,t){return m(e).concat(m(t))},_=function(e){return e==null},v=function(){return{listeners:[],scriptId:h("tiny-script"),scriptLoaded:!1}},D=function(){var e=v(),t=function(o,r,s,c){var a=r.createElement("script");a.referrerPolicy="origin",a.type="application/javascript",a.id=o,a.src=s;var p=function(){a.removeEventListener("load",p),c()};a.addEventListener("load",p),r.head&&r.head.appendChild(a)},n=function(o,r,s){e.scriptLoaded?s():(e.listeners.push(s),o.getElementById(e.scriptId)||t(e.scriptId,o,r,function(){e.listeners.forEach(function(c){return c()}),e.scriptLoaded=!0}))},i=function(){e=v()};return{load:n,reinitialize:i}},I=D(),A=function(){return typeof window<"u"?window:global},l=function(){var e=A();return e&&e.tinymce?e.tinymce:null},z={apiKey:String,cloudChannel:String,id:String,init:Object,initialValue:String,inline:Boolean,modelEvents:[String,Array],plugins:[String,Array],tagName:String,toolbar:[String,Array],value:String,disabled:Boolean,tinymceScriptSrc:String,outputFormat:{type:String,validator:function(e){return e==="html"||e==="text"}}},u=globalThis&&globalThis.__assign||function(){return u=Object.assign||function(e){for(var t,n=1,i=arguments.length;n<i;n++){t=arguments[n];for(var o in t)Object.prototype.hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e},u.apply(this,arguments)},O=function(e,t,n){return e(n||"div",{attrs:{id:t}})},P=function(e,t){return e("textarea",{attrs:{id:t},style:{visibility:"hidden"}})},d=function(e){return function(){var t=u(u({},e.$props.init),{readonly:e.$props.disabled,selector:"#"+e.elementId,plugins:k(e.$props.init&&e.$props.init.plugins,e.$props.plugins),toolbar:e.$props.toolbar||e.$props.init&&e.$props.init.toolbar,inline:e.inlineEditor,setup:function(n){e.editor=n,n.on("init",function(i){return w(i,e,n)}),e.$props.init&&typeof e.$props.init.setup=="function"&&e.$props.init.setup(n)}});E(e.element)&&(e.element.style.visibility="",e.element.style.display=""),l().init(t)}},j={props:z,created:function(){this.elementId=this.$props.id||h("tiny-vue"),this.inlineEditor=this.$props.init&&this.$props.init.inline||this.$props.inline,this.initialized=!1},watch:{disabled:function(){this.editor.setMode(this.disabled?"readonly":"design")}},mounted:function(){if(this.element=this.$el,l()!==null)d(this)();else if(this.element&&this.element.ownerDocument){var e=this.$props.cloudChannel?this.$props.cloudChannel:"5",t=this.$props.apiKey?this.$props.apiKey:"no-api-key",n=_(this.$props.tinymceScriptSrc)?"https://cdn.tiny.cloud/1/"+t+"/tinymce/"+e+"/tinymce.min.js":this.$props.tinymceScriptSrc;I.load(this.element.ownerDocument,n,d(this))}},beforeDestroy:function(){l()!==null&&l().remove(this.editor)},deactivated:function(){var e;this.inlineEditor||(this.cache=this.editor.getContent(),(e=l())===null||e===void 0||e.remove(this.editor))},activated:function(){!this.inlineEditor&&this.initialized&&d(this)()},render:function(e){return this.inlineEditor?O(e,this.elementId,this.$props.tagName):P(e,this.elementId)}};const M={name:"RichTextareaInput",components:{Editor:j},extends:g,data(){return{isActive:!1,options:{statusbar:!1,min_height:500,plugins:"lists advlist image link table fullscreen help searchreplace charmap emoticons autolink anchor autoresize",toolbar:["undo redo | blocks fontsize anchor | numlist bullist | outdent indent | fullscreen","pastetext removeformat | bold italic strikethrough subscript superscript | forecolor backcolor | alignleft aligncenter alignright alignjustify | lineheight | link charmap table emoticons"],menu:{file:{title:"File",items:"newdocument restoredraft | preview | export print | deleteallconversations"},edit:{title:"Edit",items:"undo redo | cut copy paste pastetext | selectall | searchreplace"},view:{title:"View",items:"code | visualaid visualchars visualblocks | spellchecker | preview fullscreen | showcomments"},insert:{title:"Insert",items:"image link media addcomment pageembed template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor tableofcontents | insertdatetime"},format:{title:"Format",items:"bold italic underline strikethrough superscript subscript codeformat | styles blocks fontsize align lineheight | forecolor backcolor | language | removeformat"},table:{title:"Table",items:"inserttable | cell row column | advtablesort | tableprops deletetable"},help:{title:"Help",items:"help"}},help_tabs:["shortcuts","keyboardnav"],skin_url:"/build/assets/css/tinymce"}}},watch:{"$vuetify.theme.dark"(){this.setDefaultColor()}},methods:{active(e){this.isActive=e.type==="focus"},setDefaultColor(){const e=this.$vuetify.theme.dark?"#fff":"#000",t=this.$el.querySelector("iframe");t.contentDocument.documentElement.style.color=e}}};var L=function(){var t=this,n=t._self._c;return n("div",{directives:[{name:"show",rawName:"v-show",value:t.isHidden,expression:"isHidden"}],class:{active:t.isActive}},[n("editor",{attrs:{init:t.options,disabled:t.component.attributes.readonly,"initial-value":t.input,"cloud-channel":"6","model-events":"change keydown blur paste","api-key":"4mucpk15n7x2rj2rvd1s4hi4rtoilzvknnv52ts7tclhl0i3"},on:{input:function(i){return t.setValue(i)},onblur:t.active,onfocus:t.active,onInit:t.setDefaultColor}})],1)},B=[],F=y(M,L,B,!1,null,null,null,null);const H=F.exports;export{H as default};
