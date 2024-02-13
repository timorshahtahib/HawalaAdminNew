<template>

    
    <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">جستجوی حسابات</h4>
            <form class="repeater" enctype="multipart/form-data">
              <div>
                <div  class="row">


                  <div class="mb-3 col-lg-2">
                    <label for="email">نوع  بانک</label>
                    <select class="form-control form-control-lg  required" v-model="type_of_banks">
                        <option value="all">All</option>
                        <option value="asset">Assets</option>
                        <option value="equity">Equity</option>
                        <option value="liablity">Liablity</option>
                    </select>
                  </div>
                  <div class="mb-3 col-lg-2">
                    <label for="email">نوع  </label>
                    <select class="form-control form-control-lg  required" v-model="account">
                        <option value="all">All</option>
                        <option value="bank">بانکها</option>
                        <option value="income">درامدها</option>
                        <option value="expense">مصارف</option>
                    </select>
                  </div>
                  <div class="col-lg-2 align-self-center">
                     <div class="d-grid">
                    <input
                      type="button"
                      class="btn btn-primary btn-block"
                      value="جستجو"
                      @click="financetypefilter"
                    />
                     </div>
                  </div>
                </div>
              </div>

            </form>
          </div>
          <!-- end card-body -->
        </div>
        <!-- end card -->
      </div>
<div class="col-sm-12 bg-red" >
    <div class="search-box me-2 mb-2 d-inline-block">
        <div class="position-relative">
            <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
            <i class="bx bx-search-alt search-icon"></i>
        </div>
    </div>
