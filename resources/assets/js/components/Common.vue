<script>
export default {
  hoge() {
    console.log('hoge')
  },
  errorMessage(error, self) {

    if(typeof self.loading !== 'undefined')
      self.loading = false

    if(typeof self.error !== 'undefined')
      self.error = error.message

    if(error.response)
      if(error.response.status == 401)
        window.location.href = "/login"
  }
}
</script>
