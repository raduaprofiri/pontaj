import AppForm from '../app-components/Form/AppForm';

Vue.component('timekeeping-form', {
	mixins: [AppForm],
	props: ['users', 'projects'],
	data: function() {
		return {
			form: {
				project_id: '',
				user_id: '',
				task: '',
				description: '',
				start_date: '',
				minutes: '',
				location: ''
			}
		};
	}
});
