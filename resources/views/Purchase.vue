<template>
  <div ref="purchasePage" class="purchasePage" @mousemove="dragging" @mouseup="reset">
    <!-- 商品一覧 -->
    <div class="productAndCart" v-if="!isConfirmActive">
      <div class="product">
        <h2>商品一覧</h2>
        <div class="subjectList">
          科目:
          <select v-model="subject">
            <option v-for="(item, index) in subjectList" :key="index">{{ item }}</option>
          </select>
        </div>
        <table class="productList">
          <thead>
            <tr>
              <th>商品名</th>
              <th>値段(税抜)</th>
            </tr>
          </thead>
          <tbody v-for="product in products" :key="product.id">
            <tr v-if="product.subject==subject"
              @mousedown="dragStart(product, $event)"
              @mouseover="mouseOver"
              @mouseleave="mouseLeave">
              <td ref="product">{{ product.name }}</td>
              <td>{{ product.price }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- カート -->
      <div class="cartArea">
        <h2>カート</h2>
        <AddCart v-on:addClass="addClass" :classList="classList"/>
        <button class="putProductDeleteAll" @click="deleteProductAll()">全カート削除</button>
        <div class="carts">
          クラス別カート 一覧
          <div v-for="(targetClass, index) in classList" :key="index">
            カートNo.{{ index + 1 }} クラス名: {{ targetClass.name }}
            <Cart :isDrag="isDrag" :product="product" :className="targetClass.name"
              v-on:totalPrice='totalPrice' v-on:deleteThisCart='deleteClass'/>
          </div>
        </div>
        <div class="total">
          合計: {{ total }}(税込: {{ totalIncludedTax }})円
        </div>
        <button class="toConfirmButton" @click="toConfirm()" v-if="!isConfirmActive">確認画面に進む</button>
      </div>
    </div>
    <Confirm :total="total" :totalIncludedTax="totalIncludedTax" v-if="isConfirmActive" />
  </div>
</template>

<script>
// クラスごとのカート選択用
import AddCart from '../js/components/purchase/AddCart.vue'
// カート
import Cart from '../js/components/purchase/Cart.vue'
// 確認画面
import Confirm from '../js/components/purchase/Confirm.vue'
// 選択中の科目
var selectedSubject = '国語';

// 商品の要素
var productElement = null
// アニメーション用の商品要素クローン
var productClone = null

// 購入ページの要素
var purchasePageElement = null

// 税率
const TAX_RATE = 0.1
// 最大および最小購入数
const MAX_AMOUNT = 99
const MIN_AMOUNT = 1

export default {
  components: {
    AddCart,
    Cart,
    Confirm
  },
  data() {
    return {
      // 確認画面を表示するか
      isConfirmActive: false,
      // クラスリスト
      classList: [],
      // 商品一覧
      products: [
        {id: '0', sort_num: 0, subject: '国語', name: '国語の教科書', price: 2400, amount: 0},
        {id: '1', sort_num: 1, subject: '国語', name: '国語のドリル', price: 1500, amount: 0},
        {id: '2', sort_num: 2, subject: '国語', name: '国語のノート', price: 700, amount: 0},
        {id: '3', sort_num: 0, subject: '算数', name: '算数の教科書', price: 2600, amount: 0},
        {id: '4', sort_num: 1, subject: '算数', name: '算数のドリル', price: 1800, amount: 0},
        {id: '5', sort_num: 2, subject: '算数', name: '算数のドリル2', price: 1600, amount: 0},
        {id: '6', sort_num: 3, subject: '算数', name: '算数のノート', price: 600, amount: 0},
        {id: '7', sort_num: 0, subject: '英語', name: '英語の教科書', price: 1200, amount: 0},
        {id: '8', sort_num: 1, subject: '英語', name: '英語のドリル', price: 1100, amount: 0},
        {id: '9', sort_num: 2, subject: '英語', name: '英語のノート', price: 700, amount: 0},
        {id: '10', sort_num: 0, subject: '理科', name: '理科の教科書', price: 3000, amount: 0},
        {id: '11', sort_num: 1, subject: '理科', name: '理科のノート', price: 900, amount: 0},
        {id: '12', sort_num: 0, subject: '社会', name: '社会の教科書', price: 2800, amount: 0},
        {id: '13', sort_num: 1, subject: '社会', name: '社会のノート', price: 800, amount: 0}
      ],
      // 商品
      product: null,

      // ドラッグしているかどうか
      isDrag:false,

      // 科目リスト
      subjectList: [],

      // 表示中の科目
      subject: selectedSubject,

      // カート内商品
      putProducts: [],

      // 合計金額
      total: 0,
      // 税込
      totalIncludedTax: 0
    }
  },
  mounted: function() {
    // 商品の要素取得
    productElement = this.$refs.product
    purchasePageElement = this.$refs.purchasePage

    this.getData()
  },
  methods: {
    /**
     * DBからデータを取得
     */
    getData: function() {
      axios.get('/subject')
      .then(response => {
        for(var i = 0; i < response.data.length; i++) {
          this.$set(this.subjectList, i, response.data[i].name)
        }
      });
    },
    /**
     * クラス追加
     */
    addClass: function(className) {
      this.$set(this.classList, this.classList.length, {
                                                        name: className,
                                                        totalPrice: 0
                                                      })
    },
    deleteClass: function(className) {
      for(var i = 0; i < this.classList.length; i++) {
        if(this.classList[i].name === className) {
          this.classList.splice(i, 1)
        }
      }
    },
    /**
     * ドラッグ開始
     */
    dragStart: function(targetProduct) {
      if(productClone != null) {
        productClone.remove()
      }
      // フラグ更新
      this.isDrag = true

      // 選択された商品をセット
      this.product = targetProduct

      // アニメーション用のクローン作成
      productClone = productElement[this.product.sort_num].cloneNode(true)
      productClone.style.position = 'absolute'
      productClone.style.top = event.pageY + 10 + 'px'
      productClone.style.left = event.pageX + 10 + 'px'
      purchasePageElement.appendChild(productClone)
    },
    /**
     * ドラッグ中
     */
    dragging: function() {
      if(!this.isDrag) {
        return
      }
      productClone.style.top = event.pageY + 10 + 'px'
      productClone.style.left = event.pageX + 10 + 'px'
    },
    /**
     * ドラッグ終了（カート外でドラッグを終了した場合は呼ばれない）
     */
    dragEnd: function() {
      this.isDrag = false
    },
    /**
     * ドラッグ終了時のリセット処理
     */
    reset: function() {
      this.product = null
      this.isDrag = false
      if(productClone != null) {
        productClone.remove()
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
      this.totalIncludedTax = this.total + (this.total * TAX_RATE)
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
     * 確認画面への遷移
     */
    toConfirm: function() {
      this.isConfirmActive = true
    },
    /**
     * テーブル要素にカーソルが重なった際
     */
    mouseOver: function() {
      var productRow = event.currentTarget
      var productData = productRow.children
      for(var i = 0; i < productData.length; i++) {
        productData[i].style.border = "solid 2px #25afff"
      }
    },
    /**
     * テーブル要素からカーソルが離れた際
     */
    mouseLeave: function() {
      var productRow = event.currentTarget
      var productData = productRow.children
      for(var i = 0; i < productData.length; i++) {
        productData[i].style.border = "solid 2px #b9b9b9"
      }
    }
  }
}
</script>

<style>
/*
    親要素
*/

.productAndCart {
  display: flex;
}

/*
    商品一覧
*/
.product {
  width: 500px;
  height: 900px;
  border: solid 3px;
}

.product h2 {
  margin-left: 10px;
}

.product .subjectList {
  margin-left: 50px;
}

.productList {
  list-style: none;
  user-select: none;
  margin-left: 50px;
  border: solid 2px;
  /* border-collapse: collapse; */
}

.productList th, .productList td {
  border: solid 2px #b9b9b9;
}

.productList td {
  width: 158px;
  text-align: center;
  border: solid 2px #b9b9b9;
}

/*
    カート
*/
.cartArea {
  position: relative;
  width: 640px;
  height: 900px;
  margin-left: 30px;
  border: solid 3px;
}

.cartArea h2 {
  margin-left: 10px;
}

.carts {
  width: 640px;
  height: 680px;
  border: solid 1px;
  overflow: scroll;
}

.total {
  position: absolute;
  bottom: 0;
  font-size: 20px;
}

/*
    確認画面に進むボタン
*/
.toConfirmButton {
  width: 300px;
  height: 50px;
  position: absolute;
  right: 0;
  bottom: 0;
  font-size: 30px;
  background-color: #0044ff;
  color: #ffffff;
  border-radius: 10px;
}
</style>