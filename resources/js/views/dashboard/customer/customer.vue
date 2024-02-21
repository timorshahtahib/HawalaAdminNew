<template>
<Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
        <div class="col-12">
            <div class="card h-100" style="min-height:100vh">
                <div class="card-body">
                    <div class="row mb-2">
                   
                       
                        <!-- end col-->
                    </div>
                        <customerTable />
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import customerTable from './customerTable.vue'
import axios from 'axios';
import Swal from 'sweetalert2'
/**
 * Customers component
 */
export default {
    components: {
        Layout,
        PageHeader,
        customerTable
    },
    data() {
        return {
            // customers: [],
            
            title: "لیست مشتریان",
            items: [{
                    text: "مشتری",
                    href: "/"
                },
                {
                    text: "مشتری",
                    active: true
                }
            ],
           
        };
    },
 
    methods: {
    
    },
};
</script>