<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component {{message}}</div>

                    <div class="panel-body">
                        I'm an example component!
                        <input v-model="message">
                        <div v-html="rawHtml"></div>
                        <button class="btn btn-primary" @click="onClick">button</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: 'Hello Vue!',
                rawHtml: "<b>Hoge</b>"
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            onClick: function () {
                window.alert(this.message)
            }
        }
    }
</script>
