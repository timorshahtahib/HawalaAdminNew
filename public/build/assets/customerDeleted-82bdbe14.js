import{_ as x,L as w,a as u,c as C,w as _,r as d,o as n,b as h,d as t,g as L,v as D,h as l,F as g,l as p,i as B,t as c,k as v,n as b}from"../js/app2.js";import{P as F}from"./page-header-48f5a59e.js";import{S as N}from"./sweetalert2.all-8f9540fb.js";import{L as V}from"./loader-7b01d283.js";const j={components:{Layout:w,PageHeader:F,Loader:V},data(){return{title:"لیست مشتریان حذف شده",items:[{text:"مشتری",href:"/"},{text:"مشتری",active:!0}],isLoading:!1,showModal:!1,searchQuery:"",customers:[],notFound:!1,limit:10,currentPage:1,totalPages:0}},mounted(){this.getCustomers()},methods:{showalert(a,s,i){N.fire({title:a,icon:s,confirmButtonText:i})},async activeCustomer(a){if(window.confirm("آیا میخواهید که مشتری برگشت داده شود؟"))try{(await u.post("/activecustomer",{id:a})).status===200&&(this.showalert("مشتری با موفقیت برگشت داده شد!","success","بستن"),this.getCustomers())}catch{this.showalert("مشتری با موفقیت برگشت داده نشد!","error","خطا")}else return},async getCustomers(a=1){var s;this.isLoading=!0;try{const i=await u.get(`/deletedcustomer?page=${a}&limit=${this.limit}`);this.customers=i.data.customers.data,this.totalPages=(s=i.data.customers)==null?void 0:s.last_page,this.currentPage=a}catch(i){console.error("Error fetching customers:",i)}finally{this.isLoading=!1}},prevPage(){this.currentPage>1&&this.getCustomers(this.currentPage-1)},nextPage(){this.currentPage<this.totalPages&&this.getCustomers(this.currentPage+1)},async searchData(){try{const a=await u.post("/searchdeletedcustomer",{query:this.searchQuery});this.customers=a.data,this.notFound=this.customers.length===0}catch(a){console.log(a.message)}}}},Q={class:"row"},z={class:"col-12"},H={class:"card h-100",style:{"min-height":"100vh"}},S={class:"card-body"},T={class:"row mb-2"},E={class:"col-sm-4 bg-red",style:{"margin-top":"-2px"}},M={class:"search-box me-2 mb-2 d-inline-block"},q={class:"position-relative"},I=t("i",{class:"bx bx-search-alt search-icon"},null,-1),U={key:0},A={key:1,class:"table-responsive"},G={class:"table table-centered table-nowrap"},J=t("thead",null,[t("tr",null,[t("th",null,"آیدی"),t("th",null,"نام کامل"),t("th",null,"شماره مسلسل مشتری"),t("th",null,"شماره تماس"),t("th",null,"توضیحات"),t("th",null,"پروفایل کاربر"),t("th",null,"وضیعت"),t("th",null,"تغیر وضعیت")])],-1),K=t("i",{class:"mdi mdi-star me-1"},null,-1),O=["onClick"],R={key:0,class:"text-center font-size-20"},W={class:"pagination pagination-rounded justify-content-center mb-2",style:{}},X={class:"page-item"},Y=["disabled"],Z=t("i",{class:"mdi mdi-chevron-left"},null,-1),$=[Z],tt={class:"page-link",href:"javascript: void(0);"},et={class:"page-item"},st=["disabled"],ot=t("i",{class:"mdi mdi-chevron-right"},null,-1),at=[ot];function nt(a,s,i,it,o,r){const f=d("PageHeader"),y=d("Loader"),P=d("router-link"),k=d("Layout");return n(),C(k,null,{default:_(()=>[h(f,{title:o.title,items:o.items},null,8,["title","items"]),t("div",Q,[t("div",z,[t("div",H,[t("div",S,[t("div",T,[t("div",E,[t("div",M,[t("div",q,[L(t("input",{type:"text",class:"form-control","onUpdate:modelValue":s[0]||(s[0]=e=>o.searchQuery=e),placeholder:"جستجوی مشتری...",onInput:s[1]||(s[1]=(...e)=>r.searchData&&r.searchData(...e))},null,544),[[D,o.searchQuery]]),I])])])]),o.isLoading?(n(),l("div",U,[h(y)])):(n(),l("div",A,[t("table",G,[J,t("tbody",null,[(n(!0),l(g,null,p(o.customers,e=>(n(),l("tr",{key:e.id,style:{}},[t("td",null,c(e.id),1),t("td",null,c(e.name),1),t("td",null,c(e.cu_number),1),t("td",null,c(e.phone),1),t("td",null,c(e.desc),1),t("td",null,[h(P,{class:"btn btn-sm btn-primary",to:`/dashboard/customer/${e.id}`},{default:_(()=>[v("پروفایل")]),_:2},1032,["to"])]),t("td",null,[t("span",{class:b(["badge font-size-12",e.status===0?"bg-danger":"bg-primary"])},[K,v(" "+c(e.status),1)],2)]),t("td",null,[t("button",{class:"btn btn-sm btn-success",onClick:m=>r.activeCustomer(e.id)},"فعال کردن",8,O)])]))),128))])]),o.notFound?(n(),l("div",R," نتیجه مورد نظر یافت نشد! ")):B("",!0),t("ul",W,[t("li",X,[t("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Previous",onClick:s[2]||(s[2]=(...e)=>r.prevPage&&r.prevPage(...e)),disabled:o.currentPage===1},$,8,Y)]),(n(!0),l(g,null,p(o.totalPages,(e,m)=>(n(),l("li",{class:b(["page-item",{active:e===o.currentPage}]),key:m},[t("a",tt,c(e),1)],2))),128)),t("li",et,[t("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Next",onClick:s[3]||(s[3]=(...e)=>r.nextPage&&r.nextPage(...e)),disabled:o.currentPage===o.totalPages},at,8,st)])])]))])])])])]),_:1})}const ut=x(j,[["render",nt]]);export{ut as default};