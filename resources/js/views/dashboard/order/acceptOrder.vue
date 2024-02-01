<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";
import acceptOrderTable from './acceptOrderTable.vue'
import axios from 'axios';

/**
 * Customers component
 */
export default {
  components: { Layout, PageHeader,acceptOrderTable },
  data() {
    return {
       
      title: " لیست سفارشات تائید شده",
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
                    <input type="text" class="form-control" placeholder="جستجوی سفارشات..." />
                    <i class="bx bx-search-alt search-icon"></i>
                  </div>
                </div>
              </div>

            </div>
              <acceptOrderTable />
          
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
