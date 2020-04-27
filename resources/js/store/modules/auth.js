export default {
  state: {
    corporationId: '',
    corporationName: '',
    mail: '',
    address: '',
    postal_code: '',
    tel: '',
    fax: '',
    schoolsList: []
  },
  mutations: {
    /**
     * ログインした法人情報をセット
     *
     * @param {*} state
     * @param {*} corporationInfo 法人情報
     */
    setLoginCorporation(state, corporationInfo) {
      state.corporationId = corporationInfo[0].corporationId
      state.corporationName = corporationInfo[0].corporationName
      state.mail = corporationInfo[0].mail
      state.address = corporationInfo[0].address
      state.postal_code = corporationInfo[0].postal_code
      state.tel = corporationInfo[0].tel
      state.fax = corporationInfo[0].fax
    },
    /**
     * ログインした法人に紐づく学校情報をセット
     *
     * @param {*} state
     * @param {*} schoolsList 学校情報
     */
    setSchoolsList(state, schoolsList) {
      state.schoolsList = schoolsList
    }
  }
}