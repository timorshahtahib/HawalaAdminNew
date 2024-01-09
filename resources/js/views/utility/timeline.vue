<script>

import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * Timeline component
 */
export default {
  components: {
    Layout,
    PageHeader,
  },
  data() {
    return {
      title: "Timeline",
      items: [
        {
          text: "Utility",
          href: "/"
        },
        {
          text: "Timeline",
          active: true
        }
      ]
    };
  },
};
</script>

<template>
  <Layout>
  <PageHeader :title="title" :items="items" />

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-5">Vertical Timeline</h4>
            <div class>
              <ul class="verti-timeline list-unstyled">
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle"></i>
                  </div>
                  <div class="d-flex">
                    <div class="me-3">
                      <i class="bx bx-copy-alt h2 text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <h5>Ordered</h5>
                        <p class="text-muted">New common language will be more simple and regular than the existing.</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle"></i>
                  </div>
                  <div class="d-flex">
                    <div class="me-3">
                      <i class="bx bx-package h2 text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <h5>Packed</h5>
                        <p class="text-muted">To achieve this, it would be necessary to have uniform grammar.</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list active">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                  </div>
                  <div class="d-flex">
                    <div class="me-3">
                      <i class="bx bx-car h2 text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <h5>Shipped</h5>
                        <p class="text-muted">It will be as simple as Occidental in fact, it will be Occidental..</p>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="event-list">
                  <div class="event-timeline-dot">
                    <i class="bx bx-right-arrow-circle"></i>
                  </div>
                  <div class="d-flex">
                    <div class="me-3">
                      <i class="bx bx-badge-check h2 text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                      <div>
                        <h5>Delivered</h5>
                        <p class="text-muted">To an English person, it will seem like simplified English.</p>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>