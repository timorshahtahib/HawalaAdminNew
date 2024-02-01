<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import pendingOrderTable from './pendingOrderTable.vue'
import axios from 'axios';

/**
 * Customers component
 */
export default {
  components: { Layout, PageHeader,pendingOrderTable },
  data() {
    return {
       
      title: "لیست سفارشات در حال تائید",
      items: [
        {
          text: "داشبورد",
          href: "/"
        },
        {
          text: "سفارشات",
          active: true
        }
      ],


    };
  },
 
  methods: {
   
       
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
              <div class="col-sm-4">
                <div class="search-box me-2 mb-2 d-inline-block">
                  <div class="position-relative">
                    <input type="text" class="form-control" placeholder="جستجوی سفارش..." />
                    <i class="bx bx-search-alt search-icon"></i>
                  </div>
                </div>
              </div>

            </div>
              <pendingOrderTable />
          
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
