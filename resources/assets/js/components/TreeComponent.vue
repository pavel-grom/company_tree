<template>
    <div class="container">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item" v-for="employee in employees">
                    {{ employee.full_name }}
                    <ul v-if="employee.children" v-for="children in employee.children">
                        <li>
                            {{ children.full_name }}
                            <button class="btn btn-link" v-if="employee.children" v-on:click="expand(children.id)">&darr;</button>
                            <ul v-if="children.children" v-for="children in employee.children.children">
                                <li>
                                    {{ children.children.full_name }}
                                    <button class="btn btn-link" v-if="employee.children.children" v-on:click="expand(children.children.id)">&darr;</button>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                employees: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/employees/root')
                .then(function (res) {
                    app.employees.push(res.data.data);
                })
                .catch(function (res) {
                    console.log(res);
                    alert("Error on load general director.");
                });
        },
        methods: {
            expand: function (id) {
                var app = this;
                axios.get('/api/employees/' + id + '/children')
                    .then(function (res) {
                        for (var i = 0; i <= res.data.data.length - 1; i++) {
                            app.employees.push(res.data.data[i]);
                        }
                    })
                    .catch(function (res) {
                        console.log(res);
                        alert("Error on load general director.");
                    });
            }
        }
    }
</script>
