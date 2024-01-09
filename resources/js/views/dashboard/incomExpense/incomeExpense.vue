<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import axios from 'axios';
import Swal from 'sweetalert2'
import incomeExpenseTable from "./incomeExpenseTable.vue"
import DatePicker from '@alireza-ab/vue3-persian-datepicker';
export default {
    components: {
        Layout,
        PageHeader,
        incomeExpenseTable,
        DatePicker,
    },
    data() {
        return {
            financeAccounts: [],
            currencies: [],
            title: "لیست خرج و مصارف",
            items: [{
                    text: "داشبورد",
                    href: "/"
                },
                {
                    text: "خرج و مخارج",
                    active: true
                }
            ],
            showModal: false,
            submitted: false,
            isError: false,
            formError: "",

            currencies: [],
            type: '',
            amount: '',
            currency: '',
            amount_equal: '',
            currency_equal: '',
            date: new Date().toISOString().slice(0, 10),
            transaction_id: '',
            finance_acount_id: '',
            user_id: '',
            ref_type: '',
            state: '',
            address: '',
            desc: '',
            errors: {},

        };
    },
    mounted() {

    },
    methods: {

        select(date) {
       this.date = date.toString();
          },
        openModal() {
            this.getCurrencies();
            this.type = "expense"
            this.state = "pending"
            this.showModal = true;
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

        /**
         * Modal form submit
         */
        // eslint-disable-next-line no-unused-vars
        async submitForm() {
            try {
                
                const response =  await axios.post('/api/income_expense',{
                    type: this.type,
                    amount: this.amount,
                    currency: this.currency,
                    amount_equal: this.amount_equal,
                    currency_equal: this.currency_equal,
                    date: this.date,
                    // transaction_id: this.transaction_id,
                    transaction_id: 4,
                    // finance_acount_id: this.finance_acount_id,
                    finance_acount_id: 2,
                    // user_id: this.user_id,
                    user_id: 1,
                    // ref_type: this.ref_type,
                    ref_type: 6,
                    state: this.state,
                    desc: this.desc,
                })

               console.log("response ",response.data);
            } catch (error) {
                console.error(error.message);
            }

        },

        async getCurrencies() {
            try {
                const response = await axios.get('/api/currencies');
                this.currencies = response.data.currencies;
            } catch (error) {
                console.log(error.message);
            }

        }

    },
};
</script>

<template>
<Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                    
                        <div class="col-sm-12">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success btn-rounded mb-2 me-2" @click="openModal">
                                    <i class="mdi mdi-plus me-1"></i>خرج و مخارج جدید
                                </button>
                                <b-modal v-model="showModal" title="اضافه کردن خرج و مخارج جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
                                    <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
                    }}</b-alert>
                                    <form @submit.prevent="submitForm">
                                        <div class="row flex justify-between">
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">

                                                    <div class="mb-3">
                                                        <label class="form-control-label px-3">نوعیت</label>
                                                        <!-- <input type="text" id="type" v-bind="type" class="form-control" placeholder="نوعیت...."> -->
                                                        <select v-model="type" id="" class="form-control" required>
                                                            <option value="expense">مصرف</option>
                                                            <option value="income">درآمد</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-control-label px-3">مقدار</label>
                                                        <input type="text" id="amount" v-model="amount" placeholder="مقدار..." class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">

                                                        <label class="form-control-label px-3">واحد پولی</label>
                                                        <select v-model="currency" class="form-control" required>
                                                            <option v-for="curr in currencies" :key="curr.id" :value="curr.id">{{curr.name}} {{curr.sign}}</option>
                                                    
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-control-label px-3">مقدار معادل</label>
                                                        <input type="text" id="currency_equal" v-model="currency_equal" placeholder="مقدار معادل..." class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row flex justify-between">
                                                <div class="col-md-6 col-sm-12 col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-control-label px-3">حالت</label>
                                                        <select v-model="state" class="form-control" required>
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
                                                        <date-picker @select="select" mode="single" type="date" locale="fa" :column="1" required>
                                                        </date-picker>

                                                    </div>
                                                    <span class="text-danger error-text afrad_error" v-if="errors.date">{{errors.date[0]}}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-lg-12">
                                                <div class="mb-3">
                                                    <label class="form-control-label px-3">توضیحات</label>
                                                    <textarea v-model="desc" id="desc" cols="30" rows="4" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="address">آدرس</label>
                                                    <textarea v-model="address" id="address" cols="30" rows="4" class="form-control" placeholder="آدرس خود را وارد کنید"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="text-end pt-5 mt-1 g-2">
                                            <b-button variant="danger" @click="closeModal">بستن</b-button>
                                            <b-button type="submit" variant="success" class="ms-1 ml-2">ساختن</b-button>
                                        </div>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <!-- end col-->
                    </div>
                    <incomeExpenseTable />

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
