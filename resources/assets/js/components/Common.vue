<script>
export default {
  errorMessage(error, self) {
    if(typeof self.loading !== 'undefined') {
      self.loading = false
    }

    if(typeof self.error !== 'undefined') {
      self.error = error.message
    }

    if(error.response) {
      if(error.response.status == 401) {
        window.location.href = "/login"
      }
      else if(typeof self.error !== 'undefined') {
        if(error.response.status == 422 && error.response.data && error.response.data.errors) {
          var err_messages = []
          var errors = error.response.data.errors
          for(var e in errors) {
            var err_strings = errors[e]
            for(var i in err_strings) {
              err_messages.push(err_strings[i])
            }
          }
          self.error = err_messages.join("\n")
        }
        else if(error.response.data && error.response.data.message) {
          self.error = error.response.data.message + " : " + error.response.status
        }
      }
    }
  },
  wareki(input, only_wareki_year) {
    // input は YYYY-MM-DD を想定。それ以外は考慮しない

    // 入力値のチェック

    if(typeof input === 'undefined')
      return ''

    if(input.length != 10)
      return ''

    var dates = input.split("-");
    if(dates.length != 3)
      return ''

    var date = parseInt(dates.join(""), 10)
    if(isNaN(date))
      return ''

    if(date.toString().length != 8)
      return ''

    if(parseInt(dates[0], 10) > 2099)
      return ''
    if(parseInt(dates[1], 10) > 12 || dates[1] == "00")
      return ''
    if(parseInt(dates[2], 10) > 31 || dates[2] == "00")
      return ''

    // 変換する

    dates[0] = parseInt(dates[0], 10)
    var wayear = 0
    var gengo = ""
    if(date >= 19890108) {
      gengo = '平成'
      wayear = dates[0] - 1988
    }
    else if (date >= 19261225) {
      gengo = '昭和'
      wayear = dates[0] - 1925
    }
    else if(date >= 19120730) {
      gengo = '大正'
      wayear = dates[0] - 1911
    }
    else if(date >= 18680125) {
      gengo = '明治'
      wayear = dates[0] - 1867
    }
    else
      return ''

    if(wayear == 1)
        wayear = '元'

    if(only_wareki_year)
      return gengo + wayear + '年'

    return gengo + wayear + '年' + dates[1] + '月' + dates[2] + '日'
  }
}
</script>
