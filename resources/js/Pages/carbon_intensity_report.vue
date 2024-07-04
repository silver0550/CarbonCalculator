<template>
    <div class="font-bold text-3xl text-center mt-4">
        Karbon kibocsátás projektek szerint
    </div>
    <div class="overflow-x-auto m-9">
        <div class="border border-base-300 rounded-xl overflow-hidden">
            <table class="table table-zebra">
                <thead class="bg-base-300 border border-base-300">
                <tr class="text-xl text-center border border-base-300">
                    <th>ID</th>
                    <th>Jármű megnevezése</th>
                    <th>Project Kezdete</th>
                    <th>Project Vége</th>
                    <th>Menetteljesítmény</th>
                    <th>CO2 kibocsájtás <br>(gCO2eq/kWh)</th>
                </tr>
                </thead>
                <tbody class="text-center">
                <tr v-for="row in report" :key="row['id']" class="hover">
                    <th>{{ row['id'] }}</th>
                    <td>{{ row['vehicleName'] }}</td>
                    <td>{{ row['startProject'] }}</td>
                    <td>{{ row['endProject'] }}</td>
                    <td>{{ row['runningPower'] }}</td>
                    <td>{{ row['carbonIntensity'] }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="font-bold text-3xl text-center mb-8">
        Karbon kibocsátás éves lebontásban
    </div>
    <div class="flex w-4/5 mx-auto mb-9">
        <div class="flex-1 flex items-center ">
            <div class="w-full max-w-4xl">
                <div class="border border-base-300 rounded-xl overflow-hidden">
                    <table class="table table-zebra w-full">
                        <thead class="bg-base-300 border border-base-300">
                        <tr class="text-xl text-center">
                            <th>Év</th>
                            <th>Teljes CO2 kibocsátás <br>(gCO2eq/kWh)</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        <tr v-for="row in groupedProjects" :key="row['year']" class="hover">
                            <th>{{ row['year'] }}</th>
                            <td>{{ row['totalCarbonIntensity'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="app" class="flex-2 flex items-center justify-center">
            <div class="w-full max-w-4xl">
                <PieChart :data="chartData"/>
            </div>
        </div>
    </div>
</template>

<script>
import PieChart from '../Components/pie_chart.vue';

export default {
    name: "carbonIntensityReport",
    components: {
        PieChart
    },
    props: {
        report: {required: true, type: Array},
        groupedProjects: {required: true, type: Array},
    },
    computed: {
        chartData() {
            return {
                labels: this.groupedProjects.map(project => project.year),
                datasets: [
                    {
                        label: 'Kibocsátás',
                        backgroundColor: this.generateColors(this.groupedProjects.length),
                        data: this.groupedProjects.map(
                            project => parseFloat(project.totalCarbonIntensity.replace(/\s/g, '')))
                    }
                ]
            };
        }
    },
    methods: {
        generateColors(number) {
            const colors = ['#f87979', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF6384'];
            while (colors.length < number) {
                colors.push('#' + Math.floor(Math.random() * 16777215).toString(16));
            }
            return colors.slice(0, number);
        }
    }
}
</script>

