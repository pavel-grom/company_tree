<template>
    <div class="container">
        <h1>Tree example</h1>

        <tree
                :data="treeData"
                :options="treeOptions"
                ref="tree"
        />
    </div>
</template>

<script>
    export default {
        mounted() {
//            console.log(this.$refs.tree);
            this.$refs.tree.prepend(
                { full_name: 'My super Text' },              // search criteria
                'New CHILD Node for "My super Text"'    // this string will be converted to Node object with default state parameters
            );
            var app = this;
            axios.get('/api/employees/root')
                .then(function (res) {
                    console.log(res);
                    app.data = [res.data.data];
                })
                .catch(function (res) {
                    console.log(res);
                    alert("Error on load general director.");
                });
        },
        data(){
            return {
                data: [],
                treeData: this.getData(),
                treeOptions: {
                    propertyNames: {
                        text: 'full_name'
                    }
                }
            }
        },
        methods: {
            getData: function(){
                return this.data;
            }
        }
    }
</script>
