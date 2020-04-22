<template>
  <div>
    <button class="putProductDeleteThisCart" @click="putProductDeleteThisCart()">このカートをクリア</button>
    <button class="deleteThisCart" @click="deleteThisCart()">このカートを削除</button>
    小計: {{ total }}円
    <button class="showHideSwitchingButton" @click="showHideSwitching">{{ showOrHideMessage }}</button>
    <table class="putProductList" v-if="isContentsShow" @mouseup="dragEnd">
      <thead>
        <tr>
          <th>商品名</th>
          <th>値段(税抜)</th>
          <th>個数</th>
          <th>削除</th>
        </tr>
      </thead>
      <tbody v-for="(putProduct, index) in putProducts" :key="index">
        <tr>
          <td class="putProductName">{{ putProduct.product_name }}</td>
          <td class="putProductPrice">{{ putProduct.price }}</td>
          <td class="putProductAmount">
            <input type="text" :value="putProduct.amount"
              @input="amountValidation($event.target.value, index)"
              @change="replaceOne($event.target.value, index)"/>
            <div class="increaseOrDecrease">
              <button @click="changeAmount('+', index)">+</button>
              <button @click="changeAmount('-', index)">-</button>
            </div>
          </td>
          <td class="putProductDelete" @click="deleteProduct(index)"><button>X</button></td>
        </tr>
      </tbody>
    </table>
    <div class="dragAndDropArea" v-if="isContentsShow" @mouseup="dragEnd">
      <div class="dragAndDropAreaMsg">カートに入れる商品を掴んでここにドラッグ&amp;ドロップしてください</div>
    </div>
  </div>
</template>

<script>
// 最大および最小購入数
const MAX_AMOUNT = 99
const MIN_AMOUNT = 1

const SHOW_MESSAGE = 'カート内を表示する ▼'
const HIDE_MESSAGE = 'カート内を非表示にする ▲'

