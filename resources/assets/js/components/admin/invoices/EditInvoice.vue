<template>
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Invoice Number</label>
      <div class="form-control">{{ invoice.id }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Invoice Date</label>
      <div class="form-control">{{ invoice.date_paid }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Debitor</label>
      <div class="form-control">{{ invoice.Debitor.name }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Service Period</label>
      <div class="form-control">{{ invoice.service_period }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Due Date</label>
      <div class="form-control">{{ invoice.due_date }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Sum</label>
      <div class="form-control">{{ invoice.netto }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Brutto</label>
      <div class="form-control">{{ invoice.brutto }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Balance</label>
      <div class="form-control">{{ invoice.balance }}</div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Total VAT</label>
      <div class="form-control">{{ total_vat }}</div>
    </div>

    <div v-if="invoice.file != null" class="col-xs-12 col-sm-6 col-md-4">
      <label class="control-label">Total VAT</label>
      <a :href="invoice.file.file_url" download>DOWNLOAD INVOICE</a>
    </div>

    <hr>

    <div v-if="invoice.items.length" class="row width-full-table">
      <div class="col-xs-12 col-sm-12">
        <table class="table table-hover dataTable table-bordered width-full table-small combo-table">
          <thead>
            <tr>
              <td>#</td>
              <td>Description</td>
              <td>Amount</td>
              <td>Price</td>
              <td>VAT</td>
              <td>SUM</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in invoice.items" :key="index">
              <td>{{ item.id }}</td>
              <td>{{ item.description }}</td>
              <td>{{ item.amount }}</td>
              <td>{{ item.price }}</td>
              <td>{{ item.vat_rate }}</td>
              <td>{{ item.sum }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      invoice: {
        id: null,
        debitor_id: null,
        receipt_id: null,
        attendant: null,
        billing_number: null,
        service_period: null,
        term_of_credit: null,
        no_tax: null,
        is_payment_instructed: null,
        Debitor: {
          id: null,
          contact_id: null,
          number: null,
          tax_number: null,
          debit_payment: null,
          iban: null,
          bic: null,
          email: null,
          send_email_bills: null,
          deactivated: null,
          language: null,
          last_invoice_number: null,
          name: null,
          street: null,
          postcode: null,
          location: null,
          country: null,
          crm_id: null
        },
        remarks: null,
        receipt_date: null,
        date_paid: null,
        balance: null,
        file: {
          id: null,
          filename: null,
          file_url: null,
          file_exists: null
        },
        excluded_reminder: null,
        items: [{
          id: null,
          description: null,
          amount: null,
          price: null,
          measurement: null,
          vat_rate: null,
          sum: null
        }],
        attachment: {
          id: null,
          filename: null,
          file_url: null,
          file_exists: null
        },
        netto: null,
        brutto: null,
        type: null,
        due_date: null
      },
      total_vat: 0
    }
  },
  mounted() {
    // this.getData();
  },
  created() {
    this.invoice.id = this.$route.params.id
  },
  methods: {
    /*
     *  To calculate total VAT
     *  We take each vat_rate from items array and add it to previous value
     */
    totalVat() {
      this.total_vat = 0
      for (const i in this.invoice.items) {
        this.total_vat += this.invoice.items[i].vat_rate
      }
    },
    getData() {
      this.$http.get('/admin/invoices/browse_invoices', {
        headers: { 'Accept': 'application/json' },
        params: {
          id: this.invoice.id
        }
      }).then(response => {
        this.invoice = response.data
      }, function(error) {
        console.log(error)
      })
    }
  }
}
</script>
