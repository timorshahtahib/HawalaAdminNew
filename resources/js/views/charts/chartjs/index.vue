<script>
import Layout from "../../../layouts/main.vue";
import PageHeader from "../../../components/page-header.vue";

import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";
import { line, pie, Doughnut, radar, bar, PolarArea } from "./data";

/**
 * Chartjs-chart component
 */
export default {
  components: {
    Layout,
    PageHeader,
    Vue3ChartJs
  },
  data() {
    return {
      title: "Chartjs Chart",
      items: [
        {
          text: "Charts",
          href: "/"
        },
        {
          text: "Chartjs Chart",
          active: true
        }
      ],
      line: line,
      pie: pie,
      Doughnut: Doughnut,
      radar: radar,
      bar: bar,
      PolarArea: PolarArea,
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
            <h4 class="card-title mb-4">Pie Chart</h4>
            <div class="row text-center">
              <div class="col-sm-4">
                <h5 class="mb-0">2536</h5>
                <p class="text-muted">Activated</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">69421</h5>
                <p class="text-muted">Pending</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">89854</h5>
                <p class="text-muted">Deactivated</p>
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="d-flex justify-content-center">
              <div style="max-width: 400px">
                <vue3-chart-js :height="140" class="chartjs-chart" v-bind="{ ...pie }"></vue3-chart-js>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Donut Chart</h4>
            <div class="row text-center">
              <div class="col-sm-4">
                <h5 class="mb-0">9595</h5>
                <p class="text-muted">Activated</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">36524</h5>
                <p class="text-muted">Pending</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">62541</h5>
                <p class="text-muted">Deactivated</p>
              </div>
            </div>
            <!-- Donut Chart -->
            <div class="d-flex justify-content-center">
              <div style="max-width: 400px">
                <vue3-chart-js :height="140" class="chartjs-chart" v-bind="{ ...Doughnut }"></vue3-chart-js>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Polar area Chart</h4>
            <div class="row text-center">
              <div class="col-sm-4">
                <h5 class="mb-0">4852</h5>
                <p class="text-muted">Activated</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">3652</h5>
                <p class="text-muted">Pending</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">85412</h5>
                <p class="text-muted">Deactivated</p>
              </div>
            </div>
            <!-- Polar area Chart -->
            <div class="d-flex justify-content-center">
              <div style="max-width: 400px">
                <vue3-chart-js :height="140" class="chartjs-chart" v-bind="{ ...PolarArea }"></vue3-chart-js>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Radar Chart</h4>
            <div class="row text-center">
              <div class="col-sm-4">
                <h5 class="mb-0">694</h5>
                <p class="text-muted">Activated</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">55210</h5>
                <p class="text-muted">Pending</p>
              </div>
              <div class="col-sm-4">
                <h5 class="mb-0">489498</h5>
                <p class="text-muted">Deactivated</p>
              </div>
            </div>
            <!-- Radar Chart -->
            <div class="d-flex justify-content-center">
              <div style="max-width: 400px">
                <vue3-chart-js :height="140" class="chartjs-chart" v-bind="{ ...radar }"></vue3-chart-js>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>