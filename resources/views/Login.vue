<template>
  <div>
    <h1>ログイン</h1>
    <div>
      ログインID
      <input type="text" v-model="login_id"/>
    </div>
    <div>
      パスワード
      <input type="text" v-model="password"/>
    </div>
    <!-- <router-link to="/purchase">ログイン</router-link> -->
    <button @click="login()">ログイン</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // ユーザーID
      login_id: "",
      // パスワード
      password: "",
      // 会社情報
      corporations: []
    }
  },
  mounted() {
    console.log('response')
    axios.get('/corporation')
      .then(response => {
        this.corporations = response.data
        // console.log(response.data[0].password)
      });
  },
  methods: {
    login: function() {
      for(var i = 0; i < this.corporations.length; i++) {
        if(this.login_id === this.corporations[i].login_id
          && this.password === this.corporations[i].password) {
          // console.log('pass')
          this.$router.push('purchase')
        }
      }
    }
  }
}
</script>