import{m as n,T as a,M as r,E as l,C as i,B as d}from"./aec5129c.js";import{V as u}from"./bdb3efe6.js";const h=u.extend({name:"roundable",props:{rounded:[Boolean,String],tile:Boolean},computed:{roundedClasses(){const e=[],s=typeof this.rounded=="string"?String(this.rounded):this.rounded===!0;if(this.tile)e.push("rounded-0");else if(typeof s=="string"){const t=s.split(" ");for(const o of t)e.push(`rounded-${o}`)}else s&&e.push("rounded");return e.length>0?{[e.join(" ")]:!0}:{}}}}),m=n(d,i,l,r,h,a).extend({name:"v-sheet",props:{outlined:Boolean,shaped:Boolean,tag:{type:String,default:"div"}},computed:{classes(){return{"v-sheet":!0,"v-sheet--outlined":this.outlined,"v-sheet--shaped":this.shaped,...this.themeClasses,...this.elevationClasses,...this.roundedClasses}},styles(){return this.measurableStyles}},render(e){const s={class:this.classes,style:this.styles,on:this.listeners$};return e(this.tag,this.setBackgroundColor(this.color,s),this.$slots.default)}});export{h as R,m as V};