<template>
  <div class="container">
    <div class="row filter-form">
      <h1>{{ text }}</h1>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <label class="control-label" />
        <el-date-picker v-model="params.service_period" required :editable="false" name="date" type="date" placeholder="Select Date" @change="changeDate(params.service_period)" />
      </div>
      <div class="col-xs-12 col-sm-6 col-md-4">
        <el-button type="button" @click="getData"><i class="fa fa-search" /></el-button>
      </div>

      <div class="col-xs-12 col-sm-6 col-md-4">
        <span @click="Export">Export Excel</span>
      </div>
    </div>

    <table class="table table-hover dataTable table-bordered width-full table-small combo-table">
      <thead>
        <tr>
          <td>ID</td>
          <td>Debitor</td>
          <td>Brutto</td>
          <td>Netto</td>
          <td>Settings</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in data" :key="index">
          <th>{{ item.id }}</th>
          <th>{{ item.Debitor.name }}</th>
          <th>{{ item.brutto }}</th>
          <th>{{ item.netto }}</th>
          <th>
            <router-link :to="{name: 'EditInvoice', params: { id: item.id }}" class="animsition-link">
              <i class="fa fa-edit" />
            </router-link>
          </th>
        </tr>
      </tbody>
    </table>

    <br>
    <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="getData()" />
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: [],
      text: 'Invoices Browser',
      pagination: {
        current_page: 1,
        last_page: 1,
        total: null,
        per_page: 25,
        from: null,
        to: null
      },
      params: {
        page: 1,
        limit: 25,
        orderDirection: 'desc',
        orderField: 'id',
        status: null, // Created, prepared, paid
        debitor_id: null,
        attendant: null,
        billing_number: null,
        service_period: null,
        receipt_date: null,
        date_paid: null,
        balance: null, // float
        netto: null, // float
        brutto: null, // float
        debitor: null, // name of the debitor
        invoice_id: null,
        email: null
      },
      checkedStatuses: []
    }
  },
  watch: {
    $route(to, from) {
      if (to !== from) {
        this.getData()
      }
    },
    params(newValue, oldValue) {
      // We can either watch the params values changes or make data fetch on Button submit
      // this.getData();
    },
    /*
     *  In case of statuses change data will be fetched from the database again.
     *  NOTE: Adding click delay on each item will be a great advantage.
     */
    checkedStatuses: function(newValue, oldValue) {
      this.getData()
    }
  },
  mounted() {
    // this.getData();
  },
  methods: {
    Export() {
      /*
	     *  The data sent in params is a paginated data.
	     *  We have to send other parameters to filter data which is going to be exported
	     *
	     *  We will require queues for server side rendering, because annual data can be too large
	     *  And throw maximum execution time error or memory limit error!
	     */
      /* this.$http.get('/admin/invoices/export', {
            headers: { 'Accept':'application/json' },
            params: {
                data: this.data,
            }
        }).then(response => {

        }, function(error) {
            console.log(error);
        });
      */

      this.$http.post('/admin/invoices/export', this.data, this.Headers()).then(response => {
        const fileDownload = require('js-file-download')
        fileDownload(response.data, 'filename.xlsx') // Need too correct, returns corrupted file!
      }, function(error) {
        console.log(error)
      })
    },
    changeDate(date) {
      // To return custom value on date change
      this.params.service_period = Window.Vue.moment(date).format('YYYY-MM-DD, H:mm:ss')
    },
    getData() {
      this.params.page = this.pagination.current_page
      this.$http.get('/admin/invoices/browse_invoices', {
        headers: { 'Accept': 'application/json' },
        params: {
          params: this.params
        }
      }).then(response => {
        /*
       *  After receiving the data we update the pagination object
       *  Push the list of debits to the Data variable and render the table
       */
        if (this.pagination.current_page === 1) {
          this.pagination.current_page = response.data.page
        }
        this.pagination.last_page = response.data.page_count
        this.pagination.total = response.data.total_items
        this.pagination.per_page = 25
        this.pagination.from = response.data.page
        this.pagination.to = response.data.page + 1

        this.data = response.data._embedded.list_debits
      }, function(error) {
        console.log(error)
      })
    }
  }
}
</script>
