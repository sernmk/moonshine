import{_ as t}from"./FieldWrapper.vue_vue_type_script_setup_true_lang.ac064b32.js";import{d,_ as n,M as p,o as l,e as f,w as m,c,B as u,z as _,g as o,t as r}from"./main.8cbcc017.js";const g=d({name:"ImageField",components:{FieldWrapper:t},props:{field:{type:Object,required:!0}}}),w=["src","alt"],b={class:"mt-2"},h={class:"text-secondary-500 block"};function k(e,B,$,y,C,v){const i=p("field-wrapper");return l(),f(i,{field:e.field},{default:m(()=>{var s,a;return[((s=e.field.preview)!=null?s:e.field.url)?(l(),c("img",u({key:0,class:"max-w-md rounded-md"},e.field.attributes,{src:(a=e.field.preview)!=null?a:e.field.url,alt:e.field.image_label,class:e.field.class}),null,16,w)):_("",!0),o("p",b,r(e.field.image_label),1),o("small",h,r(e.field.url),1)]}),_:1},8,["field"])}const N=n(g,[["render",k]]);export{N as default};
