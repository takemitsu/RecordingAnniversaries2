<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="panel panel-default">

          <div class="panel-body" v-if="loading">
            Loading...
          </div>

          <div v-if="error" class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error }}
            </div>
          </div>

          <table class="table table-bordered" v-if="users.length > 0">
            <thead>
              <tr>
                <th>uuid</th>
                <th>name</th>
                <th>email</th>
                <th>created_at</th>
                <th>updated_at</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users">
                <td>{{user.uuid}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{user.created_at}}</td>
                <td>{{user.updated_at}}</td>
              </tr>
            </tbody>
          </table>

          <div v-if="users.length == 0 && loading == false && error == null" class="alert alert-warning">
            not found users.
          </div>

          <div class="panel-body">
            <pagination :data="data" v-on:pagination-change-page="fetchData" style="margin: 0;"></pagination>
          </div>

        </div>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        loading: false,
        users: [],
        error: null,
        data: {
          total: 0,
        },
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
      fetchData (page) {
        var self = this

        if (typeof page === 'undefined') {
          page =1
        }

        self.error = null
        self.users = []
        self.loading = true

        return axios.get('/admin/api/user' + '?page=' + page)
          .then(function(response) {
            self.loading = false
            self.users = response.data.data
            self.data = response.data
          })
          .catch(function(error) {
            self.loading = false
            self.error = error.response.status + " : " + error.response.data.message

            if(error.response.status == 401) {
              // TODO: Redirect
            }
          })
      }
    }
  }
</script>