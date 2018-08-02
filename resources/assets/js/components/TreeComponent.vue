<template>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <v-jstree :data="asyncData" :async="loadData" allow-batch whole-row ref="tree" @item-click="itemClick" text-field-name="full_name"></v-jstree>
            </div>
            <div class="col-4 employee_info" v-if="employee">
                <div class="employee_name">Name: <span>{{ employee.full_name }}</span></div>
                <div class="employee_position">Position: <span>{{ employee.position.name }}</span></div>
                <div class="employee_wage">Wage: <span></span>{{ employee.wage }}</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        data: function (){
            return {
                data: [],
                employee: null,
                asyncData: [],
                loadData: function (oriNode, resolve) {
                    var app = this;
                    let data = [];

                    if (!app.employee) {
                        axios.get('/api/employees/root')
                            .then(function (res) {
                                res.data.data.icon = 'fa fa-user';
                                data = [res.data.data];
                                app.employee = res.data.data;

                                resolve(data);
                            })
                            .catch(function (res) {
                                console.log(res);
                                alert("Error on load.");
                                resolve(data);
                            });
                    } else {
                        axios.get('/api/employees/' + oriNode.data.id + '/children')
                            .then(function (res) {
                                for (var i = 0;i < res.data.data.length;i++) {
                                    res.data.data[i].icon = 'fa fa-user';
                                }
                                data = res.data.data;

                                resolve(data);
                            })
                            .catch(function (res) {
                                console.log(res);
                                alert("Error on load.");
                                resolve(data);
                            });
                    }
                },
            }
        },
        methods: {
            itemClick (node) {
                this.employee = node.model;
            }
        }
    }
</script>
