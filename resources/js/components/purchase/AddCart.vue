<template>
  <div>
    <div>
      <p>クラス名を入力して、「カートを作成」を押下してください。</p>
      クラス名:
      <input type="text" v-model="className"/>
      <button @click="addClass">カートを作成</button>
      <div class="errorMessage">
        {{ classNameError }}
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: 'AddCart',
  props: ['classList'],
  data: function() {
    return {
      className: '',
      classNameError: ''
    }
  },
  methods: {
    /**
     * クラス追加
     */
    addClass: function() {
      // 同名クラスが存在する場合はエラーメッセージを表示
      this.classNameError = this.classNameValidation()
      if(this.classNameError === '') {
        this.$emit('addClass', this.className)
      }
      this.className = ''
    },
    /**
     * クラス名のバリデーションチェック
     */
    classNameValidation: function() {
      if(this.className === '') {
        return 'クラス名を入力してください。'
      }

      for(var i = 0; i < this.classList.length; i++) {
        if(this.classList[i].name === this.className) {
          return '同名のクラスが存在します。'
        }
      }
      return ''
    }
  }
}
</script>

<style>
.errorMessage {
  color: red;
}
</style>