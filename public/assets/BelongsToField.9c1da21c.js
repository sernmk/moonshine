import{d as r,M as a,o as l,e as s,t as u,u as c}from"./main.8cbcc017.js";const p=r({__name:"BelongsToField",props:{field:null},setup(e){var t;const n=(t=e.field.formatted_value)!=null?t:"-";return(d,m)=>{const o=a("router-link");return l(),s(o,{to:{name:"show",params:{resourceName:e.field.resource,resourceId:e.field.value.value}},class:"underline text-brand",textContent:u(c(n))},null,8,["to","textContent"])}}});export{p as default};
