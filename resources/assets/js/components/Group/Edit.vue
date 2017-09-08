<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            Edit Group
          </div>
          <div class="panel-body" v-if="loading">
            Loading...
          </div>
          <div v-if="error" class="panel-body">
            <div class="alert alert-danger" style="margin-bottom: 0;">
              {{ error }}
            </div>
          </div>

          <div class="panel-body" v-if="group">
            <form class="form-horizontal">

              <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                  <input v-model="group.name" placeholder="name" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Desc</label>
                <div class="col-sm-9">
                  <input v-model="group.desc" placeholder="description" class="form-control">
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
      group:  null,
      error: null,
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
          url: '/api/group/' + encodeURIComponent(self.$route.params.id),
          data: self.group,
        })
        .then(function(response) {
          self.loading = false
          self.$router.push({ name:'groups'})
        })
        .catch(function(error) {
          Common.errorMessage(error, self)
        })
    },
  }
}
</script>