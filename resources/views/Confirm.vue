<template>
  <div>
    <h2>購入確認</h2>
    <div>
            合計: {{ total }}(税込: {{ totalIncludedTax }})円
    </div>
  </div>
</template>

<script>
export default {
  name: 'Confirm',
  computed: {
    total() {
      return this.$store.state.total
    },
    totalIncludedTax() {
      return this.$store.state.totalIncludedTax
    }
  }
}
</script>