export default {
  state: {
    total: 0,
    totalIncludedTax: 0,
    classList: [],
    putProductsList: []
  },
  mutations: {
    setTotal: function(state, total) {
      state.total = total
    },
    setTotalIncludedTax: function(state, totalIncludedTax) {
      state.totalIncludedTax = totalIncludedTax
    },
    setClassList: function(state, classList) {
      state.classList = classList
    },
    setPutProductsList: function(state, putProductsList) {
      state.putProductsList = putProductsList
    }
  }
}