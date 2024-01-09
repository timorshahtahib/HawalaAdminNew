import{m as F}from"./default-8459159b.js";import{L as V}from"./main-e24c86ad.js";import{P as L}from"./page-header-c6b63424.js";import{c as m}from"./data-products-c6af86c7.js";import{_ as M,e as b,w as a,r as _,o as u,d as o,a as e,c as p,f,F as g,g as c,A as k,u as R,B as j,t as v}from"../js/app2.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./img-1-d2b601cb.js";import"./img-6-b48351e8.js";const S={components:{Slider:F,Layout:V,PageHeader:L},data(){return{clothsData:m,title:"Product",items:[{text:"Ecommerce",href:"/"},{text:"Products",active:!0}],sliderPrice:800,currentPage:1,discountRates:[],records:[],prices:[],selected:{prices:[]}}},watch:{selected:{handler:function(){this.loadPrices()},deep:!0}},mounted(){this.loadPrices()},methods:{loadPrices(){},valuechange(n){this.clothsData=m.filter(function(t){return t.newprice<=n})},searchFilter(n){const t=n.target.value;this.clothsData=m.filter(r=>r.name.toLowerCase().search(t.toLowerCase())!==-1)},discountLessFilter(n,t){n==="accepted"&&this.discountRates.length===0?this.clothsData=m.filter(r=>r.discount<t):this.clothsData=m.filter(r=>r.discount>=Math.max.apply(null,this),this.discountRates)},discountMoreFilter(n,t){n==="accepted"?this.discountRates.push(t):this.discountRates.splice(this.discountRates.indexOf(t),1),this.clothsData=m.filter(r=>r.discount>=Math.max.apply(null,this),this.discountRates)}}},B={class:"row"},z={class:"col-lg-3"},A={class:"card"},N={class:"card-body"},H=e("h4",{class:"card-title mb-4"},"Filter",-1),U=e("div",null,[e("h5",{class:"font-size-14 mb-3"},"Clothes"),e("ul",{class:"list-unstyled product-list"},[e("li",null,[e("a",{href:"javascript: void(0);"},[e("i",{class:"mdi mdi-chevron-right me-1"}),c(" T-shirts ")])]),e("li",null,[e("a",{href:"javascript: void(0);"},[e("i",{class:"mdi mdi-chevron-right me-1"}),c(" Shirts ")])]),e("li",null,[e("a",{href:"javascript: void(0);"},[e("i",{class:"mdi mdi-chevron-right me-1"}),c(" Jeans ")])]),e("li",null,[e("a",{href:"javascript: void(0);"},[e("i",{class:"mdi mdi-chevron-right me-1"}),c(" Jackets ")])])])],-1),E={class:"mt-4 pt-3"},J=["value","id"],T=["for"],I=e("h5",{class:"font-size-14 mb-3"},"Price",-1),O={class:"mt-4 pt-3"},q=e("h5",{class:"font-size-14 mb-3"},"Discount",-1),G={class:"mt-4 pt-3"},K=e("h5",{class:"font-size-14 mb-3"},"Customer Rating",-1),Q=e("i",{class:"bx bx-star text-warning"},null,-1),W=e("i",{class:"bx bx-star text-warning"},null,-1),X=e("i",{class:"bx bx-star text-warning"},null,-1),Y=e("i",{class:"bx bx-star text-warning"},null,-1),Z={class:"col-lg-9"},$={class:"row mb-3"},ee=e("div",{class:"col-xl-4 col-sm-6"},[e("div",{class:"mt-2"},[e("h5",null,"Clothes")])],-1),te={class:"col-lg-8 col-sm-6"},se={class:"mt-4 mt-sm-0 float-sm-end d-flex align-items-center"},ce={class:"search-box me-2"},oe={class:"position-relative"},ae=e("i",{class:"bx bx-search-alt search-icon"},null,-1),le=e("ul",{class:"nav nav-pills product-view-nav"},[e("li",{class:"nav-item"},[e("a",{class:"nav-link active",href:"javascript: void(0);"},[e("i",{class:"bx bx-grid-alt"})])]),e("li",{class:"nav-item"},[e("a",{class:"nav-link",href:"javascript: void(0);"},[e("i",{class:"bx bx-list-ul"})])])],-1),ie={class:"row"},ne={class:"card"},re={class:"card-body"},de={class:"product-img position-relative"},ue={key:0,class:"avatar-sm product-ribbon"},he={class:"avatar-title rounded-circle bg-primary"},me=["src"],_e={class:"mt-4 text-center"},pe={class:"mb-3 text-truncate"},ve=e("p",{class:"text-muted"},[e("i",{class:"bx bx-star text-warning"}),e("i",{class:"bx bx-star text-warning"}),e("i",{class:"bx bx-star text-warning"}),e("i",{class:"bx bx-star text-warning"}),e("i",{class:"bx bx-star text-warning"})],-1),xe={class:"my-0"},be={class:"row"},fe={class:"col-lg-12"};function ge(n,t,r,ke,l,d){const w=_("PageHeader"),C=_("Slider"),i=_("b-form-checkbox"),x=_("router-link"),y=_("b-pagination"),P=_("Layout");return u(),b(P,null,{default:a(()=>[o(w,{title:l.title,items:l.items},null,8,["title","items"]),e("div",B,[e("div",z,[e("div",A,[e("div",N,[H,U,e("div",E,[(u(!0),p(g,null,f(l.prices,(s,h)=>(u(),p("div",{class:"form-check",key:h},[R(e("input",{class:"form-check-input",type:"checkbox",value:h,id:"price"+h,"onUpdate:modelValue":t[0]||(t[0]=D=>l.selected.prices=D)},null,8,J),[[j,l.selected.prices]]),e("label",{class:"form-check-label",for:"price"+h},v(s.name)+v(s.products_count),9,T)]))),128)),I,o(C,{modelValue:l.sliderPrice,"onUpdate:modelValue":t[1]||(t[1]=s=>l.sliderPrice=s),min:0,max:1e3,onChange:d.valuechange},null,8,["modelValue","onChange"])]),e("div",O,[q,o(i,{id:"productdiscountCheck1",value:"accepted","unchecked-value":"not_accepted",onChange:t[2]||(t[2]=s=>d.discountLessFilter(s,10))},{default:a(()=>[c("Less than 10%")]),_:1}),o(i,{id:"productdiscountCheck2",value:"accepted","unchecked-value":"not_accepted",onChange:t[3]||(t[3]=s=>d.discountMoreFilter(s,10))},{default:a(()=>[c("10% or more")]),_:1}),o(i,{id:"productdiscountCheck3",value:"accepted","unchecked-value":"not_accepted",onChange:t[4]||(t[4]=s=>d.discountMoreFilter(s,20))},{default:a(()=>[c("20% or more")]),_:1}),o(i,{id:"productdiscountCheck4",value:"accepted","unchecked-value":"not_accepted",onChange:t[5]||(t[5]=s=>d.discountMoreFilter(s,30))},{default:a(()=>[c("30% or more")]),_:1}),o(i,{id:"productdiscountCheck5",value:"accepted","unchecked-value":"not_accepted",onChange:t[6]||(t[6]=s=>d.discountMoreFilter(s,40))},{default:a(()=>[c("40% or more")]),_:1}),o(i,{id:"productdiscountCheck6",value:"accepted","unchecked-value":"not_accepted",onChange:t[7]||(t[7]=s=>d.discountMoreFilter(s,50))},{default:a(()=>[c("50% or more")]),_:1})]),e("div",G,[K,e("div",null,[o(i,{id:"checkbox-1",name:"checkbox-1",value:"accepted","unchecked-value":"not_accepted"},{default:a(()=>[c(" 4 "),Q,c(" & Above ")]),_:1}),o(i,{id:"checkbox-2",name:"checkbox-2",value:"accepted","unchecked-value":"not_accepted"},{default:a(()=>[c(" 3 "),W,c(" & Above ")]),_:1}),o(i,{id:"checkbox-3",name:"checkbox-3",value:"accepted","unchecked-value":"not_accepted"},{default:a(()=>[c(" 2 "),X,c(" & Above ")]),_:1}),o(i,{id:"checkbox-4",name:"checkbox-4",value:"accepted","unchecked-value":"not_accepted"},{default:a(()=>[c(" 1 "),Y]),_:1})])])])])]),e("div",Z,[e("div",$,[ee,e("div",te,[e("form",se,[e("div",ce,[e("div",oe,[e("input",{type:"text",class:"form-control border-0",placeholder:"Search...",onInput:t[8]||(t[8]=s=>d.searchFilter(s))},null,32),ae])]),le])])]),e("div",ie,[(u(!0),p(g,null,f(l.clothsData,(s,h)=>(u(),p("div",{key:h,class:"col-xl-4 col-sm-6"},[e("div",ne,[e("div",re,[e("div",de,[s.discount?(u(),p("div",ue,[e("span",he,"-"+v(s.discount)+"%",1)])):k("",!0),o(x,{to:"/ecommerce/product-detail/"},{default:a(()=>[e("img",{src:`${s.product}`,alt:"",class:"img-fluid mx-auto d-block"},null,8,me)]),_:2},1024)]),e("div",_e,[e("h5",pe,[o(x,{class:"text-dark",to:"/ecommerce/product-detail"},{default:a(()=>[c(v(s.name),1)]),_:2},1024)]),ve,e("h5",xe,[e("b",null,"$"+v(s.newprice),1)])])])])]))),128))]),e("div",be,[e("div",fe,[l.clothsData.length>0?(u(),b(y,{key:0,class:"justify-content-center",pills:"",modelValue:l.currentPage,"onUpdate:modelValue":t[9]||(t[9]=s=>l.currentPage=s),"total-rows":l.clothsData.length,"per-page":6,"aria-controls":"my-table"},null,8,["modelValue","total-rows"])):k("",!0)])])])])]),_:1})}const je=M(S,[["render",ge]]);export{je as default};