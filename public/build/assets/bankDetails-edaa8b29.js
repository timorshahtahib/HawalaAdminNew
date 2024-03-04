import{_ as C,L,a as i,c as S,w as T,r as u,o as r,b as h,d as e,g as y,j as M,v as q,h as c,F as f,l as v,t as n,n as k,k as B}from"../js/app2.js";import{P as D}from"./page-header-48f5a59e.js";import{S as E}from"./sweetalert2.all-8f9540fb.js";import{C as j}from"./vue-select-1fb2a2bb.js";import{s as V}from"./index-es-db6441bd.js";import{L as N}from"./loader-7b01d283.js";const Q={components:{Layout:L,PageHeader:D,DatePicker:V,vSelect:j,Loader:N},data(){return{title:"لیست رسید و برد ها",items:[{text:"مصرف",href:"/"},{text:"لیست رسید و برد ها",active:!0}],showModal:!1,searchQuery:"",isLoading:!1,start_date:"",end_date:"",rasid_bord_type:"",customers:[],selectedCustomer:"",rasid_bord:"",currencies:[],currencyModel:"",selectedDakhl:"",banks:[],amount:0,currency_rate:1,equal_amount:0,transaction_date:null,errors:{},currencies:[],currencyModel:"",desc:"",transactions:[],equalcurrencyModel:"",currentPage:1,totalPages:1,limit:10}},mounted(){this.getTransaction(),this.getCustomers(),this.rasid_bord_type="all"},methods:{select_start_date(s){this.start_date=s.toString()},select_end_date(s){this.end_date=s.toString()},async searchbankTransaction(){try{const s=await i.post("/filterBankTransactions",{tr_type:this.rasid_bord_type,bank_acount_id:this.$route.params.id,start_date:this.start_date,end_date:this.end_date});s.data!=null&&(this.transactions=s.data.searchBank)}catch(s){console.log("Store in catch",s.message)}},updateSelectedCustomer(s){this.selectedCustomer=s.name},openModaledit(){this.showModal=!0},closeModal(){this.showModal=!1},calculateEqualAmount(){this.equal_amount=this.amount/this.currency_rate},editCalculateEqualAmount(){this.editEqual_amount=this.editAmount/this.editCurrency_rate},showalert(s,a,d){E.fire({title:s,icon:a,confirmButtonText:d})},async getCustomers(s=1){try{const a=await i.get(`/customer?page=${s}&limit=${this.limit}`);this.customers=a.data.customers.data,this.totalPages=a.data.customers.last_page,this.currentPage=s}catch(a){console.error("Error fetching customers:",a)}},async getCurrency(){try{await i.get("/currencies").then(s=>{this.currencies=s.data.currencies.data}).catch(s=>{console.error("Error fetching currencies:",s)})}catch(s){console.error("Error fetching data: ",s.message)}},change_currency(){this.getBanks(this.currencyModel)},async getTransaction(s=1){this.isLoading=!0;try{let a=this.$route.params.id;const d=await i.get("/bankdetails/"+a);this.transactions=d.data.banksTransaction}catch(a){console.log(a.message)}finally{this.isLoading=!1}},prevPage(){this.currentPage>1&&this.getCustomers(this.currentPage-1)},nextPage(){this.currentPage<this.totalPages&&this.getCustomers(this.currentPage+1)},async searchData(){const s=await i.post("/searchtransactions",{query:this.searchQuery});this.transactions=s.data},async deleteTransaction(s){if(window.confirm("آیا میخواهید که رسید برد حذف شود؟"))try{(await i.post("/deleteOneTransaction",{id:s})).status===204&&(console.log("response.status === 204"),this.showalert(" با موفقیت حذف شد!","success","success"),this.getTransaction())}catch{console.log("error"),this.showalert(" با موفقیت حذف نشد!","error","error")}else return},async getBanks(s){try{const a=await i.get("/getbankbyid/"+s);this.banks=a.data.banks,this.selectedDakhl=this.banks[0].id}catch(a){console.log(a.message)}}}},z={class:"row"},A={class:"col-12"},H={class:"card"},F={class:"card-body"},U=e("h4",{class:"card-title mb-4"},"جستوج معامله",-1),I={class:"repeater",enctype:"multipart/form-data"},O={class:"row"},G={class:"mb-3 col-lg-2"},J=e("label",{for:"email"},"نوع معامله",-1),K=e("option",{value:"all"},"همه",-1),R=e("option",{value:"rasid"},"رسید",-1),W=e("option",{value:"bord"},"برد",-1),X=[K,R,W],Y={class:"mb-3 col-lg-2"},Z=e("label",{for:"email"},"تاریخ شروع",-1),$={class:"mb-3 col-lg-2"},ee=e("label",{for:"email"},"تاریخ ختم",-1),te={class:"col-lg-2 align-self-center"},se={class:"d-grid"},ae={class:"col-xl-12"},oe={class:"card"},re={class:"card-body"},ce={class:"col-sm-4"},ne={class:"search-box me-2 mb-2 d-inline-block"},le={class:"position-relative"},ie=e("i",{class:"bx bx-search-alt search-icon"},null,-1),de={class:"row"},_e={class:"col-sm-12"},ue={key:0},he={key:1},me={key:0,class:"table-responsive"},ge={class:"table table-nowrap"},pe=e("thead",null,[e("tr",null,[e("th",{class:""},"نمبر چک"),e("th",{class:""},"تاریخ"),e("th",{class:""},"نام مشتری"),e("th",{class:""},"رسید برد"),e("th",{class:""},"مقدار پول"),e("th",{class:""},"تفصیلات"),e("th",{class:""},"توسط")])],-1),be={key:0},ye={key:1},fe={key:0},ve={key:1},ke={class:"pagination pagination-rounded justify-content-center mb-2",style:{}},Pe={class:"page-item"},we=["disabled"],xe=e("i",{class:"mdi mdi-chevron-left"},null,-1),Ce=[xe],Le={class:"page-link",href:"javascript: void(0);"},Se={class:"page-item"},Te=["disabled"],Me=e("i",{class:"mdi mdi-chevron-right"},null,-1),qe=[Me],Be={key:1,class:"text-center font-size-20"};function De(s,a,d,Ee,o,l){const P=u("PageHeader"),m=u("date-picker"),w=u("Loader"),x=u("Layout");return r(),S(x,null,{default:T(()=>[h(P,{title:o.title,items:o.items},null,8,["title","items"]),e("div",z,[e("div",A,[e("div",H,[e("div",F,[U,e("form",I,[e("div",null,[e("div",O,[e("div",G,[J,y(e("select",{class:"form-control form-control-lg required","onUpdate:modelValue":a[0]||(a[0]=t=>o.rasid_bord_type=t)},X,512),[[M,o.rasid_bord_type]])]),e("div",Y,[Z,h(m,{onSelect:l.select_start_date,mode:"single",type:"date",locale:"fa",column:1,clearable:"",required:""},null,8,["onSelect"])]),e("div",$,[ee,h(m,{onSelect:l.select_end_date,mode:"single",type:"date",locale:"fa",column:1,clearable:"",required:""},null,8,["onSelect"])]),e("div",te,[e("div",se,[e("input",{type:"button",class:"btn btn-primary btn-block",value:"جستجو",onClick:a[1]||(a[1]=(...t)=>l.searchbankTransaction&&l.searchbankTransaction(...t))})])])])])])])])]),e("div",ae,[e("div",oe,[e("div",re,[e("div",ce,[e("div",ne,[e("div",le,[y(e("input",{type:"text","onUpdate:modelValue":a[2]||(a[2]=t=>o.searchQuery=t),class:"form-control",placeholder:"جستجوی مشتری...",onInput:a[3]||(a[3]=(...t)=>l.searchData&&l.searchData(...t))},null,544),[[q,o.searchQuery]]),ie])])]),e("div",de,[e("div",_e,[o.isLoading?(r(),c("div",ue,[h(w)])):(r(),c("div",he,[o.transactions.length?(r(),c("div",me,[e("table",ge,[pe,e("tbody",null,[(r(!0),c(f,null,v(o.transactions,t=>{var _,g,p,b;return r(),c("tr",{key:t==null?void 0:t.id},[e("td",null,n(t.check_number),1),e("td",null,n(t==null?void 0:t.date),1),t.customer!=null?(r(),c("td",be,n((_=t.customer)==null?void 0:_.name),1)):(r(),c("td",ye,n((g=t.finance_account)==null?void 0:g.account_name),1)),e("td",null,[e("span",{class:k(["badge badge-pill font-bold font-size-12 p-2",t.rasid_bord==="rasid"?"badge-soft-success":"badge-soft-warning"])},n(t.rasid_bord==="rasid"?"رسید":"برد"),3)]),e("span",null,[B(n(t.amount.toLocaleString())+" "+n(t.tr_currency.name)+" ",1),t.bank_account!=null?(r(),c("span",fe,n((p=t.bank_account)==null?void 0:p.account_name),1)):(r(),c("span",ve,n((b=t.finance_account)==null?void 0:b.account_name),1))]),e("td",null,n(t.desc),1),e("td",null,n(t.user.name),1)])}),128))])]),e("ul",ke,[e("li",Pe,[e("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Previous",onClick:a[4]||(a[4]=(...t)=>l.prevPage&&l.prevPage(...t)),disabled:o.currentPage===1},Ce,8,we)]),(r(!0),c(f,null,v(o.totalPages,(t,_)=>(r(),c("li",{class:k(["page-item",{active:t===o.currentPage}]),key:_},[e("a",Le,n(t),1)],2))),128)),e("li",Se,[e("a",{class:"page-link",href:"javascript: void(0);","aria-label":"Next",onClick:a[5]||(a[5]=(...t)=>l.nextPage&&l.nextPage(...t)),disabled:o.currentPage===o.totalPages},qe,8,Te)])])])):(r(),c("div",Be," نتیجه مورد نظر یافت نشد! "))]))])])])])])])]),_:1})}const He=C(Q,[["render",De]]);export{He as default};