import Chart from 'chart.js/auto'

export default {
    methods: {
        initChartDefaults() {
            Chart.defaults.color = '#cbd5e0'
            Chart.defaults.plugins.legend.position = 'bottom'
            Chart.defaults.responsive = true
            Chart.defaults.maintainAspectRatio = false
            Chart.defaults.plugins.title = Object.assign(Chart.defaults.plugins.title, {
                display: true,
                align: 'start',
                font: {
                    size: 14,
                    weight: 'bold'
                },
                padding: {
                    bottom: 20
                }
            })
            Chart.defaults.font = Object.assign(Chart.defaults.font, {
                family: "'Nunito', sans-serif"
            })
        },
    },
    created() {
        this.initChartDefaults()
    }
}