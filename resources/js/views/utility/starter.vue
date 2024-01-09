<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * Starter component
 */
export default {
  components: { Layout, PageHeader },
  data() {
    return {
      title: "Starter Page",
      items: [
        {
          text: "Utility",
          href: "/"
        },
        {
          text: "Starter Page",
          active: true
        }
      ]
    };
  }
};
</script>
<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
  </Layout>
</template>