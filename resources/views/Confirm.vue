<template>
  <div>
    <h2>購入確認</h2>
    <div>
      注文内容

    </div>
    <div>
      合計: {{ total }}(税込: {{ totalIncludedTax }})円
    </div>
    <button @click="purchaseConfirmation()">確定</button>
  </div>
</template>

<script>
export default {
  name: 'Confirm',
  data: function() {
    return {
      putProductsList: []
    }
  },
  mounted: function() {
    this.putProductsList = this.$store.state.order.putProductsList
  },
  computed: {
    total() {
      return this.$store.state.order.total
    },
    totalIncludedTax() {
      return this.$store.state.order.totalIncludedTax
    }
  },
  methods: {
    purchaseConfirmation: function() {
      // 注文情報作成
      // ordersテーブル
      var orderData = new FormData()
      orderData.append('corporationId', this.$store.state.auth.corporationId)
      orderData.append('corporationName', this.$store.state.auth.corporationName)
      orderData.append('mail', this.$store.state.auth.mail)
      orderData.append('address', this.$store.state.auth.address)
      orderData.append('postal_code', this.$store.state.auth.postal_code)
      orderData.append('tel', this.$store.state.auth.tel)
      orderData.append('fax', this.$store.state.auth.fax)
      orderData.append('totalPrice', this.$store.state.order.total)

      // orders_cartsテーブル
      var orderCartData = new FormData()
      var classList = this.$store.state.order.classList
      for(var i = 0; i < classList.length; i++) {
        orderCartData.append('cartName' + i, classList[i].name)
        orderCartData.append('subtotal' + i, classList[i].totalPrice)
      }
      orderCartData.append('classListLength', classList.length)

      // orders_itemsテーブル
      var orderItemData = new FormData()
      for(var i = 0; i < this.putProductsList.length; i++) {
        orderItemData.append('putProductsListLength' + i, this.putProductsList[i].length)
        for(var j = 0; j < this.putProductsList[i].length; j++) {
          // orderItemData.append('cartName' + i + ':' + j, putProductsList[i][j].className)
          orderItemData.append('productId' + i + ':' + j, this.putProductsList[i][j].id)
          orderItemData.append('amount'  + i + ':' + j, this.putProductsList[i][j].amount)
          // console.log(putProductsList[i][j].id)
        }
      }
      orderItemData.append('putProductsListLength', this.putProductsList.length)
      // console.log(this.$store.state.auth.schoolsList)



      // リクエスト送信
      // axios
      //   .post('/api/orders/', orderData)
      //   .then(response => {
      //     // console.log(response.data.order_id)
      //     orderCartData.append('order_id', response.data.order_id)
      //     orderItemData.append('order_id', response.data.order_id)
      //     axios
      //       .post('/api/orderCarts/', orderCartData)
      //       .then(response => {
      //       })
      //     axios
      //       .post('/api/orderItems/', orderItemData)
      //       .then(response => {
      //         console.log(response.data.message)
      //       })
      //   })
    }
  }
}
</script>