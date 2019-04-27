/*
 *	Importing mounting function from vue test utilities `shallowMount`
 *	If our components include other components (e.g Element-UI, Swal, Multiselect)
 *	We need to mount them to our current component that is why we have to use createLocalVue
 *	To create the testing environment for vue for this current task. 
 */
import { shallowMount, createLocalVue } from '@vue/test-utils';
// Importing axios to create axios instance
import axios from 'axios';

// Axios adapter for mocking the requests!
import MockAdapter from'axios-mock-adapter'

/*
 *	We include below packages using createLocalVue as `InvoicesBrowser` component uses them!
 */
import ElementUI 	from 'element-ui';
import locale 		from 'element-ui/lib/locale/lang/en';
import VueMoment 	from 'vue-moment';
import VueRouter from 'vue-router';

// Import an actual  
import InvoicesBrowser from '../../../resources/assets/js/components/admin/invoices/InvoicesBrowser.vue';
;

describe ('InvoicesBrowser', () => {
	let wrapper; // variable for mounted component
	let localVue; // Creating a new vue application instance
	let componentInstance; // 
    let axiosInstance;
    let mock;

	beforeEach (() => {
	    axiosInstance = axios.create();
	    mock = new MockAdapter(axiosInstance);

	    localVue = createLocalVue();
		localVue.use(ElementUI, { locale });
		localVue.use(VueMoment);
		localVue.use(VueRouter);

    	//	We must assign the vue app instance to the mounted component
    	wrapper = shallowMount(InvoicesBrowser, { localVue });

    	/*
    	 * 	We assign the view model of the component to `componentInstance` variable
    	 *	Otherwise we can use `wrapper.vm` each time we want to get or set the value of the component's variable.
    	 */
	    componentInstance = wrapper.vm;
  	});

	afterEach (() => {
		// resetting the mocking history each time we make an ajax request
		mock.resetHistory();
	});

    it ('Checks if component includes title', () => {
    	expect(componentInstance.text).toBeTruthy();
    	// or
    	// expect(wrapper.vm.text).toBeTruthy();
    });

  	it('Fakes ajax request', done => {
  		/*
  		 *	After mocking the http request we create a fake data
  		 *	Returning it via promise, with 200 `successful response`
  		 *	If the data was not set we return a custom erro
  		 */
	    mock.onGet('/admin/invoices/browse_invoices')
	      	.reply(() => {
	        	return new Promise((resolve, reject) => {
			        resolve([
			        	200, // successful response message code. e.g 404 will return `Not found error`
		        		// Faked array! Having the same structure as InvoicesBrowser `data` array.
		        		[
	        				{
	        					id: 1,
	        					Debitor: {
	        						name: 'test data'
	        					},
	        					brutto: 'BruTTo',
	        					netto: 'NeTTo'
	        				}
	        			]
		        	])
			        .reject({ err: 'Please learn how to fake data better!' });
	        	});
	      	});

	    axiosInstance.get('/admin/invoices/browse_invoices')
	      	.then((res) => {
	      		// after fetching the data from the url we push the data to our component!
	      		wrapper.setData({
	      			data: res.data
	      		});

	      		// We check if the requested data was really set to our component 
	      		expect(componentInstance.data.length).toBe(1);
	      		expect(componentInstance.data[0].Debitor.name).toBe('test data');
	      	})
	      	// Type error message here
	      	.catch((error) => {
	      		console.log(error);
	      	});
	    done();
    });
});