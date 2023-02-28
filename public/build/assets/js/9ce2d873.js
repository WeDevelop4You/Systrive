import{_ as n}from"./e83c81e5.js";import{_ as s}from"./2de5bdf0.js";import{o as a}from"./12a8f78c.js";const c=n.extend({name:"v-combobox",props:{delimiters:{type:Array,default:()=>[]},returnObject:{type:Boolean,default:!0}},data:()=>({editingIndex:-1}),computed:{computedCounterValue(){return this.multiple?this.selectedItems.length:(this.internalSearch||"").toString().length},hasSlot(){return s.options.computed.hasSlot.call(this)||this.multiple},isAnyValueAllowed(){return!0},menuCanShow(){return this.isFocused?this.hasDisplayedItems||!!this.$slots["no-data"]&&!this.hideNoData:!1},searchIsDirty(){return this.internalSearch!=null}},methods:{onInternalSearchChanged(t){if(t&&this.multiple&&this.delimiters.length){const e=this.delimiters.find(i=>t.endsWith(i));e!=null&&(this.internalSearch=t.slice(0,t.length-e.length),this.updateTags())}this.updateMenuDimensions()},genInput(){const t=n.options.methods.genInput.call(this);return delete t.data.attrs.name,t.data.on.paste=this.onPaste,t},genChipSelection(t,e){const i=s.options.methods.genChipSelection.call(this,t,e);return this.multiple&&(i.componentOptions.listeners={...i.componentOptions.listeners,dblclick:()=>{this.editingIndex=e,this.internalSearch=this.getText(t),this.selectedIndex=-1}}),i},onChipInput(t){s.options.methods.onChipInput.call(this,t),this.editingIndex=-1},onEnterDown(t){t.preventDefault(),!(this.getMenuIndex()>-1)&&this.$nextTick(this.updateSelf)},onKeyDown(t){const e=t.keyCode;(t.ctrlKey||![a.home,a.end].includes(e))&&s.options.methods.onKeyDown.call(this,t),this.multiple&&e===a.left&&this.$refs.input.selectionStart===0?this.updateSelf():e===a.enter&&this.onEnterDown(t),this.changeSelectedIndex(e)},onTabDown(t){if(this.multiple&&this.internalSearch&&this.getMenuIndex()===-1)return t.preventDefault(),t.stopPropagation(),this.updateTags();n.options.methods.onTabDown.call(this,t)},selectItem(t){this.editingIndex>-1?this.updateEditing():(n.options.methods.selectItem.call(this,t),this.internalSearch&&this.multiple&&this.getText(t).toLocaleLowerCase().includes(this.internalSearch.toLocaleLowerCase())&&(this.internalSearch=null))},setSelectedItems(){this.internalValue==null||this.internalValue===""?this.selectedItems=[]:this.selectedItems=this.multiple?this.internalValue:[this.internalValue]},setValue(t){s.options.methods.setValue.call(this,t===void 0?this.internalSearch:t)},updateEditing(){const t=this.internalValue.slice(),e=this.selectedItems.findIndex(i=>this.getText(i)===this.internalSearch);if(e>-1){const i=typeof t[e]=="object"?Object.assign({},t[e]):t[e];t.splice(e,1),t.push(i)}else t[this.editingIndex]=this.internalSearch;this.setValue(t),this.editingIndex=-1,this.internalSearch=null},updateCombobox(){if(!this.searchIsDirty)return;this.internalSearch!==this.getText(this.internalValue)&&this.setValue(),(Boolean(this.$scopedSlots.selection)||this.hasChips)&&(this.internalSearch=null)},updateSelf(){this.multiple?this.updateTags():this.updateCombobox()},updateTags(){const t=this.getMenuIndex();if(t<0&&!this.searchIsDirty||!this.internalSearch)return;if(this.editingIndex>-1)return this.updateEditing();const e=this.selectedItems.findIndex(l=>this.internalSearch===this.getText(l)),i=e>-1&&typeof this.selectedItems[e]=="object"?Object.assign({},this.selectedItems[e]):this.internalSearch;if(e>-1){const l=this.internalValue.slice();l.splice(e,1),this.setValue(l)}if(t>-1)return this.internalSearch=null;this.selectItem(i),this.internalSearch=null},onPaste(t){var e;if(this.$emit("paste",t),!this.multiple||this.searchIsDirty)return;const i=(e=t.clipboardData)===null||e===void 0?void 0:e.getData("text/vnd.vuetify.autocomplete.item+plain");i&&this.findExistingIndex(i)===-1&&(t.preventDefault(),s.options.methods.selectItem.call(this,i))},clearableCallback(){this.editingIndex=-1,n.options.methods.clearableCallback.call(this)}}});export{c as _};
