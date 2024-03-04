<template>
    <div class="col-sm-4 bg-red" style="
    margin-top: -52px;
  ">
        <div class="search-box me-2 mb-2 d-inline-block">
            <div class="position-relative">
                <input type="text" class="form-control" v-model="searchQuery" 
                placeholder="جستجوی سفارش..." @input="searchData"/>
                <i class="bx bx-search-alt search-icon"></i>
            </div>
        </div>
    </div>
    <div v-if="isLoading">
      <Loader />
    </div>
      <div v-else>
          <div class="table-responsive" v-if="orders?.length">
              <table class="table table-centered table-nowrap">
                <thead>
                  <tr>
                      <th>آیدی</th>
                      <th>آیدی مشتری</th>
                      <th>آیدی ترانزکشن</th>
                      <th>تاریخ سفارش</th>
                      <th>تاریخ اجرا</th>
                      <th>حالت</th>
                      <th>شماره سفارش</th>
                      <th>سیستم</th>
                      <th>شماره تماس</th>
                      <th>سب کتگوری آیدی</th>
                      <th>کیو تی تی</th>
                      <th>مقدار</th>
                      <th>مقدار نهائی</th>
                      <th>درصد مفاد</th>
                      <th>مبلغ مفاد</th>
                      <th>واحد پولی</th>
                      <th>آیدی ارز خریدار</th>
                      <th>نرخ ارز</th>
                      <th>قیمت خرید</th>
                      <th>آیدی یوزر</th>
                      <th>آیدی محصول</th>
                      <th>آیدی تامین کننده</th>
                      <th>توضیح رد شده</th>
                      <th>وضعیت</th>
                      <th>اکشن</th>
                  </tr>
                </thead>
                <tbody>
              <tr v-for="order in orders" :key="order.id">
                
                    <td>{{ order.id }}</td>
                    <td>{{ order.customer_id }}</td>
                    <td>{{ order.transaction_id  }}</td>
                    <td>{{ order.order_date }}</td>
                    <td>{{ order.action_date }}</td>
                    <td><span class="badge badge-pill  font-bold p-2 font-size-12  badge-soft-warning"> {{ order.state }}</span></td>
                    <td>{{ order.order_number }}</td>
                    <td>{{ order.system }}</td>
                    <td>{{ order.phone_number }}</td>
                    <td>{{ order.sub_category_id }}</td>
                    <td>{{ order.qtt }}</td>
                    <td>{{ order.amount.toLocaleString() }}</td>
                    <td>{{ order.final_amount.toLocaleString() }}</td>
                    <td>{{ order.profit_percentage.toLocaleString() }}</td>
                    <td>{{ order.profit_amount.toLocaleString() }}</td>
                    <td>{{ order.currency }}</td>
                    <td>{{ order.buy_currency_id }}</td>
                    <td>{{ order.currency_rate }}</td>
                    <td>{{ order.buy_price.toLocaleString() }}</td>
                    <td>{{ order.user_id }}</td>
                    <td>{{ order.product_id }}</td>
                    <td>{{ order.supplier_id }}</td>
                    <td>{{ order.reject_disc }}</td>
                    <td>
                      <span class="badge  font-size-12" :class="order.status === 0 ? 'bg-warning' :'bg-primary'">
                        <i class="mdi mdi-star me-1"></i>
                        {{ order.status }}
                      </span>
                    </td>
                    <td>
                 
      
                          <button class="btn btn-xs">
                              <i class="fas fa-trash-alt text-danger me-1" @click="deleteOrder(order.id)"></i>
                          </button>
      
                    
                  </td>
                  </tr>
                </tbody>
              </table>
              <ul class="pagination pagination-rounded justify-content-center mb-2" style="text-center">
                <li class="page-item">
                    <a class="page-link" href="javascript: void(0);" aria-label="Previous" @click="prevPage" :disabled="currentPage === 1">
                        <i class="mdi mdi-chevron-left"></i>
                    </a>
                </li>
                <li :class="['page-item', { 'active': pa === currentPage }]" v-for="(pa, index) in totalPages" :key="index">
                    <a class="page-link" href="javascript: void(0);">{{ pa }}</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript: void(0);" aria-label="Next" @click="nextPage" :disabled="currentPage === totalPages">
                        <i class="mdi mdi-chevron-right"></i>
                    </a>
                </li>
            </ul>
            </div>
            <div v-else class="text-center font-size-20">
              نتیجه مورد نظر یافت نشد!
            </div>
      </div>
  </template>
  
  
  <script>
  import axios from 'axios'
  import Swal from 'sweetalert2'
  import Loader from '../../loader/loader.vue'
  import api from '../../../services/api';
  export default {
    name:'pendingOrderTable',
    components:{Loader},
      data() {
          return {
              isLoading:false,
              orders:[],
              searchQuery:'',
                // pagination
                currentPage: 1,
              totalPages: 1,
              limit: 10,
          } 
      },
      mounted() {
          this.getOrders() 
  
      },
      methods: {

        async getOrders(page = 1) {
          this.isLoading = true;
            try {
                  const response = await api.get(`/pendingorder?page=${page}&limit=${this.limit}`);
                  this.orders = response.data.orders.data;
                  this.totalPages = response.data.orders.last_page;
                  this.currentPage = page; // Update the current page
              } catch (error) {
                  console.error('Error fetching orders:', error);
              }finally{
                  this.isLoading=false;
              }
          },
          prevPage() {
              if (this.currentPage > 1) {
                  this.getOrders(this.currentPage - 1); // Update the page parameter
              }
          },
          nextPage() {
              if (this.currentPage < this.totalPages) {
                  this.getOrders(this.currentPage + 1); // Update the page parameter
              }
          },
     
          async searchData() {
              const response = await api.post('/searchorder', {
                  query: this.searchQuery
              });
              // console.log(response.data);
              this.orders = response.data;
          },
      },
  }
  </script>