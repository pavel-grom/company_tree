<template>
    <div class="container">
        <li>
            <div
                    :class="{bold: isFolder}"
                    @click="toggle"
                    @dblclick="changeType">
                {{ model.name }}
                <span v-if="isFolder">[{{ open ? '-' : '+' }}]</span>
            </div>
            <ul v-show="open" v-if="isFolder">
                <item
                        class="item"
                        v-for="(model, index) in model.children"
                        :key="index"
                        :model="model">
                </item>
            </ul>
        </li>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                employees: [],
                open: false
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
        props: {
            model: Object
        },
        computed: {
            isFolder: function () {
                return this.model.children &&
                    this.model.children.length
            }
        },
        methods: {
            toggle: function () {
                if (this.isFolder) {
                    this.open = !this.open
                }
            },
            changeType: function () {
                if (!this.isFolder) {
                    Vue.set(this.model, 'children', [])
                    this.addChild()
                    this.open = true
                }
            },
            addChild: function () {
                this.model.children.push({
                    name: 'new stuff'
                })
            }
        }
    }
</script>
