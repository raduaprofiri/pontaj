import Vue from 'vue';
import ApexCharts from 'apexcharts';

new Vue({
	el: '#dashboard',
	data() {
		return {
			users: window.app.users,
			myUser: Object.keys(window.app.my)[0],
			options2: {
				chart: {
					type: 'line'
				},
				series: [
					{
						name: 'minutes',
						data: Object.values(window.app.avg)
					}
				],
				xaxis: {
					categories: Object.keys(window.app.avg)
				},
				width: 200
			}
		};
	},
	watch: {
		myUser() {
			this.updateCharts();
		}
	},
	methods: {
		updateCharts() {
			var options = {
				chart: {
					type: 'line'
				},
				series: [
					{
						name: 'minutes',
						data: window.app.my[this.myUser] ? Object.values(window.app.my[this.myUser]) : []
					}
				],
				xaxis: {
					categories: window.app.my[this.myUser] ? Object.keys(window.app.my[this.myUser]) : []
				},
				width: 200
			};

			var chart = new ApexCharts(
				document.querySelector('#chart'),
				options
			);

			chart.render();

			var chart = new ApexCharts(
				document.querySelector('#chart2'),
				this.options2
			);

			chart.render();
		}
	},
	mounted() {
		this.updateCharts();

		document
			.getElementById('userselect')
			.addEventListener('change', event => {
				this.myUser = event.target.value;
			});
	}
});
