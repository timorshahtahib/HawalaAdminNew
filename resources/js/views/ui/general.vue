<script>

import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * General-ui component
 */
export default {
  components: { Layout, PageHeader },
  data() {
    return {
      title: "General",
      items: [
        {
          text: "UI Elements",
          href: "/"
        },
        {
          text: "General",
          active: true
        }
      ],
      defaultvalue: 3,
      currentpage: 3
    };
  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <div>
                  <h4 class="card-title">Badges</h4>
                  <p class="card-title-desc">
                    Add any of the below mentioned modifier classes to change
                    the appearance of a badge.
                  </p>
                  <div>
                    <span class="badge bg-primary">Primary</span>
                    <span class="badge bg-success ms-1">Success</span>
                    <span class="badge bg-info ms-1">Info</span>
                    <span class="badge bg-warning ms-1">Warning</span>
                    <span class="badge bg-danger ms-1">Danger</span>
                    <span class="badge bg-dark ms-1">Dark</span>
                  </div>
                </div>
                <div class="mt-5">
                  <h5 class="font-size-14">Soft Badge</h5>
                  <div class="mt-1">
                    <b-badge variant="none" class="badge-soft-primary me-1">Primary</b-badge>
                    <b-badge variant="none" class="badge-soft-success me-1">Success</b-badge>
                    <b-badge variant="none" class="badge-soft-info me-1">Info</b-badge>
                    <b-badge variant="none" class="badge-soft-warning me-1">Warning</b-badge>
                    <b-badge variant="none" class="badge-soft-danger me-1">Danger</b-badge>
                    <b-badge variant="none" class="badge-soft-dark">Dark</b-badge>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="mt-4 mt-lg-0">
                  <h4 class="card-title">Pill Badges</h4>
                  <p class="card-title-desc">
                    Use the
                    <code>.badge-pill</code> modifier class to make badges more
                    rounded (with a larger
                    <code>border-radius</code>
                    and additional horizontal
                    <code>padding</code>). Useful if you miss the badges from
                    v3.
                  </p>

                  <div>
                    <span class="badge rounded-pill bg-primary">Primary</span>
                    <span class="badge rounded-pill bg-success ms-1">Success</span>
                    <span class="badge rounded-pill bg-info ms-1">Info</span>
                    <span class="badge rounded-pill bg-warning ms-1">Warning</span>
                    <span class="badge rounded-pill bg-danger ms-1">Danger</span>
                    <span class="badge rounded-pill bg-dark ms-1">Dark</span>
                  </div>
                  <div class="mt-5">
                    <h5 class="font-size-14">Soft Badge</h5>
                    <div class="mt-1">
                      <b-badge variant="none" class="badge-soft-primary rounded-pill me-1">Primary</b-badge>
                      <b-badge variant="none" class="badge-soft-success rounded-pill me-1">Success</b-badge>
                      <b-badge variant="none" class="badge-soft-info rounded-pill me-1">Info</b-badge>
                      <b-badge variant="none" class="badge-soft-warning rounded-pill me-1">Warning</b-badge>
                      <b-badge variant="none" class="badge-soft-danger rounded-pill me-1">Danger</b-badge>
                      <b-badge variant="none" class="badge-soft-dark rounded-pill">Dark</b-badge>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->
            <hr class="mt-5">
            <div class="row">
              <div class="col-xl-6">
                <div class="mt-4">
                  <h4 class="card-title">Badges in Buttons</h4>
                  <p class="card-title-desc">Badges can be used as part of links or buttons to provide a counter.</p>

                  <div class="d-flex flex-wrap gap-2">
                    <b-button type="button" variant="primary">
                      Notifications <b-badge variant="success" class="ms-1">4</b-badge>
                    </b-button>
                    <b-button type="button" variant="success">
                      Messages <b-badge variant="danger" class="ms-1">2</b-badge>
                    </b-button>
                    <b-button type="button" variant="none" class="btn-outline-secondary">
                      Draft <b-badge variant="success" class="ms-1">2</b-badge>
                    </b-button>
                  </div>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="mt-4">
                  <h4 class="card-title">Badges Position Examples</h4>
                  <p class="card-title-desc">Example of Badges Position</p>

                  <div class="d-flex flex-wrap gap-3">
                    <b-button type="button" variant="primary" class="position-relative">
                      Mails <b-badge
                        class="position-absolute top-0 start-100 translate-middle rounded-pill" variant="success">+99 <span
                          class="visually-hidden">unread messages</span></b-badge>
                    </b-button>


                    <b-button type="button" variant="light" class="position-relative">
                      Alerts <b-badge
                        class="position-absolute top-0 start-100 translate-middle border border-light rounded-circle p-1" variant="danger"><span
                          class="visually-hidden">unread messages</span></b-badge>
                    </b-button>

                    <b-button type="button" variant="primary" class="position-relative p-0 avatar-xs rounded">
                      <span class="avatar-title bg-transparent">
                        <i class="bx bxs-envelope"></i>
                      </span>
                      <b-badge
                        class="position-absolute top-0 start-100 translate-middle border border-light rounded-circle p-1" variant="danger"><span
                          class="visually-hidden">unread messages</span></b-badge>
                    </b-button>

                    <b-button type="button" variant="light" class="position-relative p-0 avatar-xs rounded-circle">
                      <span class="avatar-title bg-transparent text-reset">
                        <i class="bx bxs-bell"></i>
                      </span>
                    </b-button>

                    <b-button type="button" variant="light" class="position-relative p-0 avatar-xs rounded-circle">
                      <span class="avatar-title bg-transparent text-reset">
                        <i class="bx bx-menu"></i>
                      </span>
                      <b-badge
                        class="position-absolute top-0 start-100 translate-middle border border-light rounded-circle p-1" variant="success"><span
                          class="visually-hidden">unread messages</span></b-badge>
                    </b-button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Popovers</h4>
            <p class="card-title-desc">
              Add small overlay content, like those found in iOS, to any element
              for housing secondary information.
            </p>

            <div class="d-flex flex-wrap gap-2">
              <b-button v-b-popover.top="
                'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.'
              " variant="secondary">Popover on top</b-button>
              
              <b-button v-b-popover.bottom="
                'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.'
              " variant="secondary">Popover on bottom</b-button>
              <b-button v-b-popover.right="
                'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.'
              " variant="secondary">Popover on right</b-button>
              <b-button v-b-popover.left="
                'Vivamus sagittis lacus vel augue laoreet rutrum faucibus.'
              " variant="secondary">Popover on left</b-button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Pagination</h4>

            <div class="row">
              <div class="col-lg-6">
                <h5 class="font-size-14">Default Example</h5>
                <p class="card-title-desc">
                  Pagination links indicate a series of related content exists
                  across multiple pages.
                </p>
                <b-pagination v-model="defaultvalue" :total-rows="50" :per-page="10"
                  aria-controls="my-table"></b-pagination>
              </div>

              <div class="col-lg-6">
                <div class="mt-4">
                  <h5 class="card-title">Alignment</h5>
                  <p class="card-title-desc">
                    Change the alignment of pagination components with flexbox
                    utilities.
                  </p>

                  <b-pagination :total-rows="50" prev-text="Previous" next-text="Next" align="center"></b-pagination>

                  <b-pagination :total-rows="50" prev-text="Previous" next-text="Next" align="right"></b-pagination>
                </div>
              </div>
            </div>
            <!-- end row -->

            <div class="row">
              <div class="col-lg-6">
                <div class="mt-4">
                  <h5 class="font-size-14">Sizing</h5>
                  <p class="card-title-desc">
                    Fancy larger or smaller pagination? Add
                    <code>.pagination-lg</code> or
                    <code>.pagination-sm</code> for additional sizes.
                  </p>
                  <b-pagination size="lg" :total-rows="30" :per-page="10" aria-controls="my-table"></b-pagination>

                  <b-pagination size="sm" :total-rows="30" :per-page="10" aria-controls="my-table"></b-pagination>
                </div>
              </div>
            </div>
            <!-- end row -->
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Border spinner</h4>
            <p class="card-title-desc">
              Use the border spinners for a lightweight loading indicator.
            </p>
            <div>
              <b-spinner class="m-2" variant="primary" role="status"></b-spinner>
              <b-spinner class="m-2" variant="secondary" role="status"></b-spinner>
              <b-spinner class="m-2" variant="success" role="status"></b-spinner>
              <b-spinner class="m-2" variant="info" role="status"></b-spinner>
              <b-spinner class="m-2" variant="warning" role="status"></b-spinner>
              <b-spinner class="m-2" variant="danger" role="status"></b-spinner>
              <b-spinner class="m-2" variant="dark" role="status"></b-spinner>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Growing spinner</h4>
            <p class="card-title-desc">
              If you don’t fancy a border spinner, switch to the grow spinner.
              While it doesn’t technically spin, it does repeatedly grow!
            </p>
            <div>
              <b-spinner type="grow" class="m-2" variant="primary" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="secondary" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="success" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="info" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="warning" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="danger" role="status"></b-spinner>
              <b-spinner type="grow" class="m-2" variant="dark" role="status"></b-spinner>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
</Layout></template>