<script>
import Layout from "../layouts/main.vue";
import Profile from "../components/widgets/profile.vue";
import api from '../services/api';

import transactionLogo from '../../images/coin-statistics-2147.png'
import todayCoin from '../../images/coin-today.png'



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
      transactionLogo,
      todayCoin,
      transactions: []
    };
  },
   mounted() {
      this.getall();
  },
  methods: {
        async getall(){
              try {
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
                this.user_name = response.data?.user_name;
                this.user_name = response.data.user_name;
              } catch (error) {
                  console.log("خطائی رخ داده است");
              }
            
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
      <div class="col-xl-4 col-sm-12">
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

                      <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 48 48" id="user">
                        <path fill="#42c3cf" d="M31.64,27.72a13.94,13.94,0,0,1-15.28,0A18,18,0,0,0,6.05,42.94a1,1,0,0,0,.27.75,1,1,0,0,0,.73.31H41a1,1,0,0,0,.73-.31,1,1,0,0,0,.27-.75A18,18,0,0,0,31.64,27.72Z"></path><circle cx="24" cy="16" r="12" fill="#42c3cf"></circle></svg>                           
                      <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 48 48" id="user"><path fill="#42c3cf" d="M31.64,27.72a13.94,13.94,0,0,1-15.28,0A18,18,0,0,0,6.05,42.94a1,1,0,0,0,.27.75,1,1,0,0,0,.73.31H41a1,1,0,0,0,.73-.31,1,1,0,0,0,.27-.75A18,18,0,0,0,31.64,27.72Z"></path><circle cx="24" cy="16" r="12" fill="#42c3cf"></circle></svg>
                      
                                                    
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

                      <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 48 48" id="user">
                        <path fill="#42c3cf" d="M31.64,27.72a13.94,13.94,0,0,1-15.28,0A18,18,0,0,0,6.05,42.94a1,1,0,0,0,.27.75,1,1,0,0,0,.73.31H41a1,1,0,0,0,.73-.31,1,1,0,0,0,.27-.75A18,18,0,0,0,31.64,27.72Z"></path><circle cx="24" cy="16" r="12" fill="#42c3cf"></circle></svg> 
=======
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                        <path fill="blue" d="M160 96a40 40 0 1 0 0-80 40 40 0 1 0 0 80zm0-96a56 56 0 1 1 0 112A56 56 0 1 1 160 0zM141.1 144c-21.5 0-41.1 12.3-50.4 31.7L23.2 315.5c-1.9 4-6.7 5.6-10.7 3.7s-5.6-6.7-3.7-10.7L76.3 168.7c12-24.9 37.2-40.7 64.8-40.7h37.8c27.6 0 52.8 15.8 64.8 40.7l67.5 139.8c1.9 4 .3 8.8-3.7 10.7s-8.8 .3-10.7-3.7L229.3 175.7C220 156.3 200.4 144 178.9 144H141.1zM104 248V480c0 8.8 7.2 16 16 16s16-7.2 16-16V360c0-13.3 10.7-24 24-24s24 10.7 24 24V480c0 8.8 7.2 16 16 16s16-7.2 16-16V248c0-4.4 3.6-8 8-8s8 3.6 8 8V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V360c0-4.4-3.6-8-8-8s-8 3.6-8 8V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V248c0-4.4 3.6-8 8-8s8 3.6 8 8z"/>
                    </svg>
                    
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

                   
                        <svg fill="#339af0" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.83 57.83" xml:space="preserve" stroke="#339af0" stroke-width="0.00057828"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="1.7348400000000002"></g><g id="SVGRepo_iconCarrier"> <g> <g> <circle cx="24.87" cy="13.811" r="13.811"></circle> <path d="M6.972,52.484l9.718,2.56c4.215,1.109,11.004,0.979,15.173-0.293l3.93-1.205c2.209,2.614,5.505,4.281,9.188,4.281 c6.633,0,12.03-5.397,12.03-12.03c0-6.635-5.397-12.032-12.03-12.032c-1.124,0-2.207,0.167-3.239,0.456 c-2.494-3.016-5.696-5.299-9.631-6.58c-2.292,1.345-4.947,2.129-7.791,2.129c-2.857,0-5.527-0.792-7.826-2.149 c-7.347,2.302-12.55,7.888-15.278,15.2C-0.311,46.905,2.757,51.374,6.972,52.484z M44.95,35.346 c5.732,0,10.378,4.646,10.378,10.38c0,5.732-4.646,10.379-10.378,10.379s-10.379-4.646-10.379-10.379 C34.572,39.992,39.217,35.346,44.95,35.346z"></path> <path d="M39.138,51.036c0.365,0.402,0.866,0.604,1.37,0.604c0.446,0,0.896-0.16,1.251-0.485l3.19-2.916l3.189,2.916 c0.356,0.325,0.805,0.485,1.251,0.485c0.502,0,1.003-0.203,1.37-0.604c0.691-0.755,0.638-1.93-0.118-2.621l-2.943-2.691 l2.943-2.691c0.756-0.691,0.809-1.864,0.118-2.621c-0.691-0.757-1.864-0.808-2.621-0.118l-3.189,2.918l-3.19-2.918 c-0.757-0.691-1.929-0.638-2.621,0.118c-0.691,0.757-0.639,1.93,0.118,2.621l2.944,2.691l-2.944,2.691 C38.5,49.106,38.448,50.281,39.138,51.036z"></path> </g> </g> </g></svg>

                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(2,2)"><path d="M64,1c-34.74,0 -63,28.26 -63,63c0,34.74 28.26,63 63,63c34.74,0 63,-28.26 63,-63c0,-34.74 -28.26,-63 -63,-63zM7,64c0,-31.43 25.57,-57 57,-57c14.64,0 28,5.55 38.11,14.65l-80.45,80.45c-9.11,-10.1 -14.66,-23.46 -14.66,-38.1zM64,121c-14.64,0 -28,-5.55 -38.11,-14.65l80.45,-80.45c9.11,10.1 14.66,23.46 14.66,38.1c0,31.43 -25.57,57 -57,57z"></path></g></g>
                        </svg>
                    </span>
                  </div>
                  <h5 class="font-size-15">مشتریان حذف شده</h5>
                  <div class="avatar-xs mx-auto mb-3">
                    <router-link to="/dashboard/customerdeleted" class="avatar-title rounded-circle bg-success font-size-16 cover">
                      <span class="avatar-title rounded-circle bg-danger font-size-16 cover">
                        {{deleted_customers}}
                      </span>
                    </router-link>
                  </div>
                </div>
              </div>
          
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
      <div class="col-xl-4 col-sm-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">سفارشات</h4>
           
            <div class="text-center">
              <div class="avatar-sm mx-auto mb-4">
                <span  class="avatar-title rounded-circle bg-primary font-size-18">
                  {{ all_orders }}
                </span>
              </div>
            </div>
            <div class="row mt-4">
              <div class="col-sm-4">
                <div class="social-source text-center mt-3">
                  <div class="avatar-xs mx-auto mb-3">
                    <span class="avatar-title rounded-circle bg-white  font-size-16">


                      <!-- <i class="mdi mdi-facebook text-white"></i> -->
                      <!-- <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                        <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path></g></g>
                        </svg> -->

                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                          <g fill="#339af0" fill-rule="nonzero">
                            <g transform="scale(5.12,5.12)">
                              <path d="M25,2c-12.683,0 -23,10.317 -23,23c0,12.683 10.317,23 23,23c12.683,0 23,-10.317 23,-23c0,-4.56 -1.33972,-8.81067 -3.63672,-12.38867l-1.36914,1.61719c1.895,3.154 3.00586,6.83148 3.00586,10.77148c0,11.579 -9.421,21 -21,21c-11.579,0 -21,-9.421 -21,-21c0,-11.579 9.421,-21 21,-21c5.443,0 10.39391,2.09977 14.12891,5.50977l1.30859,-1.54492c-4.085,-3.705 -9.5025,-5.96484 -15.4375,-5.96484zM43.23633,7.75391l-19.32227,22.80078l-8.13281,-7.58594l-1.36328,1.46289l9.66602,9.01563l20.67969,-24.40039z"></path>
                            </g>
                          </g>
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

              <div class="col-xl-4">

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

                      <img :src="transactionLogo" alt="" width="60" class="mb-2">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M445.7 133.7c3.1-3.1 3.1-8.2 0-11.3l-104-104c-3.1-3.1-8.2-3.1-11.3 0s-3.1 8.2 0 11.3L420.7 120 8 120c-4.4 0-8 3.6-8 8s3.6 8 8 8l412.7 0-90.3 90.3c-3.1 3.1-3.1 8.2 0 11.3s8.2 3.1 11.3 0l104-104zM2.3 389.7l104 104c3.1 3.1 8.2 3.1 11.3 0s3.1-8.2 0-11.3L27.3 392 440 392c4.4 0 8-3.6 8-8s-3.6-8-8-8L27.3 376l90.3-90.3c3.1-3.1 3.1-8.2 0-11.3s-8.2-3.1-11.3 0l-104 104c-3.1 3.1-3.1 8.2 0 11.3z"/></svg>

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

                      <img :src="todayCoin" alt="" width="40" class="mb-2">

            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256"
            style="fill:#000000;">
            <g fill="#339af0" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.6907,0 -23,10.3093 -23,23c0,12.69071 10.3093,23 23,23c12.69071,0 23,-10.30929 23,-23c0,-12.6907 -10.30929,-23 -23,-23zM25,4c11.60982,0 21,9.39018 21,21c0,11.60982 -9.39018,21 -21,21c-11.60982,0 -21,-9.39018 -21,-21c0,-11.60982 9.39018,-21 21,-21zM24.98438,6.98633c-0.55152,0.00862 -0.99193,0.46214 -0.98437,1.01367v14.17383c-1.19786,0.42351 -1.99904,1.55565 -2,2.82617c0.00091,0.44693 0.10168,0.88802 0.29492,1.29102l-6.00195,6.00195c-0.26124,0.25082 -0.36648,0.62327 -0.27512,0.97371c0.09136,0.35044 0.36503,0.62411 0.71547,0.71547c0.35044,0.09136 0.72289,-0.01388 0.97371,-0.27512l6.00195,-6.00195c0.403,0.19325 0.84408,0.29401 1.29102,0.29492c1.65685,0 3,-1.34315 3,-3c-0.00178,-1.2698 -0.80282,-2.40095 -2,-2.82422v-14.17578c0.0037,-0.2703 -0.10218,-0.53059 -0.29351,-0.72155c-0.19133,-0.19097 -0.45182,-0.29634 -0.72212,-0.29212z"></path></g></g>
            </svg>

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

            <div class="table-responsive">

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
                            class="badge badge-pill  font-bold p-2"
                            :class="{
                              'badge-soft-success': `${transaction.rasid_bord}` === 'rasid',
<<<<<<< HEAD
                              'badge-soft-danger': `${transaction.rasid_bord}` === 'bord',
=======
                              'badge-soft-warning': `${transaction.rasid_bord}` === 'bord',
>>>>>>> fc908c9970f575848d97a1b687135b8e6e6f0944
                            }"
                            >{{displayTransactionType(transaction.transaction_type)}}</span
                          >
                        </td>
                        <td v-if="transaction.customer!=null">{{ transaction.customer?.name}}</td>
                        <td v-else>{{ transaction.finance_account?.account_name}}</td>
                        <td>{{transaction.amount.toLocaleString()}} {{transaction.tr_currency?.name}}
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
