<template>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <v-jstree
                        :data="asyncData"
                        :async="loadData"
                        allow-batch
                        whole-row
                        ref="tree"
                        @item-click="itemClick"
                        text-field-name="full_name"
                ></v-jstree>
            </div>
            <div class="col-4 employee_info" v-if="employee && !$auth.check()">
                <div class="employee_name">Full name: <span>{{ employee.full_name }}</span></div>
                <div class="employee_position">Position: <span>{{ employee.position.name }}</span></div>
                <div class="employee_wage">Wage: <span></span>{{ employee.wage }}</div>
            </div>
            <div class="col-4 employee_info" v-if="employee && $auth.check()">
                <form>
                    <div class="form-group">
                        <label for="full_name">Full name</label>
                        <input type="text" class="form-control" id="full_name" :value="employee.full_name">
                    </div>
                    <div class="form-group">
                        <label for="position_id">Position</label>
                        <select class="form-control" id="position_id">
                            <option
                                    v-for="position in positions"
                                    :value="position.id"
                                    :selected="employee.position_id === position.id"
                            >
                                {{ position.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="wage">Wage</label>
                        <input type="number" class="form-control" id="wage" :value="employee.wage">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            var app = this;
            axios.get('/api/positions')
                .then(function (res) {
                    app.positions = res.data.data;
                })
                .catch(function (res) {
                    console.log(res);
                    alert("Error on load.");
                });
        },
        data: function (){
            return {
                data: [],
                employee: null,
                positions: [],
                asyncData: [],
                loadData: function (oriNode, resolve) {
                    var app = this;
                    let data = [];

                    if (!app.employee) {
                        axios.get('/api/employees/root')
                            .then(function (res) {
                                for (var i = 0;i < res.data.data.length;i++) {
                                    res.data.data[i].icon = 'fa fa-user';
                                }
                                data = res.data.data;
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
