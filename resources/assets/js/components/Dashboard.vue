<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{title}}</div>
          <div class="panel-body">
            {{message}} - <b>{{now}}</b>
              <button class="btn btn-danger btn-xs" v-if="interval" @click="stopDatetime()">stop</button>
              <button class="btn btn-primary btn-xs" v-if="interval == null" @click="startDatetime()">start</button>
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
      now: moment().format('YYYY-MM-DD HH:mm:ss'),
      interval: null,
    }
  },
  created () {
    this.checkRoute()
    this.startDatetime()
  },
  mounted() {
    // this.checkRoute('mounted')
  },
  watch: {
    // ルートが変更されたらこのメソッドを再び呼び出します
    '$route': 'checkRoute'
  },
  methods: {
    checkRoute() {
      if(this.$route.path != '/dashboard' && this.$route.path != '/') {
        this.title = "not found"
        this.message = this.$route.path + " は存在しません"
      }
      else {
        this.title = "Dashboard"
        this.message = "Wellcome"
      }
    },
    startDatetime() {
      var self = this
      if(self.interval != null)
        clearInterval(self.interval)

      self.now = moment().format('YYYY-MM-DD HH:mm:ss')
      self.interval = setInterval(function() {
        self.now = moment().format('YYYY-MM-DD HH:mm:ss')
      }, 1000)
    },
    stopDatetime() {
      clearInterval(this.interval)
      this.interval = null
    }
  }
}
</script>
