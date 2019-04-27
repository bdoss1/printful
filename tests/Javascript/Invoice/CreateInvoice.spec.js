import { mount } from '@vue/test-utils';
// import expect from 'expect';
import CreateInvoice from '../../../resources/assets/js/components/admin/invoices/CreateInvoice.vue';

describe('CreateInvoice', () => {
	let wrapper;

	beforeEach(() => {
    	wrapper = mount(CreateInvoice);
  	});

	it ('says that it is an Example Component', () => {
		expect(wrapper.html()).toContain('Example Component');
	});
});