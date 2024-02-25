<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

// import api from 'api';
import SweetAlert from "../../../SweetAlert.vue";
import Swal from "sweetalert2";
import Loader from '../../loader/loader.vue'
import api from '../../../services/api';
/**
 * Expense component
 */
export default {
    components: {
        Layout,
        PageHeader,
        Loader
    },
    data() {
        return {
            title: "لیست مشتریان حذف شده",
            items: [{
                    text: "مشتری",
                    href: "/"
                },
                {
                    text: "مشتری",
                    active: true
                }
            ],
            isLoading:false,
            showModal: false,
            searchQuery: '',
            customers: [],
            notFound: false,
            // pagination
            limit: 10,
            currentPage: 1,
            totalPages: 0,


        };
    },
    mounted() {
        this.getCustomers();

    },

    methods: {
      


    

        showalert(title, icon, confirmButtonText) {
            Swal.fire({
                title: title,
                icon: icon,
                confirmButtonText: confirmButtonText,
            });
        },
     
        async getCustomers(page = 1) {
            this.isLoading = true;
            try {
                const response = await api.get(`/deletedcustomer?page=${page}&limit=${this.limit}`);
                this.customers = response.data.customers.data;
                this.totalPages = response.data.customers?.last_page;
                this.currentPage = page; // Update the current page
                // console.log("customers",this.customers);
            }
            catch (error) {
                console.error('Error fetching customers:', error);
            }
            finally {
                this.isLoading = false;
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
        async searchData() {
            try {
                const response = await api.post('/searchdeletedcustomer', {
                    query: this.searchQuery
                });
                this.customers = response.data;
                this.notFound = this.customers.length === 0;
            }
            catch (error) {
                console.log(error.message);
            }
        },
    },
};
</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
    
        <div class="row">
            <div class="col-12">
                <div class="card h-100" style="min-height:100vh">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 bg-red" style="
                            margin-top: -2px;
                        ">
                            <div class="search-box me-2 mb-2 d-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" v-model="searchQuery" placeholder="جستجوی مشتری..." @input="searchData" />
                                    <i class="bx bx-search-alt search-icon"></i>
                                </div>
                            </div>
                        </div>
                           
                            <!-- end col-->
                        </div>
                        <div v-if="isLoading">
                            <Loader/>
                          </div>
                          <div class="table-responsive" v-else>
                    
                            <table class="table table-centered table-nowrap">
                                <thead>
                                    <tr>
                                        <th>آیدی</th>
                                        <th>نام کامل</th>
                                        <th>شماره مسلسل مشتری</th>
                                        <th>شماره تماس</th>
                                        <th>توضیحات</th>
                                        <th>پروفایل کاربر</th>
                                        <th>وضیعت</th>
                                        <th>تغیر وضعیت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="customer in customers" :key="customer.id" style="text-center">
                                        <td>
                                            {{ customer.id }}
                                        </td>
                                        <td>{{ customer.name }}</td>
                                        <td>{{ customer.cu_number }}</td>
                                        <td>{{ customer.phone }}</td>
                                        <td>{{ customer.desc }}</td>
                                        <td>
                                            <router-link class="btn btn-xs btn-primary" :to="`/dashboard/customer/${customer.id}`">پروفایل</router-link>
                                        </td>
                                        <td>
                                            <!-- <span class="badge bg-success font-size-12"> -->
                                            <span class="badge  font-size-12" :class="customer.status === 0 ? 'bg-warning' :'bg-primary'">
                                                <i class="mdi mdi-star me-1"></i>
                                                {{ customer.status }}
                                            </span>
                                        </td>
                        
                                            <td>
                                                <input type="checkbox" id="checkbox" v-model="checked" />
                                                <label for="checkbox">{{ checked }}</label>
                                              
                                            </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div  class="text-center font-size-20" v-if="notFound">
                                نتیجه مورد نظر یافت نشد!
                            </div>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>



<style scoped>
/* Hide default checkbox */
.hidden-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
  }
  
  /* Style for the custom checkbox */
  .custom-checkbox {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-color: #ccc;
    border-radius: 50%;
    margin-right: 10px;
    transition: transform 0.3s ease;
  }
  
  /* Style for the checked state */
  .custom-checkbox.checked {
    background-color: #007bff;
    transform: translateX(20px); /* Move to the right when checked */
  }
  
  /* Label style */
  .checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
  }
  
</style>