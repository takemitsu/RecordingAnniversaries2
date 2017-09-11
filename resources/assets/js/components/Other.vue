<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-danger">
          <div class="panel-heading">{{title}}</div>
          <div class="panel-body text-danger">
            {{message}}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
export default {
  data() {
    return {
      title: '',
      message: '',
    }
  },
  created () {
    this.checkRoute()
    this.startDatetime()
  },
  methods: {
    checkRoute() {
      this.title = "route not found"
      this.message = this.$route.path + " は存在しません"
    },
  }
}
</script>
