<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

import img2 from '../../../images/small/img-2.jpg';
import img3 from '../../../images/small/img-3.jpg';
import img4 from '../../../images/small/img-4.jpg';
import avatar1 from '../../../images/users/avatar-1.jpg';
import avatar3 from '../../../images/users/avatar-3.jpg';
import avatar4 from '../../../images/users/avatar-4.jpg';
import avatar5 from '../../../images/users/avatar-5.jpg';

/**
 * Images component
 */
export default {
  components: { Layout, PageHeader },
  data() {
    return {
      title: "Images",
      img2, img3, img4, avatar1, avatar3, avatar4, avatar5,
      items: [
        {
          text: "UI Elements",
          href: "/"
        },
        {
          text: "Images",
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
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Image Rounded & Circle</h4>
            <p class="card-title-desc">
              Use classes
              <code>.rounded</code> and
              <code>.rounded-circle</code>.
            </p>

            <div class="row">
              <div class="col-md-6">
                <img class="rounded me-2" alt="200x200" width="200" :src="img4" data-holder-rendered="true" />
              </div>
              <div class="col-md-6">
                <div class="mt-4 mt-md-0">
                  <img class="rounded-circle avatar-xl" alt="200x200" :src="avatar4" data-holder-rendered="true" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Image thumbnails</h4>
            <p class="card-title-desc">
              In addition to our border-radius utilities, you can use
              <code class="highlighter-rouge">.img-thumbnail</code> to give an image a
              rounded 1px border appearance.
            </p>

            <div class="row">
              <div class="col-md-6">
                <img class="img-thumbnail" alt="200x200" width="200" :src="img3" data-holder-rendered="true" />
              </div>
              <div class="col-md-6">
                <div class="mt-4 mt-md-0">
                  <img class="img-thumbnail rounded-circle avatar-xl" alt="200x200" :src="avatar3"
                    data-holder-rendered="true" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Responsive images</h4>
            <p class="card-title-desc">
              Images in Bootstrap are made responsive
              with
              <code class="highlighter-rouge">.img-fluid</code>.
              <code class="highlighter-rouge">max-width: 100%;</code> and
              <code class="highlighter-rouge">height: auto;</code> are applied to
              the image so that it scales with the parent element.
            </p>

            <div class>
              <img :src="img2" class="img-fluid" alt="Responsive image" />
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
            <h4 class="card-title mb-4">Image Sizes</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar3" alt class="rounded avatar-sm" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-sm</code>
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar4" alt class="rounded avatar-md" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-md</code>
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar5" alt class="rounded avatar-lg" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-lg</code>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar3" alt class="rounded-circle avatar-sm" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-sm</code>
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar4" alt class="rounded-circle avatar-md" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-md</code>
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div>
                      <img :src="avatar5" alt class="rounded-circle avatar-lg" />
                      <p class="mt-2 mb-lg-0">
                        <code>.avatar-lg</code>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end row-->

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Media Object</h4>
            <p class="card-title-desc">The images or other media can be
              aligned top, middle, or bottom. The default is top aligned.
            </p>

            <!-- Start Media Object -->
            <div class="d-flex">
              <div class="flex-shrink-0 me-3">
                <img class="rounded avatar-sm" :src="avatar3" alt="Generic placeholder image">
              </div>
              <div class="flex-grow-1">
                <h5>Top-aligned media</h5>
                <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                  sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                  ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              </div>
            </div>
            <!-- End Media Object -->

            <hr>

            <!-- Start Media Object -->
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0 me-3">
                <img class="rounded avatar-sm" :src="avatar5" alt="Generic placeholder image">
              </div>
              <div class="flex-grow-1">
                <h5>Center-aligned media</h5>
                <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                  sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                  ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              </div>
            </div>
            <!-- End Media Object -->

            <hr>

            <!-- Start Media Object -->
            <div class="d-flex align-items-end">
              <div class="flex-shrink-0 me-3">
                <img class="rounded avatar-sm" :src="avatar1" alt="Generic placeholder image">
              </div>
              <div class="flex-grow-1">
                <h5>Bottom-aligned media</h5>
                <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante
                  sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc
                  ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
              </div>
            </div>
            <!-- End Media Object -->

          </div><!-- end card-body -->
        </div><!-- end card -->
      </div><!-- end col -->
    </div><!-- end row -->

  </Layout>
</template>