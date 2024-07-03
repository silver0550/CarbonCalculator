<template>
    <div class="overflow-x-auto">
        <table class="table table-zebra">
            <thead>
            <tr>
                <th>ID</th>
                <th>Jármű megnevezése</th>
                <th>Project Kezdete</th>
                <th>Project Vége</th>
                <th>Menetteljesítmény</th>
                <th>CO2 kibocsájtás (gCO2eq/Kwh)</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in data" :key="row['id']" class="hover">
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
</template>

<script>
export default {
    name: "teszt",
    props: {
        data: {required: true, type: Array},
    },
}
</script>

