import{_ as v,a as g,r as d,o as a,h as i,d as t,g as P,v as x,b as _,F as h,l as m,t as s,n as b,k,L,c as O,w}from"../js/app2.js";import{P as C}from"./page-header-48f5a59e.js";import"./sweetalert2.all-8f9540fb.js";import{L as T}from"./loader-7b01d283.js";const j={name:"acceptOrderTable",components:{Loader:T},data(){return{isLoading:!1,orders:[],searchQuery:"",currentPage:1,totalPages:1,limit:10}},mounted(){this.getOrders()},methods:{async getOrders(o=1){this.isLoading=!0;try{const l=await g.get(`/acceptedorder?page=${o}&limit=${this.limit}`);this.orders=l.data.orders.data,this.totalPages=l.data.orders.last_page,this.currentPage=o}catch(l){console.error("Error fetching orders:",l)}finally{this.isLoading=!1}},prevPage(){this.currentPage>1&&this.getOrders(this.currentPage-1)},nextPage(){this.currentPage<this.totalPages&&this.getOrders(this.currentPage+1)},async searchData(){const o=await g.post("/searchorder",{query:this.searchQuery});this.orders=o.data}}},D={class:"col-sm-4 bg-red",style:{"margin-top":"-52px"}},S={class:"search-box me-2 mb-2 d-inline-block"},z={class:"position-relative"},B=t("i",{class:"bx bx-search-alt search-icon"},null,-1),N={key:0},Q={key:1},V={key:0,class:"table-responsive"},H={class:"table table-centered table-nowrap"},q=t("thead",null,[t("tr",null,[t("th",null,"آیدی"),t("th",null,"آیدی مشتری"),t("th",null,"آیدی ترانزکشن"),t("th",null,"تاریخ سفارش"),t("th",null,"تاریخ اجرا"),t("th",null,"حالت"),t("th",null,"شماره سفارش"),t("th",null,"سیستم"),t("th",null,"شماره تماس"),t("th",null,"سب کتگوری آیدی"),t("th",null,"کیو تی تی"),t("th",null,"مقدار"),t("th",null,"مقدار نهائی"),t("th",null,"درصد مفاد"),t("th",null,"مبلغ مفاد"),t("th",null,"واحد پولی"),t("th",null,"آیدی ارز خریدار"),t("th",null,"نرخ ارز"),t("th",null,"قیمت خرید"),t("th",null,"آیدی یوزر"),t("th",null,"آیدی محصول"),t("th",null,"آیدی تامین کننده"),t("th",null,"توضیح رد شده"),t("th",null,"وضعیت"),t("th",null,"اکشن")])],-1),E={class:"badge badge-pill font-bold p-2 font-size-12 badge-soft-success"},F=t("i",{class:"mdi mdi-star me-1"},null,-1),I={class:"btn btn-xs"},M=["onClick"],U={class:"pagination pagination-rounded justify-content-center mb-2",style:{}},A={class:"page-item"},G=["disabled"],J=t("i",{class:"mdi mdi-chevron-left"},null,-1),K=[J],R={class:"page-link",href:"javascript: void(0);"},W={class:"page-item"},X=["disabled"],Y=t("i",{class:"mdi mdi-chevron-right"},null,-1),Z=[Y],$={key:1,class:"text-center font-size-20"};function tt(o,l,f,y,n,c){var r;const u=d("Loader");return a(),i(h,null,[t("div",D,[t("div",S,[t("div",z,[P(t("input",{type:"text",class:"form-control","onUpdate:modelValue":l[0]||(l[0]=e=>n.searchQuery=e),placeholder:"جستجوی مشتری...",onInput:l[1]||(l[1]=(...e)=>c.searchData&&c.searchData(...e))},null,544),[[x,n.searchQuery]]),B])])]),n.isLoading?(a(),i("div",N,[_(u)])):(a(),i("div",Q,[(r=n.orders)!=null&&r.length?(a(),i("div",V,[t("table",H,[q,t("tbody",null,[(a(!0),i(h,null,m(n.orders,e=>(a(),i("tr",{key:e.id},[t("td",null,s(e.id),1),t("td",null,s(e.customer_id),1),t("td",null,s(e.transaction_id),1),t("td",null,s(e.order_date),1),t("td",null,s(e.action_date),1),t("td",null,[t("span",E,s(e.state),1)]),t("td",null,s(e.order_number),1),t("td",null,s(e.system),1),t("td",null,s(e.phone_number),1),t("td",null,s(e.sub_category_id),1),t("td",null,s(e.qtt),1),t("td",null,s(e.amount.toLocaleString()),1),t("td",null,s(e.final_amount.toLocaleString()),1),t("td",null,s(e.profit_percentage),1),t("td",null,s(e.profit_amount.toLocaleString()),1),t("td",null,s(e.currency),1),t("td",null,s(e.buy_currency_id),1),t("td",null,s(e.currency_rate),1),t("td",null,s(e.buy_price.toLocaleString()),1),t("td",null,s(e.user_id),1),t("td",null,s(e.product_id),1),t("td",null,s(e.supplier_id),1),t("td",null,s(e.reject_disc),1),t("td",null,[t("span",{class:b(["badge font-size-12",e.status===0?"bg-warning":"bg-primary"])},[F,k(" "+s(e.status),1)],2)]),t("td",null,[t("button",I,[t("i",{class:"fas fa-trash-alt text-danger me-1",onClick:p=>o.deleteOrder(e.id)},null,8,M)])])]))),128))])]),t("ul",U,[t("li",A,[t("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Previous",onClick:l[2]||(l[2]=(...e)=>c.prevPage&&c.prevPage(...e)),disabled:n.currentPage===1},K,8,G)]),(a(!0),i(h,null,m(n.totalPages,(e,p)=>(a(),i("li",{class:b(["page-item",{active:e===n.currentPage}]),key:p},[t("a",R,s(e),1)],2))),128)),t("li",W,[t("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Next",onClick:l[3]||(l[3]=(...e)=>c.nextPage&&c.nextPage(...e)),disabled:n.currentPage===n.totalPages},Z,8,X)])])])):(a(),i("div",$," نتیجه مورد نظر یافت نشد! "))]))],64)}const et=v(j,[["render",tt]]),st={components:{Layout:L,PageHeader:C,acceptOrderTable:et},data(){return{title:" لیست سفارشات تائید شده",items:[{text:"داشبورد",href:"/"},{text:"سفارشات",active:!0}]}},methods:{}},lt={class:"row"},nt={class:"col-12"},at={class:"card",style:{"min-height":"100vh !important"}},it={class:"card-body"},ot=t("div",{class:"row mb-2"},[t("div",{class:"col-sm-4"},[t("div",{class:"search-box me-2 mb-2 d-inline-block"},[t("div",{class:"position-relative"},[t("input",{type:"text",class:"form-control",placeholder:"جستجوی سفارشات..."}),t("i",{class:"bx bx-search-alt search-icon"})])])])],-1);function ct(o,l,f,y,n,c){const u=d("PageHeader"),r=d("acceptOrderTable"),e=d("Layout");return a(),O(e,null,{default:w(()=>[_(u,{title:n.title,items:n.items},null,8,["title","items"]),t("div",lt,[t("div",nt,[t("div",at,[t("div",it,[ot,_(r)])])])])]),_:1})}const _t=v(st,[["render",ct]]);export{_t as default};
