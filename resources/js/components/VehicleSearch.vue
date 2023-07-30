<script>
export default {
    data() {
        return {
            vehicles: [],
            formData: {
                make: null,
                model: null,
                registration: null,
            },
        };
    },
    methods: {
        capitalCase(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        clearForm() {
            this.formData.make = null;
            this.formData.model = null;
            this.formData.registration = null;
            this.vehicles = [];
        },
        handleSubmit() {
            axios
                .get('/api/vehicles', {
                    params: this.formData,
                })
                .then(response => {
                    this.vehicles = response.data;
                });
        },
    },
};
</script>
<template>
    <div class="container">
        <form @submit.prevent="handleSubmit">
            <template v-for="field in ['make', 'model', 'registration']">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label :for="field">{{ capitalCase(field) }}:</label>
                        <input
                            :id="field"
                            :name="field"
                            type="text"
                            class="form-control"
                            v-model="formData[field]"
                        />
                    </div>
                </div>
            </template>
            <div class="buttonContainer">
                <button type="submit" class="btn btn-primary mt-3 mr-3">Submit</button>
                <button @click="clearForm" type="reset" class="btn btn-secondary mt-3">Clear</button>
            </div>
        </form>
    </div>
    <div class="container my-4">
        <div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                    <th scope="col">Registration</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(vehicle, index) in this.vehicles.data" :key="vehicle.id">
                    <th scope="row">{{ ++index }}</th>
                    <td>{{ vehicle.make }}</td>
                    <td>{{ vehicle.model }}</td>
                    <td>{{ vehicle.registration }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
