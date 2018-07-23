<template>
    <div class="container">
        <v-jstree :data="data" @item-click="itemClick" text-field-name="full_name"></v-jstree>
    </div>
</template>

<script>
    export default {
        mounted() {
            var app = this;
            axios.get('/api/employees/root')
                .then(function (res) {
                    console.log([res.data.data]);
//                    app.data = [res.data.data];
//                    app.data[0].opened = true;
                })
                .catch(function (res) {
                    console.log(res);
                    alert("Error on load general director.");
                });


        },
        data: function (){
            return {
                data: [
                    {
                        "full_name": "Same but with checkboxes",
                        "children": [
                            {
                                "full_name": "initially selected",
                                "selected": true
                            },
                            {
                                "full_name": "custom icon",
                                "icon": "fa fa-warning icon-state-danger"
                            }
                        ]
                    }
                ]
            }
        },
        methods: {
            itemClick (node) {
                console.log(node.model.full_name + ' clicked !')
            }
        }
    }
</script>
