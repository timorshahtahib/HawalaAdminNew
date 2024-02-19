<script>
import Layout from "../layouts/main.vue";
import Profile from "../components/widgets/profile.vue";
import api from '../services/api';

/**
 * Dashboard Component
 */
export default {
  components: { Layout, Profile },
  data() {
    return {
      title: "داشبورد",
      showModal: false,
      all_transactions:0,
      today_transactions:0,
      deleted_transactions:0,
      users:0,
      customers:0,
      deleted_customers:0,
      all_orders:0,
      accepted_orders:0,
      pending_orders:0,
      rejected_orders:0,
      
     
      transactions: []
    };
  },
   mounted() {
      this.getall();
  },
  methods: {
        async getall(){
            const response = await api.get('/showindex');
            this.customers = response.data.customers;
            this.deleted_customers = response.data.deleted_customers;
            this.users = response.data.users;
            this.all_transactions = response.data.all_transactions;
            this.transactions = response.data.transactions;
            this.today_transactions = response.data.today_transactions;
            this.deleted_transactions = response.data.deleted_transactions;
            this.all_orders = response.data.all_orders;
            this.accepted_orders = response.data.accept_orders;
            this.pending_orders = response.data.pending_orders;
            this.rejected_orders = response.data.rejected_orders;
            this.user_name = response.data.user_name;
            // console.log(this.user_name);
        }, 
         displayTransactionType(transactionType) {
            if (transactionType === 'rasid_bord') {
                return 'رسید برد ';
            } else if (transactionType === 'exchange') {
                return 'تبادله  اسعار';
            } else if(transactionType === 'expense') {
                // Handle other types if necessary
                return 'مصارف'; // Fallback to original type
            }else if(transactionType === 'transfer'){

                return 'انتقال بانکی';
          
            }else if(transactionType === 'commission'){

                return 'کمیشن';
            }
        },

  }, 
};
</script>

