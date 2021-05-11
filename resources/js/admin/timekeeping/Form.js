import { now } from 'lodash';
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
			},
			datetimePickerConfig: {
                enableTime: true,
                time_24hr: true,
                enableSeconds: true,
                dateFormat: 'Y-m-d H:i:S',
                altInput: true,
                altFormat: 'd.m.Y H:i:S',
                locale: null,
				maxDate: now()
            },
		};
	},
	mounted() {
		if (this.form.project_id) {
			this.form.project_id = this.projects.find(
				p => p.id == this.form.project_id
			);
		}
	}
});
