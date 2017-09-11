<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            Edit Anniv
          </div>
          <div class="panel-body" v-if="loading">
            Loading...
          </div>
          <div v-if="error" class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error }}
            </div>
          </div>

          <div class="panel-body" v-if="anniv">
            <form class="form-horizontal">

              <div class="form-group">
                <label class="col-sm-3 control-label">Group</label>
                <div class="col-sm-9">
                  <select v-model="anniv.group_id" class="form-control">
                    <option v-for="g in groups" v-bind:value="g.id">{{g.name}}</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                  <input v-model="anniv.name" placeholder="name" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Desc</label>
                <div class="col-sm-9">
                  <input v-model="anniv.desc" placeholder="description" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Anniv_at</label>
                <div class="col-sm-9">
                  <div class="form-inline">
                    <select v-model="dates[0]" class="form-control">
                      <option v-for="y in years">{{y}}</option>
                    </select>
                    年
                    <select v-model="dates[1]" class="form-control">
                      <option v-for="m in months">{{m}}</option>
                    </select>
                    月
                    <select v-model="dates[2]" class="form-control">
                      <option v-for="d in days">{{d}}</option>
                    </select>
                    日
                  </div>
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
<script type="text/javascript">
import Common from '../Common'
import moment from 'moment'

export default {
  data () {
    return {
      loading: false,
      anniv:  null,
      error: null,
      dates: moment().format('YYYY-MM-DD').toString().split('-'),
      years: [],
      months: [],
      days: [],
      groups: [],
    }
  },
  created () {
    this.initialize()
    this.fetchData()
  },
  watch: {
    '$route': 'fetchData'
  },
  methods: {
    initialize() {
      var years = []
      for(var i = 1900; i <= moment().year(); i++)
        years.push(i)
      this.years = years

      var months = []
      for(var i = 1; i <= 12; i++)
        months.push(i)
      this.months = months

      var days = []
      for(var i = 1; i <= 31; i++)
        days.push(i)
      this.days = days

      var groups = []
      var self = this
      axios.get('/api/group')
      .then(function(response) {
        self.groups = response.data
      })
      .catch(function(error) {
        Common.errorMessage(error, self)
      })
    },
    fetchData () {
      var self = this
      self.error = null
      self.anniv = null
      self.loading = true

      return axios.get('/api/anniv/' + encodeURIComponent(this.$route.params.id))
        .then(function(response) {
          self.loading = false
          self.anniv = response.data
          // 編集
          var anniv_at = moment(self.anniv.anniv_at, 'YYYY-MM-DD')
          self.dates = anniv_at.format('YYYY-MM-DD').toString().split('-')
          for(var i = 0; i < self.dates.length; i++) {
            self.dates[i] = parseInt(self.dates[i], 10)
          }
          self.anniv.anniv_at = anniv_at.format('YYYY-MM-DD')

        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
    save() {
      var self = this
      self.error = null

      console.log(self.anniv)

      // 年月日合体
      var anniv_at = moment(self.dates.join('-'),'YYYY-M-D')
      if(anniv_at.isValid() == false) {
        self.error = "有効な日付を入力してください。"
        return
      }
      self.anniv.anniv_at = anniv_at.format('YYYY-MM-DD')

      self.loading = true
      return axios({
          method: 'put',
          url: '/api/anniv/' + encodeURIComponent(self.$route.params.id),
          data: self.anniv,
        })
        .then(function(response) {
          self.loading = false
          if(self.anniv.group_id != 0)
            self.$router.push({ name:'group', params: {id:self.anniv.group_id}})
          else
            self.$router.push({name:"annivs"})
        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
  }
}
</script>
