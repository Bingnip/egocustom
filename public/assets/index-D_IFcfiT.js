import{b as u,d as s,T as m,a as c}from"./index-DVPej9LR.js";import p from"./popupForm-MlQsiQ9E.js";import{a6 as d}from"./index-RQ4lM9ZM.js";import{e as f,v as b,p as _,as as h,z as g,m as v,o,h as w,w as a,O as k,W as y,l}from"./vue-BCHllEKp.js";import"./index-BzevwW1R.js";import"./index-DLwMuYHJ.js";import"./validate-2fAm1QvC.js";const T={class:"default-main ba-table-box"},E=f({name:"user/rule",__name:"index",setup(x){const{t:e}=b.useI18n(),n=_(),t=new u(new d("/admin/user.Rule/"),{expandAll:!1,column:[{type:"selection",align:"center",operator:!1},{label:e("auth.rule.title"),prop:"title",align:"left",width:"200"},{label:e("auth.rule.Icon"),prop:"icon",align:"center",width:"60",render:"icon",default:"fa fa-circle-o"},{label:e("auth.rule.name"),prop:"name",align:"center",showOverflowTooltip:!0},{label:e("auth.rule.type"),prop:"type",align:"center",render:"tag",custom:{menu:"danger",menu_dir:"success",route:"info"},replaceValue:{menu:e("user.rule.Member center menu items"),menu_dir:e("user.rule.Member center menu contents"),route:e("user.rule.Normal routing"),nav:e("user.rule.Top bar menu items"),button:e("user.rule.Page button"),nav_user_menu:e("user.rule.Top bar user dropdown")}},{label:e("State"),prop:"status",align:"center",width:"80",render:"switch"},{label:e("Update time"),prop:"update_time",align:"center",width:"160",render:"datetime"},{label:e("Create time"),prop:"create_time",align:"center",width:"160",render:"datetime"},{label:e("Operate"),align:"center",width:"130",render:"buttons",buttons:s()}],dblClickNotEditColumn:[void 0,"status"]},{defaultItems:{type:"route",menu_type:"tab",extend:"none",no_login_valid:"0",keepalive:0,status:"1",icon:"fa fa-circle-o"}},{requestEdit:()=>{t.form.items&&!t.form.items.icon&&(t.form.items.icon="fa fa-circle-o")},onSubmit:()=>{t.form.items.type=="route"?t.form.items.menu_type="tab":["menu","menu_dir","nav_user_menu"].includes(t.form.items.type)&&(t.form.items.no_login_valid="0")}});return h("baTable",t),g(()=>{var r;t.table.ref=n.value,t.mount(),(r=t.getIndex())==null||r.then(()=>{t.dragSort()})}),(r,C)=>{const i=v("el-alert");return o(),w("div",T,[a(t).table.remark?(o(),k(i,{key:0,class:"ba-table-alert",title:a(t).table.remark,type:"info","show-icon":""},null,8,["title"])):y("",!0),l(m,{buttons:["refresh","add","edit","delete","unfold","quickSearch","columnDisplay"],"quick-search-placeholder":a(e)("Quick search placeholder",{fields:a(e)("auth.rule.Rule title")})},null,8,["quick-search-placeholder"]),l(c,{ref_key:"tableRef",ref:n,pagination:!1},null,512),l(p)])}}});export{E as default};
