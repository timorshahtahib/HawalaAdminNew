<template>
    <div class="col-sm-4 bg-red" style="
    margin-top: -52px;
">
        <div class="search-box me-2 mb-2 d-inline-block">
            <div class="position-relative">
                <input type="text" class="form-control" v-model="searchQuery" 
                placeholder="جستجوی خرج و مخارج..." @input="searchData"/>
                <i class="bx bx-search-alt search-icon"></i>
            </div>
        </div>
    </div>
<!-- edit modal start -->
<div class="col-sm-8">
    <div class="text-sm-end">
        <b-modal v-model="showModal" title="ویرایش خرج و مخارج" title-class="text-black font-18" body-class="p-3" hide-footer>
            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
}}</b-alert>
            <form @submit.prevent="submitEditedForm">
                <div class="row flex justify-between">
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">

                            <div class="mb-3">
                                <label class="form-control-label px-3">نوعیت</label>
                                <select v-model="editType" id="" class="form-control" required>
                                    <option value="expense">مصرف</option>
                                    <option value="income">درآمد</option>
                                </select>
                                   
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">مقدار</label>
                                <input type="text" id="editAmount" v-model="editAmount" placeholder="مقدار..." class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">

                                <label class="form-control-label px-3">واحد پولی</label>
                                <select v-model="editCurrency" class="form-control" required>
                                    <option v-for="curr in edit_currencies" :key="curr.id" :value="curr.id">{{curr.name}} {{curr.sign}}</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">مقدار معادل</label>
                                <input type="text" id="editAmount_equal" v-model="editAmount_equal" placeholder="مقدار معادل..." class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">حالت</label>
                                <select v-model="editState" class="form-control" required>
                                    <option value="pending">Pending</option>
                                    <option value="payed">Payed</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <label for="factore_date">تاریخ :
                            </label>
                            <div class="input-group ">
                                <!-- persian data picker -->
                                <date-picker @select="edit_select" mode="single" type="date" locale="fa" :column="1" required>
                                </date-picker>
                                <span class="text-center">{{editDate}}</span>
                            </div>
                            <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="mb-3">
                            <label class="form-control-label px-3">توضیحات</label>
                            <textarea v-model="editDesc" id="desc" cols="30" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                 
                </div>

                <div class="text-end pt-5 mt-1 g-2">
                    <b-button variant="danger" @click="closeModal">بستن</b-button>
                    <b-button type="submit" variant="success" class="ms-1 ml-2">آپدیت</b-button>
                </div>
            </form>
        </b-modal>
    </div>
