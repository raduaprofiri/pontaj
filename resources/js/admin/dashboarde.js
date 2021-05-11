import Vue from 'vue';
import ApexCharts from 'apexcharts';

new Vue({
	el: '#dashboard',
	data: {
		options: {
			chart: {
				type: 'line'
			},
			series: [
				{
					name: 'minutes',
					data: Object.values(window.app.my)
				}
			],
			xaxis: {
				categories: Object.keys(window.app.my)
			},
			width: 200
		},
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
	},
	methods: {},
	mounted() {
		var chart = new ApexCharts(
			document.querySelector('#chart'),
			this.options
		);

		chart.render();

		var chart = new ApexCharts(
			document.querySelector('#chart2'),
			this.options2
		);

		chart.render();
	}
});
