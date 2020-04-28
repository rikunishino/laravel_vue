<template>
  <div>
    {{ schoolId }}
    <AddCart v-on:addClass="addClass" :classList="classList"/>
    <button class="putProductDeleteAll" @click="deleteProductAll()">全カート削除</button>
    <div class="carts">
      クラス別カート 一覧
      <div v-for="(targetClass, index) in classList" :key="index">
        カートNo.{{ index + 1 }} クラス名: {{ targetClass.name }}
        <Cart :isDrag="isDrag" :product="product" :className="targetClass.name"
          :putProductsList="putProductsList" :cartIndex="index"
          v-on:totalPrice='totalPrice' v-on:deleteThisCart='deleteClass'
          v-on:createPutProductsList='createPutProductsList'/>
      </div>
    </div>
    <div class="total">
      合計: {{ totalWithComma }}(税込: {{ totalIncludedTaxWithComma }})円
    </div>
  </div>
</template>

<script>
// クラスごとのカート選択用
import AddCart from './AddCart.vue'
// カート
import Cart from './Cart.vue'

// 税率
const TAX_RATE = 10

export default {
  name: 'School',
  components: {
    AddCart,
    Cart
  },
  props: ['schoolsList', 'isDrag', 'product', 'schoolId'],
  data: function() {
    return {
      // 学校名
      schoolName: '',
      // クラスリスト
      classList: [],
      // カート内商品
      putProductsList: [],
      // 合計金額
      total: 0,
      // 合計金額（3桁区切り）
      totalWithComma: '0',
      // 税込
      totalIncludedTax: 0,
      // 合計金額（3桁区切り）
      totalIncludedTaxWithComma: '0',
    }
  },
  methods: {
    /**
     * クラス(カート)追加
     */
    addClass: function(className) {
      this.$set(this.classList, this.classList.length, {
                                                        name: className,
                                                        totalPrice: 0
                                                      })
    },
    /**
     * クラス(カート)削除
     */
    deleteClass: function(className) {
      for(var i = 0; i < this.classList.length; i++) {
        if(this.classList[i].name === className) {
          this.classList.splice(i, 1)
        }
      }
    },
    /**
     * 合計金額の計算
     */
    totalPrice: function(classList) {
      this.total = 0
      for(var i = 0; i < this.classList.length; i++) {
        if(this.classList[i].name === classList.className) {
          this.classList[i].totalPrice = classList.totalPrice
        }
        this.total += this.classList[i].totalPrice
      }
      this.totalIncludedTax = this.total + (this.total * TAX_RATE/100)

      // 3桁毎にカンマで区切る
      this.totalWithComma = this.addComma(this.total)
      this.totalIncludedTaxWithComma = this.addComma(this.totalIncludedTax)
    },
    /**
     * カート削除（全て）
     */
    deleteProductAll: function() {
      this.classList = []
      //合計金額算出
      this.totalPrice()
    },
    /**
     * 全カート内容の集計
     */
    createPutProductsList(putProducts) {
      for(var i = 0; i < this.putProductsList.length; i++) {
        // console.log(putProducts[0].className + ':' + this.putProductsList[i][0].className);
        if(putProducts[0].className === this.putProductsList[i][0].className) {
          this.$set(this.putProductsList, i, putProducts)
          this.$store.commit('setPutProductsList', this.putProductsList)
          return
        }
      }
      this.$set(this.putProductsList, this.putProductsList.length, putProducts)
      this.$store.commit('setPutProductsList', this.putProductsList)
    },
  }
}
</script>