</div>
<!-- edit modal end -->
<div class="table-responsive" v-if="IncomeExpenses.length">
  
    <table class="table table-centered table-nowrap">
        <thead>
            <tr>
                <th scope="col">آیدی</th>
                <th scope="col">نوعیت</th>
                <th scope="col">مقدار</th>
                <th scope="col">پول</th>
                <th scope="col">مقدار معادل</th>
                <th scope="col">پول معادل</th>
                <th scope="col">تاریخ</th>
                <th scope="col">آیدی ترانزکشن</th>
                <th scope="col">آیدی فایننس اکانت</th>
                <th scope="col">آیدی کاربر</th>
                <th scope="col">ریفرنس تایپ</th>
                <th scope="col">حالت</th>
                <th scope="col">وضیعت</th>
                <th scope="col">توضیحات</th>
                <th scope="col">اکشن</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="IncomeExpense in IncomeExpenses" :key="IncomeExpense.id">
           
                <td>{{ IncomeExpense.id }}</td>
                <td>{{ IncomeExpense.type }}</td>
                <td>{{ IncomeExpense.amount }}</td>
                <td>{{ IncomeExpense.currency }}</td>
                <td>{{ IncomeExpense.amount_equal }}</td>
                <td>{{ IncomeExpense.currency_equal }}</td>
                <td>{{ IncomeExpense.date }}</td>
                <td>{{ IncomeExpense.transaction_id }}</td>
                <td>{{ IncomeExpense.finance_acount_id }}</td>
                <td>{{ IncomeExpense.user_id }}</td>
                <td>{{ IncomeExpense.ref_type }}</td>
               
                <td>
                    <span class="badge  font-size-12" :class="IncomeExpense.state === 'payed' ? 
                    'bg-success': IncomeExpense.state === 'unpaid'?  'bg-danger' : 'bg-warning'">
                    {{ IncomeExpense.state }}
                </span>
               </td>
                <td>
                    <span class="badge  font-size-12" :class="IncomeExpense.status === 0 ? 'bg-warning' :'bg-primary'">
                        <i class="mdi mdi-star me-1"></i>
                        {{ IncomeExpense.status }}
                    </span>
                </td>
                <td>{{ IncomeExpense.desc }}</td>

                <td>
                  

                    <button class="btn btn-xs">
                            <i class="fas fa-pencil-alt text-success me-1" @click="editIncomeExpense(IncomeExpense.id)"></i>
                        </button>

                        <button class="btn btn-xs">
                            <i class="fas fa-trash-alt text-danger me-1" @click="deleteIncomeExp(IncomeExpense.id)"></i>
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
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2'
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
export default {
    name: 'financeAccountTable',
    components:{
        DatePicker,
    },
    data() {
        return {
            showModal: false,
            searchQuery: '',
            // edit modal
            IncomeExpenses: [],
            editType: '',
            editAmount: '',
            editCurrency: '',
            editAmount_equal: '',
            editCurrency_equal: '',
            editDate: '',
            transaction_id: '',
            finance_acount_id: '',
            user_id: '',
            ref_type: '',
            editState: '',
            editDesc: '',
            errors: {},
            stateError: null,
            edit_currencies:[],
            // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,

        }
    },
    mounted() {
        this.getIncomeExp();
    },

    methods: {
        edit_select(date) {
       this.editDate = date.toString();
          },

          openModal() {
            this.showModal = true;
        },
        openModaledit() {
            this.showModal = true;
            this.get_edit_Currencies();
        },
        closeModal() {
            this.showModal = false;
        },
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'OK'
            })
        },
        async getIncomeExp(page = 1) {
            try {
                const response = await axios.get(`/api/income_expense?page=${page}&limit=${this.limit}`);
                this.IncomeExpenses = response.data.IncomeExpenses.data;
                this.totalPages = response.data.IncomeExpenses.last_page;
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching IncomeExpenses:', error);
            }
        },
        async get_edit_Currencies() {
            try {
                const response = await axios.get('/api/currencies');
                this.edit_currencies = response.data.currencies.data;
            } catch (error) {
                console.log(error.message);
            }

        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getIncomeExp(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getIncomeExp(this.currentPage + 1); // Update the page parameter
            }
        },
       
        async editIncomeExpense(id) {
           
            const response = await axios.get(`/api/income_expense/${id}`);
           
            this.editIncomeExp = response.data;
            this.editType = this.editIncomeExp.type;
            this.openModaledit();
            this.editAmount = this.editIncomeExp.amount;
            this.editCurrency = this.editIncomeExp.currency;
            this.editAmount_equal = this.editIncomeExp.amount_equal
            this.editCurrency_equal = this.editIncomeExp.currency_equal;
            this.editDate = this.editIncomeExp.date;
            this.editState = this.editIncomeExp.state
            this.editDesc = this.editIncomeExp.desc

        },

        async submitEditedForm() {
            let id= this.editIncomeExp.id;
    
            try {
                const response = await axios.put(`/api/income_expense/${id}`, {
                    type: this.editType,
                    amount: this.editAmount,
                    currency: this.editCurrency,
                    amount_equal: this.editAmount_equal,
                    // currency_equal: this.currency_equal,
                    date: this.editDate,
                    state: this.editState,
                    desc: this.editDesc,
                });
                
                if (response.status) {
                    this.errors = {}
                        this.editType='';
                        this.editAmount='';
                        this.editCurrency='';
                        this.editAmount_equal='';
                        this.editCurrency_equal='';
                        this.editDate= null;
                        this.editState='';
                        this.editDesc='';
                        this.showModal=false;
                    this.showalert('خرج و مخارج با موفقیت ویرایش شد!', 'ادامه دهید', 'success');
                    
                }

            } catch (error) {
                console.log(error);
                this.showalert('خرج و مخارج با موفقیت ویرایش نشد!', 'Error', 'error');
            }
            this.getIncomeExp();

        },

        async deleteIncomeExp(id) {

            if (!window.confirm('آیا میخواهید که خرج و مخارج حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await axios.delete(`/api/income_expense/${id}`);
                    this.IncomeExpenseSearch = response.data;
                    if (response.status === 204) {
                        this.showalert('خرج و مخارج با موفقیت حذف شد!', 'ادامه دهید', 'success');
                        this.getIncomeExp();
                    }

                } catch (error) {
                    this.showalert('خرج و مخارج با موفقیت حذف نشد!', 'ادامه دهید', 'error');
                }
            }
        },
        async searchData() {
            const response = await axios.post(`/api/searchincomexpenses`, {
                query: this.searchQuery
            });
            this.IncomeExpenses = response.data;
        },

    },
}
</script>
