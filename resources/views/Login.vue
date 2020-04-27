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
    // console.log('response')
    axios.get('/corporation')
      .then(response => {
        this.corporations = response.data
      });
  },
  methods: {
    login: function() {
      for(var i = 0; i < this.corporations.length; i++) {
        // IDおよびバスワードが一致したらログイン成功
        if(this.login_id === this.corporations[i].login_id
          && this.password === this.corporations[i].password) {
          // 法人情報を保持
          this.$store.commit('setLoginCorporation', [
            {
              corporationId: this.corporations[i].id,
              corporationName: this.corporations[i].name,
              mail: this.corporations[i].mail,
              address: this.corporations[i].address,
              postal_code: this.corporations[i].postal_code,
              tel: this.corporations[i].tel,
              fax: this.corporations[i].fax,
            }
          ])
          // ログインした法人に紐づく学校情報を取得
          axios.get('/api/schools/' + this.corporations[i].id)
            .then(response => {
              // 学校情報を保持
              this.$store.commit('setSchoolsList', response.data)

              // 購入画面に遷移
              this.$router.push('purchase')
            });
        }
      }
    }
  }
}
</script>