<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import axios from 'axios';
import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
/**
 * Expense component
 */
export default {
    components: {
        Layout,
        PageHeader,
        DatePicker,
    },
    data() {
        return {
            title: "لیست مصارف",
            items: [{
                    text: "مصرف",
                    href: "/"
                },
                {
                    text: "لیست مصارف",
                    active: true
                }
            ],
            showModal: false,
            searchQuery: '',
            financeAccounts: [],
            selectedFinanceAccount: '',
            gettedFinanceCurrencyId: [],
            selectedCurrency: '',

            banks: [],
            selectedDakhl: '',

            ExpenseList: [],

            // for persian datepicker
            rasid_date: "",
            errors: {},
            // pagination
            limit: 10,
            currentPage: 1,
            totalPages: 0,

            // edit for financeAccount
            editFinanceAccounts: [],
            editfinmodel: '',

            // edit for currency
            editExpenseExpenseCurrencyModel: '',
            editExpenseCurrecies: [],

            newExpense: [],
            // edit for selected banks
            editselectedDakhls: [],
            editselectedDakhl: '',

            editAmount: '',
            editDate: '',
            editDesc: '',

        };
    },
    mounted() {
        this.getAccounts();
        this.showExpenses();

    },

    methods: {
        select(date) {
            this.rasid_date = date.toString();
        },
        editSelect(date) {
            this.editDate = date.toString();
        },
       
        openModaledit() { 
            this.showModal = true;
           
        },
        closeModal() {
            this.showModal = false;
        },
        async editExpense(id) {
            const response = await axios.get(`/api/showExpense/${id}`);
            this.newExpense = response.data;
            this.openModaledit(this.newExpense);
            this.editAmount = this.newExpense.amount
            this.editDate = this.newExpense.date
            this.editDesc = this.newExpense.desc
            this.getAccountForEdit(this.newExpense.expense_acount.id);
            this.getBanksForEdit(this.newExpense.expense_bank.id)
            this.editExpenseExpenseCurrencyModel = this.newExpense.expense_currency.id;
            // console.log("this.editExpenseExpenseCurrencyModel ",this.editExpenseExpenseCurrencyModel );
        },

        // showing data in the table
        async showExpenses(page = 1) {

            try {
                const response = await axios.get(`/api/showExpenses?page=${page}&limit=${this.limit}`);
                this.ExpenseList = response.data.expenses.data;
                this.totalPages = response.data.total_pages;
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching IncomeExpenses:', error);
            }
         
        },
     
        prevPage() {
            if (this.currentPage > 1) {
                this.showExpenses(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.showExpenses(this.currentPage + 1); // Update the page parameter
            }
        },

        // for showing the showalert modal
        showalert(title, icon, confirmButtonText) {
            Swal.fire({
                title: title,
                icon: icon,
                confirmButtonText: confirmButtonText,
            });
        },
        // for selecting the FinanceAccounts in insert form
        async getAccounts() {
            try {
                const response = await axios.get('/api/expenses');
                this.financeAccounts = response.data.financeAccounts;
                // console.log("this.financeAccounts",this.financeAccounts);
            } catch (error) {
                console.log(error.message);
            }
        },
     
        // for getting the id in modal
        getAccountForEdit(id) {

            axios.get('/api/expenses')
                .then(response => {
                    // Assuming the API response is an array of objects with 'value' and 'label' properties
                    this.editFinanceAccounts = response.data.financeAccounts;
                    this.editfinmodel = this.editFinanceAccounts.length > 0 ? this.editFinanceAccounts.find(currency => currency.id == id).id : '';

                })
                .catch(error => {
                    console.error('Error fetching currency data:', error);
                });
        },
        // for selecting the bank in modal
        async getBanksForEdit(selectedUserid) {
            // console.log("In getAccountForEidt: ",this.editfinmodel);
            const response = await axios.get('/api/financeAccWithCurrency/' + selectedUserid);
            this.editselectedDakhls = response.data.banks;
            this.editselectedDakhl = this.editselectedDakhls.length > 0 ? this.editselectedDakhls.find(bank => bank.id == selectedUserid).id : '';
        },

        // for updating the currency and dakhls in modal
        async updateEditedAccount() {
            try {
                const response = await axios.get('/api/financeAccWithCurrency/' + this.editfinmodel);
                this.editExpenseCurrecies = response.data.financeAccCurrencies;
                this.newExpense.expense_currency.id = this.editExpenseCurrecies.id;
                this.newExpense.expense_currency.name = this.editExpenseCurrecies.name;
                this.editselectedDakhls = response.data.banks;

                this.editselectedDakhl = this.editselectedDakhls.length > 0 ? this.editselectedDakhls.find(bank => bank.id == editselectedDakhls[0].id).id : '';

          
            } catch (error) {
                console.log(error.message);
            }
        },

        // it's for selecting the currency automatically from the finAccount
        async updateCurrencySelect() {
            try {
                const response = await axios.get('/api/financeAccWithCurrency/' + this.selectedFinanceAccount);
                this.gettedFinanceCurrencyId = response.data.financeAccCurrencies;
                this.selectedCurrency = this.gettedFinanceCurrencyId.id;
                this.banks = response.data.banks;
                this.selectedDakhl = this.banks[0].id;

            } catch (error) {
                console.log(error.message);
            }

        },

        // for adding new Expense  
        async storeExpense() {

            try {
                const response = await axios.post('/api/storeExpense', {
                    // type: "expense",
                    amount: this.amount,
                    currency: this.selectedCurrency,
                    amount_equal: this.amount,
                    currency_equal: this.selectedCurrency,
                    date: this.rasid_date,
                    transaction_id: 3,
                    finance_acount_id: this.selectedFinanceAccount,
                    bank_id: this.selectedDakhl,
                    user_id: 3,
                    ref_type: 2,
                    desc: this.desc
                });

                if (response.data != null) {

                    // console.log("in data!=null");
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "1توجه!");
                        } else {
                            this.errors = response.data.error;
                            console.log("Errors", this.errors);
                            console.log("status false");
                        }

                    } else {
                       

                        this.errors = {};
                        this.getAccounts();
                        this.ExpenseList.push(response.data.new_data);
                        this.type = null
                        this.amount = null
                        this.currency = null,
                        this.amount_equal = null,
                        this.currency_equal = null,
                        this.date = null,
                        this.transaction_id = null,
                        this.finance_acount_id = null,
                        this.user_id = null,
                        this.ref_type = null,
                        this.state = null,
                        this.desc = null
                        this.showalert(response.data.message, "success", "موفقانه ساخته شد");
                    }

                }

            } catch (error) {
                console.log(error.message);
            }

        },
        async submitEditedForm(id) {

            try {
                const response = await axios.post('/api/updateExpense', {
                    id: this.newExpense.id,
                    amount: this.editAmount,
                    currency: this.editExpenseExpenseCurrencyModel,
                    date: this.editDate,
                    finance_acount_id: this.editfinmodel,
                    bank_id: this.editselectedDakhl,
                    desc: this.editDesc,
                });
    
                if (response.data != null) {

                    // console.log("in data!=null");
                    if (response.data.status === false) {

                        if (response.data.message != null) {
                            this.showalert(response.data.message, "error", "هشدار");
                        } else {
                            this.errors = response.data.error;
                            console.log("Errors", this.errors);
                            // console.log("status false");
                        }

                    } else {
                        // console.log("else true");

                        // this.errors = {};
                        // this.getAccounts();
                        this.ExpenseList.push(response.data.new_data);

                        this.showalert(response.data.message, "success", "موفقانه");
                    }

                }

            } catch (error) {
                console.log("catch error", error.message);
            }
            this.showModal = false;
            this.showExpenses();

        },

        async deleteExpense(id) {
            if (!window.confirm('آیا میخواهید که ترانزکشن حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await axios.post(`/api/deleteExpense`, {
                        id: id
                    });
                    this.expenseSearch = response.data;
                    if (response.status === 204) {
                        this.showalert('ترانزکشن با موفقیت حذف شد!', 'success', 'موفقانه حذف شد');
                        this.ExpenseList.pop(id);
                        this.showExpenses();
                    }

                } catch (error) {
                    this.showalert('ترانزکشن با موفقیت حذف نشد!', 'ادامه دهید', 'error');
                }
            }
        },

        async searchData() {
            const response = await axios.post('/api/searchexpense', {
                query: this.searchQuery
            });

            this.ExpenseList = response.data;
            // console.log("this.ExpenseList",this.ExpenseList);
        },
    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
          
           
                <!-- edit modal start -->
                <div class="col-sm-8">
                    <div class="text-sm-end">
                        <b-modal v-model="showModal" title="ویرایش مصرف" title-class="text-black font-18" body-class="p-3" hide-footer>
                            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
        }}</b-alert>

                            <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="submitEditedForm">
                                <div class="form-group">
                                    <div class="col-sm-12 col-xs-12">
                                        <label for="supplier">انتخاب حساب :</label>
                                        <select class="form-control form-control-lg " v-model="editfinmodel" style="width: 100%;" @change="updateEditedAccount" required>
                                            <option v-for="finaceAcc in editFinanceAccounts" :key="finaceAcc.id" :value="finaceAcc.id">
                                                {{ finaceAcc.account_name }}
                                            </option>

                                        </select>
                                        <span class="text-danger error-text afrad_error" v-if="errors.finance_acount_id">{{errors.finance_acount_id}}</span>
                                    </div>

                                  <div class="row">
                                    <div class="col-sm-5 col-xs-12">
                                        <label for="name">مبلغ :‌</label>
                                        <input type="number" v-model="editAmount" class="form-control" required>
                                        <span class="text-danger error-text afrad_error" v-if="errors.amount">{{errors.amount[0]}}</span>
                                    </div>
                                    <div class="col-sm-7 col-xs-12">
                                        <label for="supplier">واحد پول :
                                        </label>
                                       <select class="form-control form-control-lg" v-model="editExpenseExpenseCurrencyModel" required>

                                        <option :key="newExpense.expense_currency?.id" :value="newExpense.expense_currency?.id">
                                                {{ this.newExpense.expense_currency?.name }}
                                            </option>
                                        </select>
                                    </div>
                                  </div>

                                   <div class="row">
                                    <div class="col-sm-5 col-xs-12">
                                        <label for="supplier">انتخاب دخل :
                                        </label>
                                        <select class="form-control form-control-lg" id="dakhl"  v-model="editselectedDakhl" required>
                                            <option disabled>ابتدا حساب را انتخاب کنید.</option>
                                            <option v-for="bank in editselectedDakhls" :key="bank.id" :value="bank.id">
                                                {{ bank.account_name }}
                                            </option>

                                        </select>
                                        <span class="text-danger error-text afrad_error" v-if="errors.bank_id">{{errors.bank_id[0]}}</span>
                                    </div>
                                    <div class="col-sm-7 col-xs-12">
                                        <label for="factore_date">تاریخ :
                                        </label>
                                        <div class="input-group gap-2 ">

                                            <!-- @alireza-ab/vue3-persian-datepicker -->
                                            
                                            <date-picker @select="editSelect" mode="single" type="date" locale="fa" :column="1" required></date-picker>
                                            <span class="text-center" v-if="editDate">{{editDate}}</span>
                                        </div>
                                        <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>

                                    </div>
                                   </div>
                                    <div class="col-sm-12 col-xs-12">
                                        <br>

                                        <textarea id="desc" autocomplete="on" class="form-control" v-model="editDesc" rows="4" placeholder="توضیحات"></textarea>
                                        <span class="text-danger error-text disc_error" v-if="errors.desc">{{errors.desc[0]}}</span>

                                    </div>

                                </div>
                                    <div class="text-end pt-2 mt-1 g-2">
                                        <b-button variant="danger" @click="showModal = false">بستن</b-button>
                                        <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                                    </div>
                            
                            </form>
                           

                        </b-modal>
                    </div>
                </div>
                <!-- edit modal end -->

                <div class="card-body">
                    <h4 class="card-title mb-4">مصرف جدید :</h4>

                    <!-- <div class="table-responsive"> -->
                    <div>
                        <form id="category_insert" autocomplete="on" class="form-horizontal form-label-left" @submit.prevent="storeExpense">
                            <div class="form-group">
                                <div class="col-sm-12 col-xs-12">
                                    <label for="supplier">انتخاب حساب :</label>
                                    <select class="form-control form-control-lg " v-model="selectedFinanceAccount" style="width: 100%;" @change="updateCurrencySelect" required>
                                        <option disabled selected value=""> حساب را انتخاب کنید</option>
                                        <option v-for="financeAccount in financeAccounts" :value="financeAccount.id" :key="financeAccount.id">
                                            {{ financeAccount.account_name }}
                                        </option>
                                    </select>
                                    <span class="text-danger error-text afrad_error" v-if="errors.finance_acount_id">{{errors.finance_acount_id[0]}}</span>

                                </div>
                              <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <label for="name">مبلغ :‌</label>
                                    <input type="number" id="amount" v-model="amount" class="form-control" required>
                                    <span class="text-danger error-text afrad_error" v-if="errors.amount">{{errors.amount[0]}}</span>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <label for="supplier">واحد پول :
                                    </label>
                                    <select class="form-control form-control-lg required" v-model="selectedCurrency" style="width: 100%;" required>
                                        <!-- <option disabled>واحد</option> -->
                                        <option :key="gettedFinanceCurrencyId.id" :value="gettedFinanceCurrencyId.id">
                                            {{ gettedFinanceCurrencyId.name }}
                                        </option>
                                    </select>
                                    <!-- <span class="text-danger error-text afrad_error" v-if="errors.bank_id">{{errors.bank_id}}</span> -->
                                </div>
                              </div>

                               <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label for="supplier">انتخاب دخل :
                                    </label>
                                    <select class="form-control form-control-lg" id="dakhl" style="width: 100%;" v-model="selectedDakhl" required>
                                        <option disabled>ابتدا حساب را انتخاب کنید.</option>
                                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                                            {{ bank.account_name }}
                                        </option>
                                    </select>
                                    <span class="text-danger error-text afrad_error" v-if="errors.bank_id">{{errors.bank_id[0]}}</span>
                                </div>
                                <div class="col-sm-8 col-xs-12">
                                    <label for="factore_date">تاریخ :
                                    </label>
                                    <div class="input-group ">

                                        <!-- @alireza-ab/vue3-persian-datepicker -->
                                        <date-picker @select="select" mode="single" type="date" locale="fa" :column="1" required></date-picker>
                                    </div>
                                    <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>

                                </div>

                               </div>
                                <div class="col-sm-12 col-xs-12">
                                    <br>
                                    <textarea id="desc" autocomplete="on" class="form-control" v-model="desc" rows="4" placeholder="توضیحات"></textarea>
                                    <span class="text-danger error-text disc_error" v-if="errors.desc">{{errors.desc[0]}}</span>

                                </div>

                            </div>
                            <div class="text-end pt-2 mb-2 mt-1 g-2">
                              
                                <b-button type="submit" variant="primary" class="ms-1 ml-2">ساختن</b-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->

        <div class="col-xl-8">
            <div class="card">
                
                <div class="card-body">
                    <div class="col-sm-4">
                        <div class="search-box me-2 mb-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="جستجوی خرج..." @input="searchData"/>
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">

                            <div class="table-responsive" v-if="ExpenseList.length">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th>آیدی</th>
                                            <th class="text-center">تاریخ</th>
                                            <th class="text-center">حساب</th>
                                            <th class="text-center">نوع</th>
                                            <th class="text-center">مقدار پول</th>
                                            <th class="text-center">واحد</th>
                                            <th class="text-center">دخل</th>
                                            <th class="text-center">تفصیلات</th>
                                            <th class="text-center">توسط</th>
                                            <th class="text-center">عملیه</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="expenesel in ExpenseList" :key="expenesel.id" style="text-center">
                                        
                                            <td>{{expenesel.id}}</td>
                                            <td>{{expenesel.date}}</td>
                                            <td>{{expenesel.expense_acount?.account_name}}</td>
                                            <td>{{expenesel.type ? "مصرف" :""}}</td>
                                            <td>{{expenesel.amount}}</td>
                                            <td>{{expenesel.expense_currency.name}}</td>
                                            <td>{{expenesel.expense_bank?.account_name}}</td>
                                            <td>{{expenesel.desc}}</td>
                                            <td>{{expenesel.user_id}}</td>

                                            <td>
                                             

                                                    <button class="btn btn-xs">
                                                        <i class="fas fa-pencil-alt text-success me-1" @click="editExpense(expenesel.id)"></i>
                                                    </button>

                                                    <button class="btn btn-xs">
                                                        <i class="fas fa-trash-alt text-danger me-1" @click="deleteExpense(expenesel.id)"></i>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

</Layout>
</template>
