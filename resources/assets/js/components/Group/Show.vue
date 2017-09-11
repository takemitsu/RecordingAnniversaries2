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
          <div class="panel-body" v-if="group">
            <div class="row">
              <div class="col-sm-8">
                <h3 style="margin:0; display: inline-block;">{{group.name}}</h3>
              </div>
              <div class="col-sm-4 text-right">
                <small style="color: lightgray;">最終更新日: {{group.updated_at}}</small>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9">{{group.desc}}</div>
              <div class="col-sm-3 text-right">
                <router-link :to="{name: 'group_edit', params:{id: group.id }}" class="btn btn-default btn-xs">編集</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 style="margin: 0 0 5px 10px;">Anniversaries <small v-if="group">({{group.annivs_count}})</small></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body" v-if="loading_annivs">
            Loading...
          </div>
          <div v-if="error_annivs" class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error_annivs }}    <button type="button" class="btn btn-default btn-xs" @click="error_annivs = null">ok</button>
            </div>
          </div>
          <div class="panel-body" v-if="annivs.length > 0">
            <template v-for="(anniv, index) in annivs">
              <div class="row" v-bind:class="{ 'group-row-line': index != 0 }">
                <div class="col-sm-8">
                  <span class="text-primary">{{anniv.name}}</span>
                  <small style="color:#9d9d9d;">まで</small>
                  <span class="text-danger">{{anniv.days_next}}</span>
                  <small style="color:#9d9d9d;">日</small>
                  <span style="margin-left: 10px;">{{anniv.diff_years}}年 ({{anniv.diff_years + 1}}年目)</span>
                </div>
                <div class="col-sm-4 text-right">
                  <small style="color: lightgray;">最終更新日: {{anniv.updated_at}}</small>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  {{anniv.anniv_at}} ({{anniv.anniv_at_wareki}})
                </div>
                <div class="col-sm-7">
                  <small style="color:#9d9d9d;">{{anniv.desc}}</small>
                </div>
                <div class="col-sm-2 text-right">
                  <router-link :to="{name: 'anniv_edit', params:{id: anniv.id }}" class="btn btn-default btn-xs">編集</router-link>
                  <button class="btn btn-danger btn-xs" @click="del_anniv(anniv)">削除</button>
                </div>
              </div>
            </template>
          </div>
          <div v-if="annivs.length == 0 && loading_annivs == false && error_annivs == null" class="alert alert-warning" style="margin-bottom: 0;">
            not found annivs.
          </div>
        </div>
        <router-link v-if="group" :to="{name: 'anniv_edit', params:{id: 'new'}, query:{gid: group.id }}" class="btn btn-primary">記念日追加</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import Common from '../Common'
import moment from 'moment';

export default {
  data () {
    return {
      loading: false,
      group:  null,
      error: null,
      annivs: [],
      loading_annivs: false,
      error_annivs: false,
    }
  },
  created () {
    this.fetchData()
  },
  watch: {
    '$route': 'fetchData'
  },
  methods: {
    fetchData () {
      var self = this
      self.error = null
      self.group = null
      self.loading = true

      return axios.get('/api/group/' + encodeURIComponent(this.$route.params.id))
        .then(function(response) {
          self.loading = false
          self.group = response.data
          self.fetchDataAnniv()
        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
    fetchDataAnniv() {
      var self = this
      self.error_annivs = null
      self.loading_annivs = true
      self.annivs = []

      return axios.get('/api/anniv/?group_id=' + encodeURIComponent(this.$route.params.id))
        .then(function(response) {
          self.loading_annivs = false
          self.annivs = response.data

          for (var i = 0; i < self.annivs.length; i++) {
            var anniv = self.annivs[i]
            var anniv_at = moment(anniv.anniv_at, 'YYYY-MM-DD')
            var diff = moment.duration(anniv_at.diff(moment().hour(0).minute(0).second(0).millisecond(0)))

            anniv.anniv_at = anniv_at.format('YYYY-MM-DD')
            anniv.anniv_at_wareki = Common.wareki(anniv.anniv_at, 1)
            anniv.diff_years = Math.abs(diff.years())
          }

        })
        .catch(function(error) {
          self.loading_annivs = false
          self.error_annivs = error.message

          if(error.response) {
            if(error.response.status == 401) {
              window.location.href = "/login"
            }
            if(error.response.data && error.response.data.message) {
              self.error_annivs = error.response.data.message + " : " + error.response.status
            }
          }
        })
    },
    // データ削除
    del_anniv(anniv) {
      if(confirm(anniv.name + " を削除しますか")) {
        var self = this
        self.error = null
        self.loading = true
        return axios({
            method:'delete',
            url: '/api/anniv/' + encodeURIComponent(anniv.id),
          })
          .then(function(response) {
            self.loading = false
            self.fetchDataAnniv()
          })
          .catch(function(error) {
            Common.errorMessage(error, self)
          })
      }
    }
  }
}
</script>