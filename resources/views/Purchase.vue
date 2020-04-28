<template>
  <div ref="purchasePage" class="purchasePage" @mousemove="dragging" @mouseup="reset">
    ID: {{ corporationId }} 法人名: {{ corporationName }}
    <!-- 商品一覧 -->
    <div class="productAndCart">
      <div class="product">
        <h2>商品一覧</h2>
        <div class="subjectList">
          科目:
          <select @change="selectSubject()">
            <option v-for="(item, index) in subjectList" :key="index">{{ item.name }}</option>
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
            <tr v-if="product.subject_id==subjectId"
              @mousedown="dragStart(product, $event)"
              @mouseover="mouseOver"
              @mouseleave="mouseLeave">
              <td ref="product">{{ product.product_name }}</td>
              <td>{{ product.price }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- カート -->
      <div class="cartArea">
        <h2>カート</h2>
        <ChangeSchool :schoolsList="schoolsList" :schoolId="schoolId" v-on:selectSchool="selectSchool"/>
        schoolId{{schoolId}}
        <div v-for="(item, index) in schoolsList" :key="index">
          <School v-show="schoolId==item.id" :isDrag="isDrag" :product="product" :schoolId="schoolId"/>
          <!-- <School :isDrag="isDrag" :product="product" :schoolId="schoolId"/> -->
        </div>
        <button class="toConfirmButton" @click="toConfirm()">確認画面に進む</button>
      </div>
    </div>
  </div>
</template>

<script>
// 対象の学校選択用
import ChangeSchool from '../js/components/purchase/ChangeSchool.vue'
// 学校
import School from '../js/components/purchase/School.vue'

// 商品の要素
var productElement = null
// アニメーション用の商品要素クローン
var productClone = null

// 購入ページの要素
var purchasePageElement = null

// 税率
const TAX_RATE = 10
// 最大および最小購入数
const MAX_AMOUNT = 99
const MIN_AMOUNT = 1

export default {
  components: {
    ChangeSchool,
    School,
    // AddCart,
    // Cart
  },
  data() {
    return {
      // 学校リスト
      schoolsList: [],
      // クラスリスト
      //classList: [],
      // 商品一覧
      products: [],

      // 商品
      product: null,

      // ドラッグしているかどうか
      isDrag:false,

      // 科目リスト
      subjectList: [],

      // 表示中の科目ID
      subjectId: null,

      // 選択中の学校ID
      schoolId: null
    }
  },
  mounted: function() {
    this.getData()
    purchasePageElement = this.$refs.purchasePage
  },
  computed: {
    corporationId() {
      return this.$store.state.auth.corporationId
    },
    corporationName() {
      return this.$store.state.auth.corporationName
    }
  },
  methods: {
    /**
     * DBからデータを取得
     */
    getData: function() {
      // 科目データの取得
      axios.get('/subject')
      .then(response => {
        for(var i = 0; i < response.data.length; i++) {
          // デフォルト値の設定
          if(i === 0) {
            this.subjectId = response.data[i].id
          }
          this.$set(this.subjectList, i, response.data[i])
        }
      });

      // 商品データの取得
      axios.get('/product')
      .then(response => {
        for(var i = 0; i < response.data.length; i++) {
          this.$set(this.products, i, response.data[i])
        }
      });

      // 学校リストの取得（DBからはログイン時に取得済）
      for(var i = 0; i < this.$store.state.auth.schoolsList.length; i++) {
        // デフォルト値の設定
        if(i === 0) {
          this.schoolId = this.$store.state.auth.schoolsList[i].id
        }
        this.$set(this.schoolsList, i, this.$store.state.auth.schoolsList[i])
      }
    },
    /**
     * 科目変更
     */
    selectSubject: function() {
      for(var i = 0; i < this.subjectList.length; i++) {
        if(event.target.value === this.subjectList[i].name) {
          this.subjectId = this.subjectList[i].id
        }
      }
    },
    /**
     * 学校変更
     */
    selectSchool: function(id) {
      this.schoolId = id
    },
    /**
     * ドラッグ開始
     */
    dragStart: function(targetProduct) {
      // 商品の要素取得
      productElement = this.$refs.product

      if(productClone != null) {
        productClone.remove()
      }
      // フラグ更新
      this.isDrag = true

      // 選択された商品をセット
      this.product = targetProduct

      // アニメーション用のクローン作成
      productClone = productElement[this.product.sort_no].cloneNode(true)
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
     * 確認画面への遷移
     */
    toConfirm: function() {
      this.$store.commit('setTotal', this.total)
      this.$store.commit('setTotalIncludedTax', this.totalIncludedTax)
      this.$store.commit('setClassList', this.classList)
      this.$router.push('confirm')
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