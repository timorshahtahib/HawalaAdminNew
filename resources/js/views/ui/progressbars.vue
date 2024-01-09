<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";

/**
 * Progressbar component
 */
export default {
  components: { Layout, PageHeader },
  data() {
    return {
      title: "Progress Bars",
      items: [
        {
          text: "UI Elements",
          href: "/"
        },
        {
          text: "Progress Bars",
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
            <h4 class="card-title">Default Examples</h4>
            <p class="card-title-desc">
              Progress components are built with two
              HTML elements, some CSS to set the width, and a few attributes.
            </p>
            <b-progress :value="25" :max="100" class="mb-4"></b-progress>
            <b-progress :value="50" :max="100" class="mb-4"></b-progress>
            <b-progress :value="75" :max="100" class="mb-4"></b-progress>
            <b-progress :value="100"></b-progress>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Backgrounds</h4>
            <p class="card-title-desc">
              Use background utility classes to
              change the appearance of individual progress bars.
            </p>
            <b-progress :value="25" :max="100" class="mb-4" variant="success"></b-progress>
            <b-progress :value="50" :max="100" class="mb-4" variant="info"></b-progress>
            <b-progress :value="75" :max="100" class="mb-4" variant="warning"></b-progress>
            <b-progress :value="100" variant="danger"></b-progress>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Labels Example</h4>
            <p class="card-title-desc">
              Add labels to your progress bars by placing text within the
              <code class="highlighter-rouge">.progress-bar</code>.
            </p>
            <b-progress :value="25" :max="100" show-value></b-progress>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Multiple bars</h4>
            <p class="card-title-desc">Include multiple progress bars in a progress component if you need.</p>
            <b-progress class="mt-2" :max="100">
              <b-progress-bar :value="45 * (6 / 10)"></b-progress-bar>
              <b-progress-bar :value="45 * (2.5 / 10)" variant="success"></b-progress-bar>
              <b-progress-bar :value="45 * (1.5 / 10)" variant="info"></b-progress-bar>
            </b-progress>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Height</h4>
            <p class="card-title-desc">
              We only set a
              <code class="highlighter-rouge">height</code> value on the
              <code class="highlighter-rouge">.progress-bar</code>, so if you change
              that value the outer
              <code class="highlighter-rouge">.progress</code>
              will automatically resize accordingly.
            </p>

            <h5 class="font-size-13">Progress sm</h5>
            <b-progress class="progress-sm mb-3" :value="20"></b-progress>
            <h5 class="font-size-13">Progress md</h5>
            <b-progress class="progress-md mb-3" :value="40" variant="success"></b-progress>
            <h5 class="font-size-13">Progress lg</h5>
            <b-progress class="progress-lg mb-3" :value="60" variant="warning"></b-progress>
            <h5 class="font-size-13">Progress xl</h5>
            <b-progress class="progress-xl mb-3" :value="80" variant="danger"></b-progress>

          </div>
        </div>
      </div>
      <!-- end col -->

      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Striped</h4>
                <p class="card-title-desc">Add <code>.progress-bar-striped</code>
                  to any <code>.progress-bar</code> to apply a
                  stripe via CSS gradient over the progress bar’s background color.</p>
                <b-progress class="mb-3" :value="30" :max="100" striped></b-progress>
                <b-progress variant="success" :value="60" :max="100" striped></b-progress>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Animated stripes</h4>
                <p class="card-title-desc">
                  The striped gradient can also be
                  animated. Add
                  <code class="highlighter-rouge">.progress-bar-animated</code> to
                  <code class="highlighter-rouge">.progress-bar</code> to animate the
                  stripes right to left via CSS3 animations.
                </p>
                <b-progress :value="75" :max="100" animated></b-progress>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Striped</h4>
            <p class="card-title-desc">
              Add
              <code class="highlighter-rouge">.progress-bar-striped</code>
              to any
              <code class="highlighter-rouge">.progress-bar</code> to apply a
              stripe via CSS gradient over the progress bar’s background color.
            </p>
            <b-progress :value="10" :max="100" class="mb-4" animated></b-progress>
            <b-progress :value="25" :max="100" class="mb-4" variant="success" animated></b-progress>
            <b-progress :value="50" :max="100" class="mb-4" variant="info" animated></b-progress>
            <b-progress :value="75" :max="100" class="mb-4" variant="warning" animated></b-progress>
            <b-progress :value="100" :max="100" class="mb-4" variant="danger" animated></b-progress>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Custom progress</h4>
            <p class="card-title-desc mb-4">Example of Custom progress</p>

            <div class="pt-2">
              <div class="custom-progess mb-5">
                <b-progress :value="84" :max="100" class="mb-4 progress-sm" variant="danger"></b-progress>
                <div class="avatar-xs progress-icon">
                  <span class="avatar-title rounded-circle border border-danger">
                    <i class="bx bxl-html5 text-danger font-size-18"></i>
                  </span>
                </div>
              </div>

              <div class="custom-progess mb-5">
                <b-progress :value="75" :max="100" class="mb-4 progress-sm"></b-progress>
                <div class="avatar-xs progress-icon">
                  <span class="avatar-title rounded-circle border border-primary">
                    <i class="bx bxl-css3 text-primary font-size-18"></i>
                  </span>
                </div>
              </div>
              <div class="custom-progess mb-4">
                <b-progress :value="62" :max="100" class="mb-4 progress-sm" variant="info"></b-progress>
                <div class="avatar-xs progress-icon">
                  <span class="avatar-title rounded-circle border border-info">
                    <i class="bx bxl-jquery text-info font-size-18"></i>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Progress Example</h5>
            <p class="card-title-desc">You can use these classes with existing components to create new ones.</p>

            <div class="mt-5">
              <div class="position-relative m-4">
                <b-progress :max="100" style="height: 1px;">
                  <b-progress-bar variant="primary" style="width: 50%;"></b-progress-bar>
                </b-progress>
                <button type="button"
                  class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill"
                  style="width: 2rem; height:2rem;">1</button>
                <button type="button"
                  class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-primary rounded-pill"
                  style="width: 2rem; height:2rem;">2</button>
                <button type="button"
                  class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill"
                  style="width: 2rem; height:2rem;">3</button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

</Layout></template>