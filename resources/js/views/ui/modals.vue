<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * Modals component
 */
export default {

  components: { Layout, PageHeader },
  data() {
    return {
      title: "Modals",
      items: [
        {
          text: "UI Elements",
          href: "/"
        },
        {
          text: "Modals",
          active: true
        }
      ],
      isOpen:false,
      isOpen1:false,
      isOpen2:false,
      isOpen3:false,
      isOpen4:false,
      isOpen5:false,
    };
  }
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Modals Examples</h4>
            <p class="card-title-desc">
              Modals are streamlined, but flexible dialog prompts powered by
              JavaScript. They support a number of use cases from user
              notification to completely custom content and feature a handful of
              helpful subcomponents, sizes, and more.
            </p>

            <!-- /.modal -->

            <div class="row">
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Standard modal</p>
                  <b-button @click="isOpen = true" variant="primary">Standard modal</b-button>
                  <b-modal v-model="isOpen" id="modal-standard" title="Modal Heading" title-class="font-18">
                    <h5>Overflowing text to show scroll behavior</h5>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p>
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p>
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p>
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                  </b-modal>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Extra large modal</p>
                  <b-button @click="isOpen1 = true" variant="primary">Extra large modal</b-button>
                  <b-modal v-model="isOpen1" id="modal-xl" size="xl" title="Extra large modal" title-class="font-18"
                    hide-footer>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p class="mb-0">
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                  </b-modal>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Large modal</p>
                  <b-button @click="isOpen2 = true" variant="primary">Large modal</b-button>
                  <b-modal v-model="isOpen2" id="modal-lg" size="lg" title="Large modal" title-class="font-18"
                    hide-footer>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p class="mb-0">
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                  </b-modal>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Small modal</p>
                  <b-button @click="isOpen3 = true" variant="primary">Small modal</b-button>
                  <b-modal v-model="isOpen3" id="modal-sm" size="sm" title="Small modal" title-class="font-18"
                    hide-footer>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p class="mb-0">
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                  </b-modal>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Center modal</p>
                  <b-button @click="isOpen4 = true" variant="primary">Center modal</b-button>
                  <b-modal v-model="isOpen4" id="modal-center" centered title="Center modal" title-class="font-18"
                    hide-footer>
                    <p>
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                    <p>
                      Praesent commodo cursus magna, vel scelerisque nisl
                      consectetur et. Vivamus sagittis lacus vel augue laoreet
                      rutrum faucibus dolor auctor.
                    </p>
                    <p class="mb-0">
                      Aenean lacinia bibendum nulla sed consectetur. Praesent
                      commodo cursus magna, vel scelerisque nisl consectetur et.
                      Donec sed odio dui. Donec ullamcorper nulla non metus
                      auctor fringilla.
                    </p>
                  </b-modal>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="my-4 text-center">
                  <p class="text-muted">Scrollable modal</p>
                  <b-button @click="isOpen5 = true" variant="primary">Scrollable</b-button>
                  <b-modal v-model="isOpen5" id="modal-scrollable" scrollable title="Scrollable Modal"
                    title-class="font-18">
                    <p v-for="i in 15" :key="i">
                      Cras mattis consectetur purus sit amet fermentum. Cras
                      justo odio, dapibus ac facilisis in, egestas eget quam.
                      Morbi leo risus, porta ac consectetur ac, vestibulum at
                      eros.
                    </p>
                  </b-modal>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>