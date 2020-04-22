import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    total: 0,
    totalIncludedTax: 0
  },
  mutations: {
    setTotal: function(state, total) {
      state.total = total
    },
    setTotalIncludedTax: function(state, totalIncludedTax) {
      state.totalIncludedTax = totalIncludedTax
    }
  }
})

export default store