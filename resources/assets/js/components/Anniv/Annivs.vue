<style type="text/css">

  .group-row-line {
    border-top: 1px solid #ddd;
    margin-top: 10px;
    padding-top: 10px;
  }
  .group-row-line:first-child {
    border-top: none;
    margin-top: 0;
    padding-top: 0;
  }
  .annivs-row-line {
    border-top: 1px solid #d9d9d9;
    margin-top: 15px;
    padding-top: 15px;
  }
  .annivs-row-line:first-child {
    border-top: none;
    margin-top: 0;
    padding-top: 0;
  }
</style>

<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="panel panel-default" v-if="loading">
          <div class="panel-body">
            Loading...
          </div>
        </div>

        <div class="panel panel-error" v-if="error">
          <div class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error }}    <button type="button" class="btn btn-default btn-xs" @click="error = null">ok</button>
            </div>
          </div>
        </div>

        <div class="panel panel-default" v-if="groups.length == 0 && loading == false && error == null">
          <div  class="alert alert-warning" style="margin-bottom: 0;">
            not found groups.
          </div>
        </div>

        <div class="panel panel-info" v-for="(group, index) in groups">
          <div class="panel-heading">{{group.name}}</div>
          <div class="panel-body">
            <div class="row annivs-row-line" v-for="(anniv, ia) in group.annivs">
              <div class="col-sm-6">
                <span class="text-primary">{{anniv.name}}</span>
                <small style="color:#9d9d9d;">まで</small>
                <span class="text-danger">{{anniv.days_next}}</span>
                <small style="color:#9d9d9d;">日</small>
              </div>

              <div class="col-sm-6">
                {{anniv.anniv_at}} ({{anniv.anniv_at_wareki}})

                <span style="float:right;">{{anniv.diff_years}}年 ({{anniv.diff_years + 1}}年目)</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script type="text/javascript">
import Common from '../Common'
import moment from 'moment';

export default {
  data () {
    return {
      loading: false,
      groups: [],
      error: null,
    }
  },
  created () {
    // view が作られた時にデータを取得
    this.fetchData()
  },
  methods: {
    fetchData () {
      var self = this

      self.error = null
      self.groups = []
      self.loading = true

      return axios.get('/api/dashboard')
        .then(function(response) {
          self.loading = false
          self.groups = response.data

          for(var i = 0; i < self.groups.length; i++) {
            var group = self.groups[i]
            for(var j = 0; j < group.annivs.length; j++) {
              var anniv = group.annivs[j]
              var anniv_at = moment(anniv.anniv_at, 'YYYY-MM-DD')
              var diff = moment.duration(anniv_at.diff(moment().hour(0).minute(0).second(0).millisecond(0)))

              anniv.anniv_at = anniv_at.format('YYYY-MM-DD')
              anniv.anniv_at_wareki = Common.wareki(anniv.anniv_at, 1)
              anniv.diff_years = Math.abs(diff.years())
            }
          }

        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
  },
}
</script>
