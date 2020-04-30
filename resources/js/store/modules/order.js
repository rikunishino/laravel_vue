export default {
  state: {
    // 合計（全学校分）
    total: 0,
    // 合計（税込み）
    totalIncludedTax: 0,
    classList: [],
    putProductsList: [],
    sPutProductsList: [],
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
    },
    setSPutProductsList: function(state, sPutProductsList) {
      state.sPutProductsList = sPutProductsList
    },
  }
}