export default {
  name: 'Cart',
  props: ['isDrag', 'product', 'className'],
  data:function() {
    return {
      // カート内の商品
      putProducts: [],
      // 合計金額
      total: 0,
      // カート内の表示、非表示の切り替えメッセージ（デフォルト: 非表示）
      showOrHideMessage: HIDE_MESSAGE,
      // カートの中身を表示中かどうか
      isContentsShow: true
    }
  },
  methods: {
    /**
     * カートの中身の表示/非表示切り替え
     */
    showHideSwitching:function() {
      if(this.isContentsShow) {
        this.showOrHideMessage = SHOW_MESSAGE
        this.isContentsShow = false
      } else {
        this.showOrHideMessage = HIDE_MESSAGE
        this.isContentsShow = true
      }
    },
    /**
     * ドラッグ終了（カート外でドラッグを終了した場合は呼ばれない）
     */
    dragEnd: function() {
      if(!this.isDrag) {
        return
      }

      var index = this.checkDuplication(this.product.id)

      // すでにカートにある場合は個数を増加
      if(index >= 0) {
        if(this.putProducts[index].amount < MAX_AMOUNT) {
            this.$set(this.putProducts, index, {
                                                id: this.putProducts[index].id,
                                                className: this.putProducts[index].className,
                                                product_name: this.putProducts[index].product_name,
                                                price: this.putProducts[index].price,
                                                amount: parseInt(this.putProducts[index].amount) + 1
                                              })
          }
      } else {
        // カートに商品を追加
        this.$set(this.putProducts, this.putProducts.length, {
                                                              id: this.product.id,
                                                              className: this.className,
                                                              product_name: this.product.product_name,
                                                              price: this.product.price,
                                                              amount: 1
                                                            })
      }
      // this.putProductsLength = this.putProducts.length
      //合計金額算出
      this.totalPrice()
    },
    /**
     * カート内の商品と重複をチェック
     */
    checkDuplication: function(id) {
      for(var i = 0; i < this.putProducts.length; i++) {
        if((id === this.putProducts[i].id) && (this.className === this.putProducts[i].className)) {
          return i
        }
      }
      return -1
    },
    amountValidation: function(amount, index) {
      // フォーカス中は空文字を許可
      if(amount === '') {
        this.$set(this.putProducts, index, {
                                            id: this.putProducts[index].id,
                                            className: this.putProducts[index].className,
                                            product_name: this.putProducts[index].product_name,
                                            price: this.putProducts[index].price,
                                            amount: ''
                                          })
        return
      }

      // 購入範囲外の入力は受け付けない
      if(amount < MIN_AMOUNT || amount > MAX_AMOUNT) {
        return
      }

      // 自然数以外は「1」に置き換える
      if(amount.match('^[1-9][0-9]*$') != null) {
        this.$set(this.putProducts, index, {
                                            id: this.putProducts[index].id,
                                            className: this.putProducts[index].className,
                                            product_name: this.putProducts[index].product_name,
                                            price: this.putProducts[index].price,
                                            amount: parseInt(amount)
                                          })
      } else {
        this.$set(this.putProducts, index, {
                                            id: this.putProducts[index].id,
                                            className: this.putProducts[index].className,
                                            product_name: this.putProducts[index].product_name,
                                            price: this.putProducts[index].price,
                                            amount: 1
                                          })
      }
      // 合計金額の計算
      this.totalPrice()
    },
    /**
     * 空文字を「1」に置き換える
     */
    replaceOne: function(amount, index) {
      if(amount === '') {
        this.$set(this.putProducts, index, {
                                            id: this.putProducts[index].id,
                                            className: this.putProducts[index].className,
                                            product_name: this.putProducts[index].product_name,
                                            price: this.putProducts[index].price,
                                            amount: 1
                                          })
      }
      // 合計金額の計算
      this.totalPrice()
    },
    /**
     * 購入数変更
     */
    changeAmount: function(input, index) {
      switch(input) {
        case '+':
          if(this.putProducts[index].amount < MAX_AMOUNT) {
            this.$set(this.putProducts, index, {
                                                id: this.putProducts[index].id,
                                                className: this.putProducts[index].className,
                                                product_name: this.putProducts[index].product_name,
                                                price: this.putProducts[index].price,
                                                amount: parseInt(this.putProducts[index].amount) + 1
                                              })
          }
          break
        case '-':
          if(this.putProducts[index].amount > MIN_AMOUNT) {
            this.$set(this.putProducts, index, {
                                              id: this.putProducts[index].id,
                                              className: this.putProducts[index].className,
                                              product_name: this.putProducts[index].product_name,
                                              price: this.putProducts[index].price,
                                              amount: parseInt(this.putProducts[index].amount) - 1
                                            })
          }
          break
      }
      //合計金額算出
      this.totalPrice()
    },
    /**
     * カート内商品削除（1商品ずつ）
     */
    deleteProduct: function(index) {
      this.putProducts.splice(index, 1)
      //合計金額算出
      this.totalPrice()
    },
    /**
     * カート内商品削除（このカート内全て）
     */
    putProductDeleteThisCart: function() {
      this.putProducts.splice(0)
      //合計金額算出
      this.totalPrice()
    },
    /**
     * カートの削除
     */
    deleteThisCart: function() {
      this.$emit('deleteThisCart', this.className)
      //合計金額算出
      this.totalPrice()
    },
    /**
     * 合計金額の計算（クラス別）
     */
    totalPrice: function() {
      this.total = 0
      for(var i = 0; i < this.putProducts.length; i++) {
        this.total += this.putProducts[i].price * this.putProducts[i].amount
      }
      this.$emit('totalPrice', {className: this.className, totalPrice: this.total})
    }
  }
}
</script>

<style>
.showHideSwitchingButton {
  width: 150px;
  border: none;
  text-align: right;
}

/* .showHideSwitchingButton:focus {
  outline:0;
} */

.putProductList {
  list-style: none;
  margin-right: 5px;
  margin-left: 5px;
  border: solid 2px;
  border-collapse: collapse;
}

.putProductList th {
  width: 145px;
  border: solid 2px;
}

.dragAndDropArea {
  width: 596px;
  height: 100px;
  margin-right: 5px;
  margin-left: 5px;
  background-color: #ccccccab;
  text-align: center;
  border: solid 1px;
}

.dragAndDropAreaMsg {
  line-height: 100px;
}

.putProductList td {
  text-align: center;
}

.putProductId, .putProductName, .putProductPrice, .putProductDelete{
  border: solid 2px;
}

.putProductAmount {
  display: flex;
  box-shadow : 0 0 0 2px;
}

.increaseOrDecrease {
  display: flex;
  flex-direction: column;
}

.increaseOrDecrease button {
  width: 20px;
  height: 20px;
}
</style>