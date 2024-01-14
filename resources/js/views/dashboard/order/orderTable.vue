<template>
  <div class="col-sm-4 bg-red" style="
  margin-top: -52px;
">
      <div class="search-box me-2 mb-2 d-inline-block">
          <div class="position-relative">
              <input type="text" class="form-control" v-model="searchQuery" 
              placeholder="جستجوی مشتری..." @input="searchData"/>
              <i class="bx bx-search-alt search-icon"></i>
          </div>
      </div>
  </div>
    <div class="table-responsive" v-if="orders.length > 0">
        <table class="table table-centered table-nowrap">
          <thead>
            <tr>
                <!-- <th scope="col">#</th> -->
                <th>آیدی</th>
                <th>آیدی مشتری</th>
                <th>آیدی ترانزکشن</th>
                <th>تاریخ سفارش</th>
                <th>تاریخ اجرا</th>
                <th>حالت</th>
                <th>شماره سفارش</th>
                <!-- <th>آیپی آدرس</th> -->
                <th>سیستم</th>
                <th>شماره تماس</th>
                <!-- <th>نتورک آیدی</th> -->
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
              <td>{{ order.state }}</td>
              <td>{{ order.order_number }}</td>
              <!-- <td>{{ order.ip_address }}</td> -->
              <td>{{ order.system }}</td>
              <td>{{ order.phone_number }}</td>
              <!-- <td>{{ order.network_id }}</td> -->
              <td>{{ order.sub_category_id }}</td>
              <td>{{ order.qtt }}</td>
              <td>{{ order.amount }}</td>
              <td>{{ order.final_amount }}</td>
              <td>{{ order.profit_percentage }}</td>
              <td>{{ order.profit_amount }}</td>
              <td>{{ order.currency }}</td>
              <td>{{ order.buy_currency_id }}</td>
              <td>{{ order.currency_rate }}</td>
              <td>{{ order.buy_price }}</td>
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

                <!-- </b-dropdown> -->
            </td>
            </tr>
          </tbody>
        </table>
        <ul class="pagination pagination-rounded justify-content-end mb-2">
            <li class="page-item disabled">
              <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                <i class="mdi mdi-chevron-left"></i>
              </a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="javascript: void(0);">1</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="javascript: void(0);">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="javascript: void(0);">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="javascript: void(0);">4</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="javascript: void(0);">5</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="javascript: void(0);" aria-label="Next">
                <i class="mdi mdi-chevron-right"></i>
              </a>
            </li>
          </ul>
      </div>
      <div v-else class="text-center font-size-20">
        نتیجه مورد نظر یافت نشد!
      </div>
</template>


<script>
import axios from 'axios'
import Swal from 'sweetalert2'
export default {
  name:'orderTable',
    data() {
        return {
            orders:[],
            searchQuery:'',
            offset: 0,
            total_pages: 0,
        } 
    },
    mounted() {
        this.getOrders() 

    },
    methods: {
      showalert(title,text,icon) {
            Swal.fire({
                title:title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },
      // shwos the table content
      async getOrders() {
          try {
            const response = await axios.get('/api/orders', { params: { limit: this.limit,offset: this.offset}});
            this.orders= response.data.orders;
            this.total_pages = response.data.total_pages;
          } catch (error) {
            console.error('Error fetching data: ', error.message);
          }
        },

        openEditModal() {
            this.showModal = true;
            console.log("openEditModal",this.editCust);
        },
        closeModal(){
          this.showModal = false;
        },
        async editOrder(id){
          const response = await axios.get(`/api/orders/${id}`);
          this.editord = response.data;
          this.openEditModal(this.editord);
          this.editOrderState  = this.editord.state;
          this.editPhone = this.editord.phone_number;
          this.editQtt = this.editord.qtt;
            // console.log(this.editord);
        },
        async editSubmitOrder(){

        },

        async deleteOrder(id) {
    if (!window.confirm('آیا میخواهید که سفارش حذف شود؟')) {
                return;
            } else {
                try {
                    console.log("inside try");
                    const response = await axios.delete(`/api/orders/${id}`);
                    this.orders = response.data;
                    if (response.status === 204) {
                        this.showalert('سفارش با موفقیت حذف شد!', 'ادامه دهید', 'success');
                        this.getOrders();
                    }

                } catch (error) {
                    console.log("inside catch");
                    this.showalert('سفارش با موفقیت حذف نشد!', 'ادامه دهید', 'error');
                }
            }
        },
        async searchData() {
            const response = await axios.post('/api/searchorder', {
                query: this.searchQuery
            });
            // console.log(response.data);
            this.orders = response.data;
        },
    },
}
</script>