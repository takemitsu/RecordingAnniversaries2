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

          <div v-if="status" class="panel-body">
            <div class="alert alert-success" style="margin-bottom: 0;">
              {{ status }}
            </div>
          </div>

          <table class="table table-bordered" v-if="users.length > 0">
            <thead>
              <tr>
                <th>name</th>
                <th>email</th>
                <th>created_at</th>
                <th>updated_at</th>
                <th>action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users">
                <td>
                  <router-link :to="{name: 'user', params:{uuid: user.uuid }}">{{user.name}}</router-link>
                </td>
                <td>{{user.email}}</td>
                <td>{{user.created_at}}</td>
                <td>{{user.updated_at}}</td>
                <td>
                  <router-link :to="{name: 'user', params:{uuid: user.uuid }}" class="btn btn-default btn-xs">編集</router-link>
                  <button class="btn btn-danger btn-xs" @click="del(user)">削除</button>
                </td>
              </tr>
            </tbody>
          </table>

          <div v-if="users.length == 0 && loading == false && error == null" class="alert alert-warning" style="margin-bottom: 0;">
            not found users.
          </div>

          <div class="panel-body" v-if="users.length > 0">
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
        status: null,
        data: {
          total: 0,
        },
        page: 1,
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
          page = 1
        }

        self.error = null
        self.users = []
        self.loading = true

        return axios.get('/admin/api/user' + '?page=' + page)
          .then(function(response) {
            self.loading = false
            self.users = response.data.data
            self.data = response.data
            self.page = self.data.current_page
            // 最後のページで削除されたときのアレ
            if(response.data.current_page != 1 && self.users.length == 0) {
              self.fetchData(response.data.current_page - 1)
            }
          })
          .catch(function(error) {
            self.loading = false
            self.error = error.response.status + " : " + error.response.data.message

            if(error.response.status == 401) {
              // TODO: Redirect
            }
          })
      },

      // ユーザ削除
      del(user) {
        if(confirm(user.name + " を削除しますか")) {
          var self = this
          return axios({
              method:'delete',
              url: '/admin/api/user/' + encodeURIComponent(user.uuid),
            })
            .then(function(response) {
              self.fetchData(self.page)
            })
            .catch(function(error) {
              self.loading = false
              self.error = error.response.status + " : " + error.response.data.message

              if(error.response.status == 401) {
                // TODO: Redirect
              }
            })
        }
      },
    }
  }
</script>