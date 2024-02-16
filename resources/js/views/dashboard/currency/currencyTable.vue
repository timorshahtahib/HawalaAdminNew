<template>
<!-- start edit modal col-->
<div class="col-sm-12">
    <div class="text-sm-end">

        <b-modal v-model="showModal" title="ویرایش کردن واحد پولی جدید" title-class="text-black font-18" body-class="p-3" hide-footer>
            <b-alert v-model="isError" class="mb-4" variant="danger" dismissible>{{ this.formError
            }}</b-alert>
            <form @submit.prevent="editCucurrencyForm">
                <div class="row flex justify-between">
                    <div class="row flex justify-between">
                        <div class="col-md-6 col-sm-12 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">نام واحد پولی<span class="text-danger">*</span></label>
                                <input type="text" id="editCurrencyName" v-model="editCurrencyName" placeholder="نام واحد پولی..." class="form-control" />
                                <p v-if="editCurrencyNameError" class="text-danger">{{ editCurrencyNameError }}</p>
                                <span class="text-danger error-text afrad_error" v-if="errors.name">{{errors.name[0]}}</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label class="form-control-label px-3">نشان</label>
                                <input type="text" id="editCurrencySign" v-model="editCurrencySign" placeholder="نشان..." class="form-control">
                                <p v-if="editCurrencySignError" class="text-danger">{{ t }}</p>
                                <span class="text-danger error-text afrad_error" v-if="errors.sign">{{errors.sign[0]}}</span>
                            </div>
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
<!-- end edit modal col-->
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
<div v-if="isLoading">
    <Loader/>
  </div>
        <div v-else>
            <div class="table-responsive" v-if="currencies.length">
    
                <table class="table table-centered table-nowrap">
                    <thead>
                        <tr>
                            <th>آیدی</th>
                            <th>واحد پولی</th>
                            <th>نشان</th>
                            <th>وضعیت</th>
                            <th>اکشن</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="currency in currencies" :key="currency.id">
                            <td>
                               {{ currency.id }}
                            </td>
                            <td>{{ currency.name }}</td>
                            <td>{{ currency.sign }}</td>
                            <td>
                                <span class="badge  font-size-12" :class="currency.status === 0 ? 'bg-warning' :'bg-primary'">
                                    <i class="mdi mdi-star me-1"></i>
                                    {{ currency.status }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-xs">
                                    <i class="fas fa-pencil-alt text-success me-1" @click="editCurrencyFunction(currency.id)"></i>
                                </button>
            
                                <button class="btn btn-xs">
                                    <i class="fas fa-trash-alt text-danger me-1" @click="deleteCurrency(currency.id)"></i>
            
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
import axios from 'axios';
import Swal from 'sweetalert2';
import Loader from '../../loader/loader.vue'
import api from '../../../services/api';
export default {
    name: 'currencyTable',
    components:{Loader},
    data() {
        return {
            isLoading:false,
            showModal: false,
            currencies: [],
            searchQuery:'',
            // edit modal
            editCurrencyName: '',
            editCurrencyNameError: '',
            editCurrencySign: '',
            editCurrencySignError: '',
            errors: {},
               // pagination
            currentPage: 1,
            totalPages: 1,
            limit: 10,
        }
    },
    mounted() {
        this.getCurrencies();
    },

    methods: {
        showalert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                confirmButtonText: 'بستن'
            })
        },

        closeModal() {
            this.showModal = false;
        },
        async getCurrencies(page = 1) {
            this.isLoading=true;
            try {
             
                const response = await api.get(`/currencies?page=${page}&limit=${this.limit}`);
                this.currencies = response.data.currencies.data;
                this.totalPages = response.data.currencies.last_page;
                // console.log("Currency",response);
                this.currentPage = page; // Update the current page
            } catch (error) {
                console.error('Error fetching Currency:', error);
            }finally{
                this.isLoading=false;
            }

        },
        prevPage() {
            if (this.currentPage > 1) {
                this.getCurrencies(this.currentPage - 1); // Update the page parameter
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.getCurrencies(this.currentPage + 1); // Update the page parameter
            }
        },
        openEditModal() {
            this.showModal = true;
        },
        async editCurrencyFunction(id) {
            const response = await axios.get(`/api/currencies/${id}`);
            this.editCurr = response.data;
            this.openEditModal();
            this.editCurrencyName = this.editCurr.name;
            this.editCurrencySign = this.editCurr.sign;
        },

     
        async editCucurrencyForm() {
            let id = this.editCurr.id;
            const response = await axios.post(`/api/updatecurrency`, {
              name : this.editCurrencyName,
              sign : this.editCurrencySign,
              id:id
            });
            // console.log(this.response.data);
            if (response.data != null) {
                if (response.data.status === false) {
                    if (response.data.message != null) {
                        this.showalert(response.data.message, "خطا", "error");
                    } else {
                        this.errors = response.data.error;

                    }
                } else {
                    this.errors = {};
                    this.editCurrencyName = null;
                    this.editCurrencySign = null;
                     this.getCurrencies();
                    this.showalert("واحد پولی  با موفقیت ویرایش شد!", 'موفقانه', 'success');
                }
                // console.log("Currency updated successfully");   
            } else {
                this.errors = {};
                this.closeModal();
                this.showalert(response.data.message, "success", "success");
            }

            this.showModal = false;
           

        },

        async deleteCurrency(id) {
            if (!window.confirm('آیا میخواهید که مشتری حذف شود؟')) {
                return;
            } else {
                try {
                    const response = await axios.delete(`/api/currencies/${id}`);
                    this.customerSearch = response.data;
                    if (response.status === 204) {
                        this.showalert('واحد پولی با موفقیت حذف شد!', 'موفقانه', 'success');
                        this.getCurrencies();
                    }

                } catch (error) {
                    this.showalert('واحد پولی با موفقیت حذف نشد!', 'نا موفقانه', 'error');
                }
            }
        },
        async searchData() {
            const response = await axios.post('/api/searchcurrency', {
                query: this.searchQuery
            });
            // console.log(response.data);
            this.currencies = response.data;
          
        },

    },
}
</script>
