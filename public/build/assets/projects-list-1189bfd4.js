import{L as p}from"./main-e24c86ad.js";import{P as h}from"./page-header-c6b63424.js";import{p as v}from"./data-projects-32ff7c01.js";import{_ as g,e as f,w as e,r as a,o as c,d as o,a as t,c as d,f as b,F as x,g as l,t as i,n as w,A as y}from"../js/app2.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./img-1-ff40be1b.js";import"./img-3-90578d7e.js";import"./img-5-7cb5a618.js";import"./avatar-2-22bc0be9.js";import"./avatar-5-107f5df2.js";import"./avatar-6-c6f5abaf.js";import"./avatar-8-f7755bc3.js";const L={components:{Layout:p,PageHeader:h},data(){return{projectData:v,title:"Projects List",items:[{text:"Projects",href:"/"},{text:"Projects List",active:!0}]}}},P={class:"row"},k={class:"col-lg-12"},D={class:""},$={class:"table-responsive"},j={class:"table project-list-table table-nowrap table-centered table-borderless align-middle"},z=t("thead",null,[t("tr",null,[t("th",{scope:"col",style:{width:"100px"}},"#"),t("th",{scope:"col"},"Projects"),t("th",{scope:"col"},"Due Date"),t("th",{scope:"col"},"Status"),t("th",{scope:"col"},"Team"),t("th",{scope:"col"},"Action")])],-1),C=["src"],A={class:"text-truncate font-size-14"},B={href:"javascript: void(0);",class:"text-dark"},N={class:"text-muted mb-0"},V={class:"avatar-group"},H={class:"avatar-group-item"},S={href:"javascript: void(0);",class:"d-inline-block"},F=["src"],T={key:0,class:"avatar-group-item"},E={href:"javascript: void(0);",class:"d-inline-block"},q=["src"],G=t("i",{class:"mdi mdi-dots-horizontal font-size-18"},null,-1),I=t("div",{class:"row"},[t("div",{class:"col-12"},[t("div",{class:"text-center my-3"},[t("a",{href:"javascript:void(0);",class:"text-success"},[t("i",{class:"bx bx-loader bx-spin font-size-18 align-middle mr-2"}),l(" Load more ")])])])],-1);function J(K,M,O,Q,r,R){const _=a("PageHeader"),n=a("b-dropdown-item"),m=a("b-dropdown"),u=a("Layout");return c(),f(u,null,{default:e(()=>[o(_,{title:r.title,items:r.items},null,8,["title","items"]),t("div",P,[t("div",k,[t("div",D,[t("div",$,[t("table",j,[z,t("tbody",null,[(c(!0),d(x,null,b(r.projectData,s=>(c(),d("tr",{key:s.id},[t("td",null,[t("img",{src:`${s.image}`,alt:"",class:"avatar-sm"},null,8,C)]),t("td",null,[t("h5",A,[t("a",B,i(s.text),1)]),t("p",N,i(s.subtext),1)]),t("td",null,i(s.date),1),t("td",null,[t("span",{class:w(["badge",{"bg-success":`${s.status}`=="Completed","bg-warning":`${s.status}`=="Pending","bg-danger":`${s.status}`=="Delay"}])},i(s.status),3)]),t("td",null,[t("div",V,[t("div",H,[t("a",S,[t("img",{src:`${s.users[0]}`,class:"rounded-circle avatar-xs",alt:""},null,8,F)])]),s.users[1]?(c(),d("div",T,[t("a",E,[t("img",{src:`${s.users[1]}`,class:"rounded-circle avatar-xs",alt:""},null,8,q)])])):y("",!0)])]),t("td",null,[o(m,{class:"card-drop",variant:"white",right:"","toggle-class":"p-0","menu-class":"dropdown-menu-end"},{"button-content":e(()=>[G]),default:e(()=>[o(n,{href:"javascript: void(0);"},{default:e(()=>[l("Action")]),_:1}),o(n,{href:"javascript: void(0);"},{default:e(()=>[l("Another action")]),_:1}),o(n,{href:"javascript: void(0);"},{default:e(()=>[l("Something else here")]),_:1})]),_:1})])]))),128))])])])])])]),I]),_:1})}const nt=g(L,[["render",J]]);export{nt as default};
