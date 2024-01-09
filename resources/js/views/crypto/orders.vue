<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import Datepicker from "vue3-datepicker";

export default {
    components: {
        Layout,
        PageHeader,
        Datepicker
    },
    data() {
        return {
            title: "Orders",
            items: [{
                text: "Crypto",
                href: "javascript:void(0)"
            },
            {
                text: "Orders",
                active: true
            }
            ],
            datepickervalue: new Date(),
        }
    }
}
</script>
<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Orders</h4>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#all-order" role="tab">
                                    All Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#processing" role="tab">
                                    Processing
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content p-3">
                            <div class="tab-pane active" id="all-order" role="tabpanel">
                                <form>
                                    <div class="row">

                                        <div class="col-xl col-sm-6">
                                            <div class="form-group mt-3 mb-0">
                                                <label>Date :</label>
                                                <Datepicker v-model="datepickervalue" class="form-control" :first-day-of-week="1" lang="en" confirm></Datepicker>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="form-group mt-3 mb-0">
                                                <label>Coin</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="BTC" selected>Bitcoin</option>
                                                    <option value="ETH">Ethereum</option>
                                                    <option value="LTC">litecoin</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="form-group mt-3 mb-0">
                                                <label>Type</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="BU" selected>Buy</option>
                                                    <option value="SE">Sell</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6">
                                            <div class="form-group mt-3 mb-0">
                                                <label>Status</label>
                                                <select class="form-control select2-search-disable">
                                                    <option value="CO" selected>Completed</option>
                                                    <option value="PE">Pending</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl col-sm-6 align-self-end">
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-primary w-md">Add Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mt-5">
                                    <table class="table table-hover nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Coin</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Value in USD</th>
                                                <th scope="col">Status</th>
                                            </tr>

                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>03 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Bitcoin</td>
                                                <td>1.00952 BTC</td>
                                                <td>$ 9067.62</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>04 Mar, 2020</td>
                                                <td>Sell</td>
                                                <td>Ethereum</td>
                                                <td>0.00413 ETH</td>
                                                <td>$ 2123.01</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>04 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Bitcoin</td>
                                                <td>0.00321 BTC</td>
                                                <td>$ 1802.62</td>
                                                <td>
                                                    <span class="badge bg-warning font-size-10">Pending</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>05 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Litecoin</td>
                                                <td>0.00224 LTC</td>
                                                <td>$ 1773.01</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>06 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Ethereum</td>
                                                <td>1.04321 ETH</td>
                                                <td>$ 9423.73</td>
                                                <td>
                                                    <span class="badge bg-danger font-size-10">Failed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>07 Mar, 2020</td>
                                                <td>Sell</td>
                                                <td>Bitcoin</td>
                                                <td>0.00413 ETH</td>
                                                <td>$ 2123.01</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>07 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Bitcoin</td>
                                                <td>1.00952 BTC</td>
                                                <td>$ 9067.62</td>
                                                <td>
                                                    <span class="badge bg-warning font-size-10">Pending</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>08 Mar, 2020</td>
                                                <td>Sell</td>
                                                <td>Ethereum</td>
                                                <td>0.00413 ETH</td>
                                                <td>$ 2123.01</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>09 Mar, 2020</td>
                                                <td>Sell</td>
                                                <td>Litecoin</td>
                                                <td>1.00952 LTC</td>
                                                <td>$ 9067.62</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>10 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Ethereum</td>
                                                <td>0.00413 ETH</td>
                                                <td>$ 2123.01</td>
                                                <td>
                                                    <span class="badge bg-warning font-size-10">Pending</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>11 Mar, 2020</td>
                                                <td>Buy</td>
                                                <td>Ethereum</td>
                                                <td>1.04321 ETH</td>
                                                <td>$ 9423.73</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>12 Mar, 2020</td>
                                                <td>Sell</td>
                                                <td>Bitcoin</td>
                                                <td>0.00413 ETH</td>
                                                <td>$ 2123.01</td>
                                                <td>
                                                    <span class="badge bg-success font-size-10">Completed</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="processing" role="tabpanel">
                                <div>
                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover datatable dt-responsive nowrap"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Coin</th>
                                                    <th scope="col">Value</th>
                                                    <th scope="col">Value in USD</th>
                                                    <th scope="col">Status</th>
                                                </tr>

                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>03 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Bitcoin</td>
                                                    <td>1.00952 BTC</td>
                                                    <td>$ 9067.62</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>04 Mar, 2020</td>
                                                    <td>Sell</td>
                                                    <td>Ethereum</td>
                                                    <td>0.00413 ETH</td>
                                                    <td>$ 2123.01</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>04 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Bitcoin</td>
                                                    <td>0.00321 BTC</td>
                                                    <td>$ 1802.62</td>
                                                    <td>
                                                        <span class="badge bg-warning font-size-10">Pending</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>05 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Litecoin</td>
                                                    <td>0.00224 LTC</td>
                                                    <td>$ 1773.01</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>06 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Ethereum</td>
                                                    <td>1.04321 ETH</td>
                                                    <td>$ 9423.73</td>
                                                    <td>
                                                        <span class="badge bg-danger font-size-10">Failed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>07 Mar, 2020</td>
                                                    <td>Sell</td>
                                                    <td>Bitcoin</td>
                                                    <td>0.00413 ETH</td>
                                                    <td>$ 2123.01</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>07 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Bitcoin</td>
                                                    <td>1.00952 BTC</td>
                                                    <td>$ 9067.62</td>
                                                    <td>
                                                        <span class="badge bg-warning font-size-10">Pending</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>08 Mar, 2020</td>
                                                    <td>Sell</td>
                                                    <td>Ethereum</td>
                                                    <td>0.00413 ETH</td>
                                                    <td>$ 2123.01</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>09 Mar, 2020</td>
                                                    <td>Sell</td>
                                                    <td>Litecoin</td>
                                                    <td>1.00952 LTC</td>
                                                    <td>$ 9067.62</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>10 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Ethereum</td>
                                                    <td>0.00413 ETH</td>
                                                    <td>$ 2123.01</td>
                                                    <td>
                                                        <span class="badge bg-warning font-size-10">Pending</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>11 Mar, 2020</td>
                                                    <td>Buy</td>
                                                    <td>Ethereum</td>
                                                    <td>1.04321 ETH</td>
                                                    <td>$ 9423.73</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>12 Mar, 2020</td>
                                                    <td>Sell</td>
                                                    <td>Bitcoin</td>
                                                    <td>0.00413 ETH</td>
                                                    <td>$ 2123.01</td>
                                                    <td>
                                                        <span class="badge bg-success font-size-10">Completed</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
