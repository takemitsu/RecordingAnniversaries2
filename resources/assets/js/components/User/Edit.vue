<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            Edit User
          </div>
          <div class="panel-body" v-if="loading">
            Loading...
          </div>
          <div v-if="error" class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error }}
            </div>
          </div>

          <div class="panel-body" v-if="user">
            <form class="form-horizontal">

              <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                  <input v-model="user.name" placeholder="name" class="form-control">
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                  <input v-model="user.email" placeholder="email" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" v-model="user.is_admin"> admin
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Created At</label>
                <div class="col-sm-9">
                  <p class="form-control-static">{{user.created_at}}</p>
                </div>
              </div>

              <div class="form-group" style="margin-bottom: 0;">
                <div class="col-sm-9 col-sm-offset-3">
                  <button @click="save" class="btn btn-primary">save</button>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Common from '../Common'

export default {
  data () {
    return {
      loading: false,
      user:  null,
      error: null,
    }
  },
  created () {
    // view が作られた時にデータを取得し、
    // そのデータは既に監視されています
    this.fetchData()
  },
  watch: {
    // ルートが変更されたらこのメソッドを再び呼び出します
    '$route': 'fetchData'
  },
  methods: {
    fetchData () {
      var self = this
      self.error = null
      self.user = null
      self.loading = true

      return axios.get('/admin/api/user/' + encodeURIComponent(this.$route.params.uuid))
        .then(function(response) {
          self.loading = false
          self.user = response.data
        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
    save() {
      var self = this
      self.loading = true
      self.error = null
      return axios({
          method: 'put',
          url: '/admin/api/user/' + encodeURIComponent(self.$route.params.uuid),
          data: self.user,
        })
        .then(function(response) {
          self.loading = false
          self.$router.push({ name:'users'})
        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
  }
}
</script>