<template>
  <Layout>
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0 font-size-18">داشبورد</h4>

          <div class="page-title-right">            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item active">به صفحه اصلی خوش آمدید</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!-- end page title -->


    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4"> مشتریان و کابران</h4>
           
            <div class="text-center">
              <div class="avatar-sm mx-auto mb-4">
                <span class="avatar-title rounded-circle bg-primary font-size-18">
                {{ users + customers}} 
                </span>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white  font-size-16">
                      <!-- <i class="mdi mdi-facebook text-white"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256" width="100" height="100">
                        <g fill="#339af0" fill-rule="nonzero">
                          <g transform="scale(5.12)">
                            <path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path>
                          </g>
                        </g>
                      </svg>
                      
                    </span>
                  </div>
                  <h5 class="font-size-15">تعداد کاربران</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/usermangement" class="avatar-title rounded-circle bg-success font-size-16 cover">
                      {{users}}
                    </router-link>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16 cover">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256"
            style="fill:#000000;">
            <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.6907,0 -23,10.3093 -23,23c0,12.69071 10.3093,23 23,23c12.69071,0 23,-10.30929 23,-23c0,-12.6907 -10.30929,-23 -23,-23zM25,4c11.60982,0 21,9.39018 21,21c0,11.60982 -9.39018,21 -21,21c-11.60982,0 -21,-9.39018 -21,-21c0,-11.60982 9.39018,-21 21,-21zM24.98438,6.98633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v14.17383c-1.19786,0.42351 -1.99904,1.55565 -2,2.82617c0.00091,0.44693 0.10168,0.88802 0.29492,1.29102l-6.00195,6.00195c-0.26124,0.25082 -0.36648,0.62327 -0.27512,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27512l6.00195,-6.00195c0.403,0.19325 0.84408,0.29401 1.29102,0.29492c1.65685,0 3,-1.34315 3,-3c-0.00178,-1.2698 -0.80282,-2.40095 -2,-2.82422v-14.17578c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212z"></path></g></g>
            </svg>
                      <!-- <i class="fa-regular fa-badge-check"></i> -->
                    </span>
                  </div>
                  <h5 class="font-size-15">تعداد مشتریان</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/customer" class="avatar-title rounded-circle bg-success font-size-16 cover">
                      {{customers}}
                    </router-link>
                  </div>
    
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16">
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(2,2)"><path d="M64,1c-34.74,0 -63,28.26 -63,63c0,34.74 28.26,63 63,63c34.74,0 63,-28.26 63,-63c0,-34.74 -28.26,-63 -63,-63zM7,64c0,-31.43 25.57,-57 57,-57c14.64,0 28,5.55 38.11,14.65l-80.45,80.45c-9.11,-10.1 -14.66,-23.46 -14.66,-38.1zM64,121c-14.64,0 -28,-5.55 -38.11,-14.65l80.45,-80.45c9.11,10.1 14.66,23.46 14.66,38.1c0,31.43 -25.57,57 -57,57z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">تعداد مشتریان حذف شده</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-danger font-size-16 cover">
                      {{deleted_customers}}
                    </span>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">سفارشات</h4>
           
            <div class="text-center">
              <div class="avatar-sm mx-auto mb-4">
                <router-link to="/dashboard/order" class="avatar-title rounded-circle bg-primary font-size-18">
                  {{ all_orders }}
                </router-link>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white  font-size-16">
                      <!-- <i class="mdi mdi-facebook text-white"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">سفارشات قبول شده</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/acceptorder" class="avatar-title rounded-circle bg-success font-size-16 cover">
                      {{accepted_orders}}
                    </router-link>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16 cover">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256"
            style="fill:#000000;">
            <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.6907,0 -23,10.3093 -23,23c0,12.69071 10.3093,23 23,23c12.69071,0 23,-10.30929 23,-23c0,-12.6907 -10.30929,-23 -23,-23zM25,4c11.60982,0 21,9.39018 21,21c0,11.60982 -9.39018,21 -21,21c-11.60982,0 -21,-9.39018 -21,-21c0,-11.60982 9.39018,-21 21,-21zM24.98438,6.98633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v14.17383c-1.19786,0.42351 -1.99904,1.55565 -2,2.82617c0.00091,0.44693 0.10168,0.88802 0.29492,1.29102l-6.00195,6.00195c-0.26124,0.25082 -0.36648,0.62327 -0.27512,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27512l6.00195,-6.00195c0.403,0.19325 0.84408,0.29401 1.29102,0.29492c1.65685,0 3,-1.34315 3,-3c-0.00178,-1.2698 -0.80282,-2.40095 -2,-2.82422v-14.17578c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212z"></path></g></g>
            </svg>
                      <!-- <i class="fa-regular fa-badge-check"></i> -->
                    </span>
                  </div>
                  <h5 class="font-size-15">در حال انتظار</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/pendingorder" class="avatar-title rounded-circle bg-warning font-size-16 cover">
                          {{ pending_orders }}
                    </router-link>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16">
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(2,2)"><path d="M64,1c-34.74,0 -63,28.26 -63,63c0,34.74 28.26,63 63,63c34.74,0 63,-28.26 63,-63c0,-34.74 -28.26,-63 -63,-63zM7,64c0,-31.43 25.57,-57 57,-57c14.64,0 28,5.55 38.11,14.65l-80.45,80.45c-9.11,-10.1 -14.66,-23.46 -14.66,-38.1zM64,121c-14.64,0 -28,-5.55 -38.11,-14.65l80.45,-80.45c9.11,10.1 14.66,23.46 14.66,38.1c0,31.43 -25.57,57 -57,57z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">سفارشات رد شده</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/rejectorder" class="avatar-title rounded-circle bg-danger font-size-16 cover">
                      {{rejected_orders}}
                    </router-link>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">لیست تراکنشها</h4>
           
            <div class="text-center">
              <div class="avatar-sm mx-auto mb-4">
                <span class="avatar-title rounded-circle bg-primary font-size-18">
                  {{ all_transactions }}
                </span>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white  font-size-16">
                      <!-- <i class="mdi mdi-facebook text-white"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">تمام تراکنشها</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/report/rooznamchah" class="avatar-title rounded-circle bg-success font-size-16 cover">
                      {{all_transactions}}
                    </router-link>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16 cover">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256"
            style="fill:#000000;">
            <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.6907,0 -23,10.3093 -23,23c0,12.69071 10.3093,23 23,23c12.69071,0 23,-10.30929 23,-23c0,-12.6907 -10.30929,-23 -23,-23zM25,4c11.60982,0 21,9.39018 21,21c0,11.60982 -9.39018,21 -21,21c-11.60982,0 -21,-9.39018 -21,-21c0,-11.60982 9.39018,-21 21,-21zM24.98438,6.98633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v14.17383c-1.19786,0.42351 -1.99904,1.55565 -2,2.82617c0.00091,0.44693 0.10168,0.88802 0.29492,1.29102l-6.00195,6.00195c-0.26124,0.25082 -0.36648,0.62327 -0.27512,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27512l6.00195,-6.00195c0.403,0.19325 0.84408,0.29401 1.29102,0.29492c1.65685,0 3,-1.34315 3,-3c-0.00178,-1.2698 -0.80282,-2.40095 -2,-2.82422v-14.17578c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212z"></path></g></g>
            </svg>
                      <!-- <i class="fa-regular fa-badge-check"></i> -->
                    </span>
                  </div>
                  <h5 class="font-size-15">تراکنشهای امروز</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-success font-size-16 cover">
                      {{today_transactions}}
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white font-size-16">
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(2,2)"><path d="M64,1c-34.74,0 -63,28.26 -63,63c0,34.74 28.26,63 63,63c34.74,0 63,-28.26 63,-63c0,-34.74 -28.26,-63 -63,-63zM7,64c0,-31.43 25.57,-57 57,-57c14.64,0 28,5.55 38.11,14.65l-80.45,80.45c-9.11,-10.1 -14.66,-23.46 -14.66,-38.1zM64,121c-14.64,0 -28,-5.55 -38.11,-14.65l80.45,-80.45c9.11,10.1 14.66,23.46 14.66,38.1c0,31.43 -25.57,57 -57,57z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">تراکنشهای حذف شده</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-danger font-size-16 cover">
                      {{deleted_transactions}}
                    </span>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4 text-center">آخرین تراکنشــــــها</h4>
            <div class="table-responsive " >
              <table class="table table-centered table-nowrap text-start">
                  <thead>
                      <tr>
                          <th class="text-center">تاریخ</th>
                          <th class="text-center">نوع تراکنش</th>
                          <th class="text-center">نام مشتری</th>
                          <!-- <th class="text-center">رسید برد</th> -->
                          <th class="text-center">مقدار پول</th>
                          <th class="text-center">تفصیلات</th>
                          <th class="text-center">نمبر چک</th>
                          <!-- <th class="text-center">توسط</th> -->
                      </tr>
                  </thead>
                  <tbody class="text-center font-size-14">
                      <tr v-for="transaction in transactions" :key="transaction?.id">
                        <td>{{ transaction.date }}</td>
                        <td>
                          <span
                            class="badge badge-pill badge-soft-success font-bold p-2"
                            :class="{
                              'badge-soft-success': `${transaction.rasid_bord}` === 'rasid',
                              'badge-soft-warning': `${transaction.rasid_bord}` === 'bord',
                            }"
                            >{{displayTransactionType(transaction.transaction_type)}}</span
                          >
                        </td>
                        <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                        <td v-else>{{ transaction.finance_account?.account_name}}</td>
                        <td>{{transaction.amount}} {{transaction.tr_currency?.name}}
                          {{transaction.rasid_bord ==='rasid'? 'به': 'از' }}
                              <span v-if="transaction?.bank_account!=null">{{transaction.bank_account?.account_name}}</span>
                              <span v-else>{{ transaction.finance_account?.account_name}}</span>
                          </td>
                         <td>{{transaction.desc}}</td>
                         <td>{{transaction.check_number}}</td>
                      </tr>
                      
                  </tbody>
              </table>
          </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

  </Layout>
</template>
