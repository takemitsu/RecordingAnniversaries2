<style type="text/css">
  .group-row-line {
    border-top: 1px solid #ddd;
    margin-top: 10px;
    padding-top: 10px;
  }
</style>

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
              {{ error }}    <button type="button" class="btn btn-default btn-xs" @click="error = null">ok</button>
            </div>
          </div>

          <div class="panel-body" ng-if="groups.length > 0">
            <template v-for="(group, index) in groups">
              <div class="row" v-bind:class="{ 'group-row-line': index != 0 }">
                <div class="col-sm-8">
                  <router-link :to="{name: 'group', params:{id: group.id }}">{{group.name}}</router-link>
                  <span v-if="group.annivs_count > 0"><small style="color:lightgray;">登録数: </small>{{group.annivs_count}}</span>
                </div>
                <div class="col-sm-4 text-right">
                  <small style="color: lightgray;">最終更新日: {{group.updated_at}}</small>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-9">{{group.desc}}</div>
                <div class="col-sm-3 text-right">
                  <router-link :to="{name: 'group_edit', params:{id: group.id }}" class="btn btn-default btn-xs">編集</router-link>
                  <button class="btn btn-danger btn-xs" @click="del(group)">削除</button>
                </div>
              </div>
            </template>
          </div>

          <div v-if="groups.length == 0 && loading == false && error == null" class="alert alert-warning" style="margin-bottom: 0;">
            not found groups.
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
        groups: [],
        error: null,
        data: {
          total: 0,
        },
      }
    },
    created () {
      // view が作られた時にデータを取得
      this.fetchData()
    },
    watch: {
      // ルートが変更されたらこのメソッドを再び呼び出す
      '$route': 'fetchData'
    },
    methods: {
      fetchData () {
        var self = this

        self.error = null
        self.groups = []
        self.loading = true

        return axios.get('/api/group')
          .then(function(response) {
            self.loading = false
            self.groups = response.data
          })
          .catch(function(error) {
            Common.errorMessage(error, self)
          })
      },

      // データ削除
      del(group) {
        if(confirm(group.name + " を削除しますか")) {
          var self = this
          self.error = null
          self.loading = true
          return axios({
              method:'delete',
              url: '/api/group/' + encodeURIComponent(group.id),
            })
            .then(function(response) {
              self.loading = false
              self.fetchData()
            })
            .catch(function(error) {
              Common.errorMessage(error, self)
            })
        }
      },
    }
  }
</script>
