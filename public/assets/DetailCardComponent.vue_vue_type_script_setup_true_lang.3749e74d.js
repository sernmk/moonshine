import{u as d,C as y}from"./form_component.7ee52d89.js";import{d as C,o,c as a,a as w,w as u,b as _,t as f,u as l,F as s,r as c,e as i,f as m}from"./main.8cbcc017.js";const g=C({__name:"DetailCardComponent",props:{resourceKey:null,viewKey:null,viewComponentKey:null,resourceId:null},setup(p){const n=p,r=d(`${n.resourceKey}-${n.resourceId}`);return r.fetch(n.resourceKey,n.viewKey,n.viewComponentKey,n.resourceId),(K,k)=>(o(),a(s,null,[w(y,null,{title:u(()=>[_(f(l(r).title),1)]),default:u(()=>[(o(!0),a(s,null,c(l(r).nonRelationFields,e=>{var t;return o(),i(m(e.getViewComponent()),{key:`field-${(t=e.id)!=null?t:e.name}`,field:e},null,8,["field"])}),128))]),_:1}),(o(!0),a(s,null,c(l(r).relationFields,e=>{var t;return o(),i(m(e.getViewComponent()),{key:`rel-field-${(t=e.id)!=null?t:e.name}`,field:e},null,8,["field"])}),128))],64))}});export{g as _};
