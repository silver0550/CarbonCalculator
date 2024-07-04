<template>
    <div>
        <Pie :data="data" :options="options"></Pie>
    </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import { defineComponent } from 'vue';

ChartJS.register(Title, Tooltip, Legend, ArcElement);

export default defineComponent({
    name: "PieChart",
    components: {
        Pie
    },
    props: {
        data: {
            type: Object,
            required: true
        },
        options: {
            type: Object,
            default: () => ({responsive: true, maintainAspectRatio: false})
        }
    }
});
</script>

<style scoped>
canvas {
    max-width: 500px;
    margin: auto;
}
</style>
