<template>
<div class="col-sm-4 bg-red" style="
    margin-top: -52px;
">
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
        <b-modal v-model="showModal" title="ویرایش حساب" title-class="text-black font-18" body-class="p-3" hide-footer>
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
                                    <option v-for="currency in currencies" :key="currency.id" :value="currency.id">{{currency.name}} {{currency.sign}}</option>
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
                    <b-button variant="danger" @click="showModal=false">بستن</b-button>
                    <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                </div>
            </form>
        </b-modal>
    </div>
</div>
<!-- edit modal end -->
<div class="table-responsive" v-if="financeAccounts.length > 0">
    <table class="table table-centered table-nowrap">
        <thead>
            <tr>
             <th>آیدی</th>
             <th>نام حساب</th>
             <th>نوعیت</th>
             <th>پول</th>
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
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'
export default {
    name: 'customerTable',
    data() {
        return {
            showModal: false,
            financeAccounts: [],
            currencies: [],
            searchQuery: '',
            // edit modal
            editAccountName: '',
            editType: '',
            editCurrency: '',
            editDescription: '',
            editAccountType: '',
            errors: {},
           
            // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,
        }
    },
   
    mounted() {
        this.getFinanceAccount();
    },

    methods: {

        async getFinanceAccount(page = 1) {
            try {
                const response = await axios.get(`/api/finance_account?page=${page}&limit=${this.limit}`);
                this.financeAccounts = response.data.financeAccounts.data;
                this.totalPages = response.data.financeAccounts.last_page;
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching finance Account:', error);
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
                await axios.get('/api/currencies').then((response) => {
                        this.currencies = response.data.currencies;
                    
                    })
                    .catch((error) => {
                        console.error('Error fetching currencies:', error);
                    });

            } catch (error) {
                console.error('Error fetching data: ', error.message);
            }
        },

        openEditModal() {
            this.showModal = true;
            this.getcurrencies();

        },
        closeModal() {
            this.showModal = false;
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'خوب'
            })
        },
        async editfinanceAccount(id) {
            // console.log("editfinanceAccount id:",id);
            const response = await axios.get(`/api/finance_account/${id}`);
            console.log("finance Account response",response.data);
            this.editFinance = response.data;

            this.openEditModal(this.editFinance);
            this.editAccountName = this.editFinance.account_name;
            this.editType = this.editFinance.type
            this.editCurrency = this.editFinance.finance_currency.currency
            this.editDescription = this.editFinance.description
            this.editAccountType = this.editFinance.account
            //    console.log("inside editFinanceomer ", this.editDesc);
        },
        async submitEditedForm(id) {
            try {
                const responseUpdate = await axios.put(`/api/finance_account/${id}`, {
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
                            this.showalert(responseUpdate.data.message, "error", "1توجه!");
                            console.log('responseUpdate.data.message != null')
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
                        this.showModal = false;
                        this.showalert("آپدیت حساب", "حساب موفقانه آپدیت شد", "success");
                    }

                }
            } catch (error) {
                console.log(error);
                this.showalert('حساب با موفقیت ویرایش نشد!', 'ادامه دهید', 'error');
            }
            this.showModal = false;
            this.getFinanceAccount();

        },

        async deleteFinanceAccount(id) {
            if (!window.confirm('آیا میخواهید که حساب حذف شود؟')) {
                return;
            } else {
                try {
                    console.log("inside try");
                    const response = await axios.delete(`/api/finance_account/${id}`);
                    this.financeAccounts = response.data;
                    if (response.status === 204) {
                        this.showalert('حساب با موفقیت حذف شد!', 'ادامه دهید', 'success');
                        this.getFinanceAccount();
                    }

                } catch (error) {
                    console.log("inside catch");
                    this.showalert('حساب با موفقیت حذف نشد!', 'ادامه دهید', 'error');
                }
            }
        },

        async searchData() {
            const response = await axios.post('/api/searchfinanceaccount', {
                query: this.searchQuery
            });
            // console.log(response.data);
            this.financeAccounts = response.data;
            // console.log(this.searchQuery.length);
        },
    },
}
</script>
