<template>
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">{{title}}</div>
          <div class="panel-body">
            {{message}}
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
      title: '',
      message: '',
    }
  },
  created () {
    this.checkRoute()
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
    }
  }
}
</script>
