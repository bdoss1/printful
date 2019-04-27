import DashboardBrowser from '../components/admin/DashboardBrowser.vue'
import InvoicesBrowser from '../components/admin/invoices/InvoicesBrowser.vue'
import CreateInvoice from '../components/admin/invoices/CreateInvoice.vue' // Later Create and Edit component will be the same.
import EditInvoice from '../components/admin/invoices/EditInvoice.vue'

const _routes = [
  {
    path: '/admin',
    name: 'DashboardBrowser',
    component: DashboardBrowser
  },
  {
    path: '/admin/invoices',
    name: 'InvoicesBrowser',
    component: InvoicesBrowser
  },
  {
    path: '/admin/invoices/create',
    name: 'CreateInvoice',
    component: CreateInvoice
  },
  {
    path: '/admin/invoices/:id/edit',
    name: 'EditInvoice',
    component: EditInvoice
  }
]
export const routes = _routes
