import{b as u,d as m,T as b,a as y}from"./index-DVPej9LR.js";import{c as f,a6 as h}from"./index-RQ4lM9ZM.js";import g from"./popupForm-B240kK32.js";import{e as _,v as R,p as n,as as k,z,m as I,o as s,h as E,w as t,O as w,W as q,l as o}from"./vue-BCHllEKp.js";import"./index-BzevwW1R.js";import"./index-DLwMuYHJ.js";import"./validate-2fAm1QvC.js";const i="/admin/security.DataRecycle/";function v(){return f({url:i+"add",method:"get"})}const x={class:"default-main ba-table-box"},N=_({name:"security/dataRecycle",__name:"index",setup(C){const{t:e}=R.useI18n(),l=n(),d=n(),a=new u(new h(i),{column:[{type:"selection",align:"center",operator:!1},{label:"ID",prop:"id",align:"center",operator:"=",operatorPlaceholder:e("Id"),width:70},{label:e("security.dataRecycle.Rule name"),prop:"name",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("security.dataRecycle.controller"),prop:"controller",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("Connection"),prop:"connection",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("security.dataRecycle.data sheet"),prop:"data_table",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query")},{label:e("security.dataRecycle.Data table primary key"),prop:"primary_key",align:"center",operator:"LIKE",operatorPlaceholder:e("Fuzzy query"),width:100},{label:e("State"),prop:"status",align:"center",render:"tag",custom:{0:"danger",1:"success"},replaceValue:{0:e("Disable"),1:e("security.dataRecycle.Deleting monitoring")}},{label:e("Update time"),prop:"update_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:e("Create time"),prop:"create_time",align:"center",render:"datetime",sortable:"custom",operator:"RANGE",width:160},{label:e("Operate"),align:"center",width:"130",render:"buttons",buttons:m(["edit","delete"]),operator:!1}],dblClickNotEditColumn:[void 0,"status"]},{defaultItems:{status:"1"}},{toggleForm:({operate:r})=>{(r=="Add"||r=="Edit")&&(a.form.loading=!0,v().then(c=>{a.form.extend.controllerList=c.data.controllers,a.form.loading=!1}))}});return k("baTable",a),z(()=>{a.table.ref=l.value,a.mount(),a.getIndex()}),(r,c)=>{const p=I("el-alert");return s(),E("div",x,[t(a).table.remark?(s(),w(p,{key:0,class:"ba-table-alert",title:t(a).table.remark,type:"info","show-icon":""},null,8,["title"])):q("",!0),o(b,{buttons:["refresh","add","edit","delete","comSearch","quickSearch","columnDisplay"],"quick-search-placeholder":t(e)("Quick search placeholder",{fields:t(e)("security.dataRecycle.Rule name")})},null,8,["quick-search-placeholder"]),o(y,{ref_key:"tableRef",ref:l},null,512),o(g,{ref_key:"formRef",ref:d},null,512)])}}});export{N as default};