</div>
<!-- edit modal start -->
<div class="col-sm-8">
    <div class="text-sm-end">
        <b-modal v-model="edit_showModal" title="ویرایش حساب" title-class="text-black font-18" body-class="p-3" hide-footer>
            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
 }}</b-alert>

            <form @submit.prevent="submitEditedForm(editFinance.id)">
                <div class="row flex justify-between">
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">نام حساب<span class="text-danger">*</span></label>
                                <input id="acount_name" v-model="editAccountName" placeholder="نام حساب..." type="text" class="form-control" required />

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">نوعیت حساب<span class="text-danger">*</span></label>
                                <select v-model="editType" class="form-control form-control-lg" required>
                                    <option value="asset">Assets</option>
                                    <option value="equity">equity</option>
                                    <option value="liablity">liablity</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">پول<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg select2 required" v-model="editCurrency" style="width: 100%;" required>
                                    <option disabled selected> واحد</option>
                                    <option v-for="currency in edit_currencies" :key="currency?.id" :value="currency?.id">{{currency?.name}} {{currency?.sign}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">حسابات<span class="text-danger">*</span></label>
                                <select class="form-control form-control-lg select2 required" v-model="editAccountType" style="width: 100%;" required>
                                    <option value="bank">بانک</option>
                                    <option value="income">درآمد</option>
                                    <option value="expense">مصرف</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-1">
                            <label for="desc">توضیحات</label>
                            <textarea v-model="editDescription" id="desc" cols="30" rows="4" class="form-control" placeholder="توضیحات خود را وارد کنید"></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-5 mt-1 g-2">
                    <b-button variant="danger" @click="edit_showModal=false">بستن</b-button>
                    <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                </div>
            </form>
        </b-modal>
    </div>
</div>
<!-- edit modal end -->
<div v-if="isLoading">
    <Loader />
  </div>
<div class="" v-else>
    <div class="table-responsive" v-if="financeAccounts?.length">
        <table class="table table-centered table-nowrap">
            <thead>
                <tr>
                 <th>آیدی</th>
                 <th>نام حساب</th>
                 <th>نوعیت</th>
                 <th>پول</th>
                 <th>حساب</th>
                 <th>توضیحات</th>
                 <th>وضیعت</th>
                 <th>آکشن</th>
                 </tr>
            </thead>
            <tbody>
             <tr v-for="financeAccount in financeAccounts" :key="financeAccount.id">
            
                   <td>{{ financeAccount.id }}</td>
                   <td>{{ financeAccount.account_name }}</td>
                   <td>{{ financeAccount.type }}</td>
                   <td>{{ financeAccount.finance_currency?.name }}</td>
                   <td>{{ financeAccount?.account }}</td>
                   <td>{{ financeAccount.description }}</td>
                   <!-- <td>{{ financeAccount.user_id }}</td> -->
                  <td>
                     <span class="badge  font-size-12" :class="financeAccount.status === 0 ? 'bg-warning' :'bg-primary'">
                       <i class="mdi mdi-star me-1"></i>
                       {{ financeAccount.status }}
                     </span>
                   </td>
                   <td>
                    <button class="btn btn-xs"><i class="fas fa-pencil-alt text-success me-1" 
                        @click="editfinanceAccount(financeAccount.id)"></i></button> 
        
                    <button class="btn btn-xs"> <i class="fas fa-trash-alt text-danger me-1" 
                        @click="deleteFinanceAccount(financeAccount.id)"></i></button>
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
import axios from 'axios';
import Swal from 'sweetalert2'
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
import Loader from '../../loader/loader.vue';
import api from '../../../services/api';
export default {
    name: 'customerTable',
    components: {
    DatePicker,
    Loader
},
    data() {
        return {
            isLoading:false,
            edit_showModal: false,
            financeAccounts: [],
            currencies: [],
            edit_currencies: [],
            searchQuery: '',
            // edit modal
            editAccountName: '',
            editType: '',
            editCurrency: '',
            editDescription: '',
            editAccountType: '',
            errors: {},
           
              // search
              type_of_banks:'',
              account:'',
            // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,
        }
    },
   
    mounted() {
        this.getFinanceAccount();
        this.type_of_banks='all'
        this.account='all'
    },

    methods: {

        async getFinanceAccount(page = 1) {
            this.isLoading=true;
            try {
                const response = await api.get(`/finance_account?page=${page}&limit=${this.limit}`);
                this.financeAccounts = response.data.financeAccounts.data;
                this.totalPages = response.data.financeAccounts.last_page;
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching finance Account:', error);
            }finally{
                this.isLoading=false;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getCustomers(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getCustomers(this.currentPage + 1); // Update the page parameter
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getFinanceAccount(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getFinanceAccount(this.currentPage + 1); // Update the page parameter
            }
        },
        async getcurrencies() {
            try {
                await api.get('/currencies').then((response) => {
                        this.currencies = response.data.currencies;
                    
                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },
        async get_edit_currencies() {
           try {
            const response = await api.get('/currencies');
            this.edit_currencies = response.data.currencies.data;
           } catch (error) {
            console.log(error.message);
           }
        },
        openEditModal() {
            this.edit_showModal = true;
            this.get_edit_currencies();

        },
        closeModal() {
            this.edit_showModal = false;
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'بستن'
            })
        },
        async editfinanceAccount(id) {
            const response = await api.get(`/finance_account/${id}`);
            // console.log("finance Account response",response.data);
            this.editFinance = response.data;

            this.openEditModal();
            this.editAccountName = this.editFinance.account_name;
            this.editType = this.editFinance.type
            this.editCurrency = this.editFinance.currency
            // console.log("this.editFinance.finance_currency.currency",this.editFinance);
            this.editDescription = this.editFinance.description
            this.editAccountType = this.editFinance.account
            //    console.log("inside this.editAccountType ", this.editAccountType);
        },
        async submitEditedForm(id) {
            try {
                const responseUpdate = await api.put(`/finance_account/${id}`, {
                    account_name: this.editAccountName,
                    type: this.editType,
                    currency: this.editCurrency,
                    description: this.editDescription,
                    // user_id: this.user_id,
                    account: this.editAccountType
                });
                    
                if (responseUpdate.data != null) {
                    console.log('responseUpdate.data != null')
                    if (responseUpdate.data.status === false) {
                        if (responseUpdate.data.message != null) {
                            this.showalert(responseUpdate.data.message, "error", "error");
                            // console.log('responseUpdate.data.message != null')
                        } else {
                            this.errors = responseUpdate.data.error;
                            console.log("Errors", this.errors);
                            console.log("status false");

                        }

                    } else {
                        // console.log('  this.financeAccounts.push(responseUpdate.data.new_data)')
                        // this.financeAccounts.push(responseUpdate.data.new_data);
                        this.account_name = '';
                        this.type = '';
                        this.currency = '';
                        this.description = '';
                        this.user_id = '';
                        this.status = '';
                        this.edit_showModal = false;
                        this.showalert("حساب با موفقبت ویرایش شد", "موفقانه", "success");
                    }

                }
            } catch (error) {
                console.log(error);
                this.showalert('حساب با موفقیت ویرایش نشد!', "ناموفقانه", "error");
            }
            this.edit_showModal = false;
            this.getFinanceAccount();

        },

        async deleteFinanceAccount(id) {
            if (!window.confirm('آیا میخواهید که حساب حذف شود؟')) {
                return;
            } else {
                try {
                    console.log("inside try");
                    const response = await api.delete(`/finance_account/${id}`);
                    this.financeAccounts = response.data;
                    if (response.status === 204) {
                        this.showalert('حساب با موفقیت حذف شد!', 'موفقانه', 'success');
                        this.getFinanceAccount();
                    }

                } catch (error) {
                    // console.log("inside catch");
                    this.showalert('حساب با موفقیت حذف نشد!', 'ناموفقانه', 'error');
                }
            }
        },

        async searchData() {
            const response = await api.post('/searchfinanceaccount', {
                query: this.searchQuery
            });
            this.financeAccounts = response.data;
        },
        async financetypefilter() {
            const response = await api.post('/financetypefilter', {
                type:this.type_of_banks ,
                account:this.account,
            });
            this.financeAccounts = response.data.financeAccounts.data;
            // console.log(this.financeAccounts);
        },
    },
}
</script>
