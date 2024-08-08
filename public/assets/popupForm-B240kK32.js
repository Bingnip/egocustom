import{e as I,p as F,an as P,v as q,r as z,m as d,X as c,o as n,O as m,P as r,_ as b,h as B,V as y,U as _,w as e,k as v,j as V,l as i,$ as L,a8 as N,W}from"./vue-BCHllEKp.js";import{F as s}from"./index-DLwMuYHJ.js";import{b as p}from"./validate-2fAm1QvC.js";import{e as $,am as j,an as E,at as K,_ as A}from"./index-RQ4lM9ZM.js";import"./index-DVPej9LR.js";import"./index-BzevwW1R.js";const O={class:"title"},X=I({__name:"popupForm",setup(G){const g=$(),u=F(),t=P("baTable"),{t:a}=q.useI18n(),h=z({name:[p({name:"required",title:a("security.dataRecycle.Rule name")})],controller:[p({name:"required",trigger:"change",message:a("Please select field",{field:a("security.dataRecycle.controller")})})],data_table:[p({name:"required",trigger:"change",message:a("Please select field",{field:a("security.dataRecycle.data sheet")})})],primary_key:[p({name:"required",trigger:"change",title:a("security.dataRecycle.Data table primary key")})]}),R=()=>{t.form.items.data_table&&K(t.form.items.data_table,t.form.items.connection).then(f=>{t.form.items.primary_key=f.data.pk,t.form.defaultItems.primary_key=f.data.pk})};return(f,o)=>{const C=d("el-form"),x=d("el-scrollbar"),k=d("el-button"),U=d("el-dialog"),w=c("drag"),D=c("zoom"),S=c("loading"),T=c("blur");return n(),m(U,{class:"ba-operate-dialog","close-on-click-modal":!1,"model-value":["Add","Edit"].includes(e(t).form.operate),onClose:e(t).toggleForm},{header:r(()=>[b((n(),B("div",O,[y(_(e(t).form.operate?e(a)(e(t).form.operate):""),1)])),[[w,[".ba-operate-dialog",".el-dialog__header"]],[D,".ba-operate-dialog"]])]),footer:r(()=>[v("div",{style:V("width: calc(100% - "+e(t).form.labelWidth/1.8+"px)")},[i(k,{onClick:o[7]||(o[7]=l=>e(t).toggleForm(""))},{default:r(()=>[y(_(e(a)("Cancel")),1)]),_:1}),b((n(),m(k,{loading:e(t).form.submitLoading,onClick:o[8]||(o[8]=l=>e(t).onSubmit(u.value)),type:"primary"},{default:r(()=>[y(_(e(t).form.operateIds&&e(t).form.operateIds.length>1?e(a)("Save and edit next item"):e(a)("Save")),1)]),_:1},8,["loading"])),[[T]])],4)]),default:r(()=>[b((n(),m(x,{class:"ba-table-form-scrollbar"},{default:r(()=>[v("div",{class:L(["ba-operate-form","ba-"+e(t).form.operate+"-form"]),style:V(e(g).layout.shrink?"":"width: calc(100% - "+e(t).form.labelWidth/2+"px)")},[e(t).form.loading?W("",!0):(n(),m(C,{key:0,ref_key:"formRef",ref:u,onKeyup:o[6]||(o[6]=N(l=>e(t).onSubmit(u.value),["enter"])),model:e(t).form.items,"label-position":e(g).layout.shrink?"top":"right","label-width":e(t).form.labelWidth+"px",rules:h},{default:r(()=>[i(s,{label:e(a)("security.dataRecycle.Rule name"),type:"string",modelValue:e(t).form.items.name,"onUpdate:modelValue":o[0]||(o[0]=l=>e(t).form.items.name=l),prop:"name",placeholder:e(a)("security.dataRecycle.The rule name helps to identify deleted data later")},null,8,["label","modelValue","placeholder"]),i(s,{label:e(a)("security.dataRecycle.controller"),type:"select",modelValue:e(t).form.items.controller,"onUpdate:modelValue":o[1]||(o[1]=l=>e(t).form.items.controller=l),prop:"controller","input-attr":{content:e(t).form.extend.controllerList},placeholder:e(a)("security.dataRecycle.The data collection mechanism will monitor delete operations under this controller")},null,8,["label","modelValue","input-attr","placeholder"]),i(s,{label:e(a)("Database connection"),modelValue:e(t).form.items.connection,"onUpdate:modelValue":o[2]||(o[2]=l=>e(t).form.items.connection=l),type:"remoteSelect","block-help":e(a)("Database connection help"),"input-attr":{pk:"key",field:"key",remoteUrl:e(j)}},null,8,["label","modelValue","block-help","input-attr"]),(n(),m(s,{label:e(a)("security.dataRecycle.Corresponding data sheet"),type:"remoteSelect",modelValue:e(t).form.items.data_table,"onUpdate:modelValue":o[3]||(o[3]=l=>e(t).form.items.data_table=l),key:e(t).form.items.connection,"input-attr":{pk:"table",field:"comment",params:{connection:e(t).form.items.connection,samePrefix:1,excludeTable:["area","token","captcha","admin_group_access","user_money_log","user_score_log"]},remoteUrl:e(E),onRow:R},prop:"data_table"},null,8,["label","modelValue","input-attr"])),i(s,{label:e(a)("security.dataRecycle.Data table primary key"),type:"string",modelValue:e(t).form.items.primary_key,"onUpdate:modelValue":o[4]||(o[4]=l=>e(t).form.items.primary_key=l),prop:"primary_key"},null,8,["label","modelValue"]),i(s,{label:e(a)("State"),type:"radio",modelValue:e(t).form.items.status,"onUpdate:modelValue":o[5]||(o[5]=l=>e(t).form.items.status=l),prop:"status","input-attr":{border:!0,content:{0:e(a)("Disable"),1:e(a)("Enable")}}},null,8,["label","modelValue","input-attr"])]),_:1},8,["model","label-position","label-width","rules"]))],6)]),_:1})),[[S,e(t).form.loading]])]),_:1},8,["model-value","onClose"])}}}),ee=A(X,[["__scopeId","data-v-3fdedc10"]]);export{ee as default};
