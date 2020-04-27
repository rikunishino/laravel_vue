export default {
  state: {
    corporationId: '',
    corporationName: '',
    mail: '',
    address: '',
    postal_code: '',
    tel: '',
    fax: ''
  },
  mutations: {
    setLoginCorporation(state, corporationInfo) {
      state.corporationId = corporationInfo[0].corporationId
      state.corporationName = corporationInfo[0].corporationName
      state.mail = corporationInfo[0].mail
      state.address = corporationInfo[0].address
      state.postal_code = corporationInfo[0].postal_code
      state.tel = corporationInfo[0].tel
      state.fax = corporationInfo[0].fax
    }
  }
}